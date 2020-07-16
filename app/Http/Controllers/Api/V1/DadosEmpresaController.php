<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\DbTable;
use Illuminate\Http\Response;
use App\Http\Requests\DadosEmpresa;
use App\Http\Controllers\Api\ApiBigDataBaseController;

class DadosEmpresaController extends ApiBigDataBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->getPrestoClient()->setTable(DbTable::DB_TABLE_CNPJ_EMPRESA);
    }

    public function postDadosEmpresa(DadosEmpresa $request)
    {
        $this->getPrestoClient()->addFilter("cnpj", "=", $request->cnpj);
        $this->getPrestoClient()->statementClient();

        if ($this->getPrestoClient()->_notFound()) {
            $this->getPrestoClient()->setDataResponse("Empresa com CNPJ $request->cnpj não encontrada.");
            return response()->json($this->getPrestoClient()->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getPrestoClient()->getDataResponse());
    }
}
