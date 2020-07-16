<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\DbTable;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Requests\DadosSolicitacoesPorCpf;
use App\Http\Controllers\Api\ApiBigDataBaseController;
use App\Http\Requests\DadosSolicitacoesPorCnpj;

class DadosSolicitacoesController extends ApiBigDataBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->getPrestoClient()->setTable(DbTable::DB_TABLE_SOLICITACOES);
    }

    public function postDadosSolicitacoesPorCpf(DadosSolicitacoesPorCpf $request)
    {
        $cpf = Str::of($request->cpf)->ltrim(0);

        $this->getPrestoClient()->addFilter("cnpj", "=", $cpf);
        $this->getPrestoClient()->statementClient();

        if ($this->getPrestoClient()->_notFound()) {
            $this->getPrestoClient()->setDataResponse("Nenhuma solicitação encontrada para o CPF $request->cpf.");
            return response()->json($this->getPrestoClient()->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getPrestoClient()->getDataResponse());
    }

    public function postDadosSolicitacoesPorCnpj(DadosSolicitacoesPorCnpj $request)
    {
        $cnpj = Str::of($request->cnpj)->ltrim(0);
        $this->getPrestoClient()->addFilter("cnpj", "=", $cnpj);

        if (!empty($request->cpf)) {
            $cpf = Str::of($request->cpf)->ltrim(0);
            $this->getPrestoClient()->addFilter("cpf", "=", $cpf);
        }

        $this->getPrestoClient()->statementClient();

        if ($this->getPrestoClient()->_notFound()) {
            $message = "Nenhuma solicitação encontrada para o CNPJ $request->cnpj.";
            if (!empty($cpf)) {
                $message = "Nenhuma solicitação encontrada para o CNPJ $request->cnpj e CPF $request->cpf";
            }
            $this->getPrestoClient()->setDataResponse($message);
            return response()->json($this->getPrestoClient()->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getPrestoClient()->getDataResponse());
    }
}
