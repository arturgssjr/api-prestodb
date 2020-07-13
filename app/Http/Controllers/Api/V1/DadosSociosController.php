<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DadosSocios;
use ArturJr\PrestoClient\ResultsSession;
use ArturJr\PrestoClient\StatementClient;
use Illuminate\Http\Response;

class DadosSociosController extends Controller
{
    public function postDadosSocios(DadosSocios $request)
    {
        $dadosSocios = [];
        $client = new StatementClient($this->clientSession, "SELECT * FROM $this->catalog.$this->dbname.cnpj_dados_socios_pj WHERE cnpj = '$request->cnpj'");
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
            return response()->json(["message" => "Sócios não encontrados para o CNPJ $request->cnpj."], Response::HTTP_NOT_FOUND);
        }

        return response()->json($dadosSocios);
    }
}
