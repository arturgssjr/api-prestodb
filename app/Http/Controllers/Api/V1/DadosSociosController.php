<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\DbTable;
use Illuminate\Http\Response;
use App\Http\Requests\DadosSocios;
use App\Http\Controllers\Api\ApiBigDataBaseController;

class DadosSociosController extends ApiBigDataBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->getPrestoClient()->setTable(DbTable::DB_TABLE_CNPJ_SOCIOS);
    }

    public function dadosSocios(DadosSocios $request)
    {
        $this->getPrestoClient()->addFilter("cnpj", "=", $request->cnpj);
        $this->getPrestoClient()->statementClient();

        if ($this->getPrestoClient()->_notFound()) {
            $this->getPrestoClient()->setDataResponse("Sócios não encontrados para o CNPJ $request->cnpj.");
            return response()->json($this->getPrestoClient()->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getPrestoClient()->getDataResponse());
    }
}
