<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use ArturJr\PrestoClient\ResultsSession;
use ArturJr\PrestoClient\StatementClient;
use App\Http\Requests\DadosSolicitacoesPorCpf;
use App\Http\Requests\DadosSolicitacoesPorCnpj;

class DadosSolicitacoesController extends Controller
{
    public function postDadosSolicitacoesPorCpf(DadosSolicitacoesPorCpf $request)
    {
        $cpf = Str::of($request->cpf)->ltrim(0);

        $dadosSolicitacoes = [];
        $client = new StatementClient($this->clientSession, "SELECT * FROM $this->catalog.$this->dbname.solicitacoes WHERE cnpj = '$cpf'");
        $resultSession = new ResultsSession($client);
        $result = $resultSession->execute()->yieldResults();
        foreach ($result as $row) {
            foreach ($row->yieldDataArray() as $item) {
                if (!is_null($item)) {
                    $dadosSolicitacoes[] = $item;
                }
            }
        }
        $client->close();

        if ($this->_notFound($dadosSolicitacoes)) {
            return response()->json(["message" => "Nenhuma solicitação encontrada para o CPF $request->cpf."], Response::HTTP_NOT_FOUND);
        }

        return response()->json($dadosSolicitacoes);
    }

    public function postDadosSolicitacoesPorCnpj(DadosSolicitacoesPorCnpj $request)
    {
        $cnpj = Str::of($request->cnpj)->ltrim(0);
        $query = "SELECT * FROM $this->catalog.$this->dbname.solicitacoes WHERE cnpj = '$cnpj'";

        if (!empty($request->cpf)) {
            $cpf = Str::of($request->cpf)->ltrim(0);
            $query .= " AND cpf = '$cpf'";
        }

        $dadosSolicitacoes = [];
        $client = new StatementClient($this->clientSession, $query);
        $resultSession = new ResultsSession($client);
        $result = $resultSession->execute()->yieldResults();
        foreach ($result as $row) {
            foreach ($row->yieldDataArray() as $item) {
                if (!is_null($item)) {
                    $dadosSolicitacoes[] = $item;
                }
            }
        }
        $client->close();

        if ($this->_notFound($dadosSolicitacoes)) {
            $message = "Nenhuma solicitação encontrada para o CNPJ $request->cnpj.";
            if (!empty($cpf)) {
                $message = "Nenhuma solicitação encontrada para o CNPJ $request->cnpj e CPF $request->cpf";
            }
            return response()->json(["message" => $message], Response::HTTP_NOT_FOUND);
        }

        return response()->json($dadosSolicitacoes);
    }
}
