<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\DbTable;
use Illuminate\Http\Response;
use App\Http\Requests\DadosSocios;
use App\Http\Controllers\Api\ApiBaseController;

class DadosSociosController extends ApiBaseController
{
    public function __construct()
    {
        $this->setTable(DbTable::DB_TABLE_CNPJ_SOCIOS);
        parent::__construct();
    }

    public function postDadosSocios(DadosSocios $request)
    {
        $this->addFilter("cnpj", "=", $request->cnpj);
        $this->statementClient();

        if ($this->_notFound()) {
            $this->setDataResponse("Sócios não encontrados para o CNPJ $request->cnpj.");
            return response()->json($this->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getDataResponse());
    }
}
