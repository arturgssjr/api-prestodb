<?php

namespace App\Http\Controllers\Api\V1;

use App\Enum\DbTable;
use Illuminate\Http\Response;
use App\Http\Requests\DadosEmpresa;
use App\Http\Controllers\Api\ApiBaseController;

class DadosEmpresaController extends ApiBaseController
{
    public function __construct()
    {
        $this->setTable(DbTable::DB_TABLE_CNPJ_EMPRESA);
        parent::__construct();
    }

    public function postDadosEmpresa(DadosEmpresa $request)
    {
        $this->addFilter("cnpj", "=", $request->cnpj);
        $this->statementClient();

        if ($this->_notFound()) {
            $this->setDataResponse("Empresa com CNPJ $request->cnpj não encontrada.");
            return response()->json($this->getDataResponse(), Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->getDataResponse());
    }
}
