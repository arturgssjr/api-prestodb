<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\DbTable;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Http\Requests\DadosSolicitacoesPorCpf;
use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\DadosSolicitacoesPorCnpj;

class DadosSolicitacoesController extends ApiBaseController
{
    public function __construct()
    {
        $this->setTable(DbTable::DB_TABLE_SOLICITACOES);
        parent::__construct();
    }

    public function postDadosSolicitacoesPorCpf(DadosSolicitacoesPorCpf $request)
    {
        $cpf = Str::of($request->cpf)->ltrim(0);

        $this->addFilter("cnpj", "=", $cpf);
        $this->statementClient();

        if ($this->_notFound()) {
            $this->setDataResponse("Nenhuma solicitação encontrada para o CPF $request->cpf.");
            return response()->json($this->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getDataResponse());
    }

    public function postDadosSolicitacoesPorCnpj(DadosSolicitacoesPorCnpj $request)
    {
        $cnpj = Str::of($request->cnpj)->ltrim(0);
        $this->addFilter("cnpj", "=", $cnpj);

        if (!empty($request->cpf)) {
            $cpf = Str::of($request->cpf)->ltrim(0);
            $this->addFilter("cpf", "=", $cpf);
        }

        $this->statementClient();

        if ($this->_notFound()) {
            $message = "Nenhuma solicitação encontrada para o CNPJ $request->cnpj.";
            if (!empty($cpf)) {
                $message = "Nenhuma solicitação encontrada para o CNPJ $request->cnpj e CPF $request->cpf";
            }
            $this->setDataResponse($message);
            return response()->json($this->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getDataResponse());
    }
}
