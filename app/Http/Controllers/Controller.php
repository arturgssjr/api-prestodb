<?php

namespace App\Http\Controllers;

use ArturJr\PrestoClient\ClientSession;
use ArturJr\PrestoClient\StatementClient;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $clientSession;
    protected $statementClient;
    protected $catalog;
    protected $host;
    protected $dbname;

    public function __construct()
    {
        $this->host = config('presto.presto.host') . ':' . config('presto.presto.port');
        $this->catalog = config('presto.presto.catalog');
        $this->dbname = config('presto.presto.schema');
        $this->clientSession = new ClientSession(
            $this->host,
            $this->catalog
        );
    }

    protected function _notFound(array $dadosSocios)
    {
        return empty($dadosSocios);
    }
}
