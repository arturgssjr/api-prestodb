<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DadosSociosController;
use App\Http\Controllers\Api\V1\DadosEmpresaController;
use App\Http\Controllers\Api\V1\DadosSolicitacoesController;

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

Route::get('/', function () {
    return [
        'Version' => app()->version(),
        'API Version' => config('api.version'),
    ];
});

Route::group(['middleware' => 'client-credentials', 'prefix' => config('api.version')], function () {
    Route::post('/socios', [DadosSociosController::class, 'postDadosSocios']);
    Route::post('/empresa', [DadosEmpresaController::class, 'postDadosEmpresa']);
    Route::post('/solicitacoes/pf', [DadosSolicitacoesController::class, 'postDadosSolicitacoesPorCpf']);
    Route::post('/solicitacoes/pj', [DadosSolicitacoesController::class, 'postDadosSolicitacoesPorCnpj']);
});
