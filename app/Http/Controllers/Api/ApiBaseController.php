<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use ArturJr\PrestoClient\ClientSession;
use ArturJr\PrestoClient\ResultsSession;
use ArturJr\PrestoClient\StatementClient;

class ApiBaseController extends Controller
{
    private $clientSession;
    private $statementClient;
    private $resultSession;
    private $catalog;
    private $host;
    private $schema;
    private $table;
    private $dataResponse = ['status' => 'success', 'message' => 'Loaded response.', 'data' => []];
    private $query;
    private $filter = [];

    public function __construct()
    {
        $this->host = config('presto.presto.host') . ':' . config('presto.presto.port');
        $this->catalog = config('presto.presto.catalog');
        $this->schema = config('presto.presto.schema');
        $this->clientSession = new ClientSession(
            $this->host,
            $this->catalog
        );
        $this->query = "SELECT * FROM {$this->catalog}.{$this->schema}.{$this->table}";
    }

    public function statementClient(): void
    {
        $this->_parseFilter();
        $this->statementClient = new StatementClient($this->clientSession, $this->query);
        $this->resultSession();
        $this->statementClient->close();
    }

    public function resultSession(): void
    {
        $this->resultSession = new ResultsSession($this->statementClient);
        $result = $this->resultSession->execute()->yieldResults();
        foreach ($result as $row) {
            foreach ($row->yieldDataArray() as $item) {
                if (!is_null($item)) {
                    $this->dataResponse['data'][] = $item;
                }
            }
        }
    }

    private function _parseFilter(): void
    {
        if (empty($this->filter)) {
            return;
        }

        $this->query .= " WHERE ";

        foreach ($this->filter as $key => $filter) {
            if ($key > 0) {
                $clause = $filter["clause"];
                $this->query .= " {$clause} ";
            }

            $column = $filter["column"];
            $value = $filter["value"];
            $operator = $filter["operator"];

            $this->query .= "{$column} {$operator} '{$value}'";
        }
    }

    protected function addFilter(string $column, string $operator, string $value, string $clause = null): void
    {
        $this->filter[] = [
            "column" => $column,
            "operator" => $operator,
            "value" => $value,
            "clause" => !is_null($clause) ? $clause : "AND",
        ];
    }

    protected function _notFound(): bool
    {
        if (empty($this->dataResponse['data'])) {
            $this->dataResponse['status'] = 'error';
            $this->dataResponse['message'] = 'Not found.';

            return true;
        }

        return false;
    }

    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    public function getDataResponse(): array
    {
        return $this->dataResponse;
    }

    public function setDataResponse(string $message = '', string $status = '', array $data = []): void
    {
        !empty($message) ? $this->dataResponse['message'] = $message : '';
        !empty($status) ? $this->dataResponse['status'] = $status : '';
        !empty($data) ? $this->dataResponse['data'][] = $data : '';
    }
}
