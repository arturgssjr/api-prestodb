<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DadosEmpresa;
use ArturJr\PrestoClient\ResultsSession;
use ArturJr\PrestoClient\StatementClient;
use Illuminate\Http\Response;

class DadosEmpresaController extends Controller
{
    public function postDadosEmpresa(DadosEmpresa $request)
    {
        $dadosSocios = [];
        $client = new StatementClient($this->clientSession, "SELECT * FROM $this->catalog.$this->dbname.cnpj_dados_cadastrais_pj WHERE cnpj = '$request->cnpj'");
        $resultSession = new ResultsSession($client);
        $result = $resultSession->execute()->yieldResults();
        foreach ($result as $row) {
            foreach ($row->yieldDataArray() as $item) {
                if (!is_null($item)) {
                    $dadosSocios[] = $item;
                }
            }
        }
        $client->close();

        if ($this->_notFound($dadosSocios)) {
            return response()->json(["message" => "Empresa com CNPJ $request->cnpj não encontrada."], Response::HTTP_NOT_FOUND);
        }

        return response()->json($dadosSocios);
    }
}
