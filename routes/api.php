<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->name('api.')->middleware('client-credentials')->group(function () {
    Route::namespace('V1')->prefix('v1')->name('v1.')->group(function () {
        Route::post('/socios', 'DadosSociosController@dadosSocios')->name('dados-socios');
        Route::post('/empresa', 'DadosEmpresaController@dadosEmpresa')->name('dados-empresa');
        Route::prefix('solicitacoes')->group(function () {
            Route::post('/pf', 'DadosSolicitacoesController@dadosSolicitacoesPorCpf')->name('dados-solicitacoes-pf');
            Route::post('/pj', 'DadosSolicitacoesController@dadosSolicitacoesPorCnpj')->name('dados-solicitacoes-pj');
        });
    });
});
