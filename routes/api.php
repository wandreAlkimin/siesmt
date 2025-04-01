<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\FotoPessoaController;
use App\Http\Controllers\LotacaoController;
use App\Http\Controllers\ServidorEfetivoController;
use App\Http\Controllers\ServidorTemporarioController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('registrar', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('user-validar-rash', 'validacao');
});

Route::middleware(['jwt.validar'])->group(function () {

    Route::apiResource('estados', EstadoController::class);
    Route::get('estados-search', [EstadoController::class, 'search']);

    Route::apiResource('cidades', CidadeController::class);
    Route::get('cidades-search', [CidadeController::class, 'search']);

    Route::apiResource('enderecos', EnderecoController::class);
    Route::get('enderecos-search', [EnderecoController::class, 'search']);

    Route::apiResource('lotacoes', LotacaoController::class);
    Route::get('lotacoes-search', [LotacaoController::class, 'search']);

    Route::apiResource('servidores-efetivos', ServidorEfetivoController::class);
    Route::get('servidores-efetivos-search', [ServidorEfetivoController::class, 'search']);

    Route::apiResource('servidores-temporarios', ServidorTemporarioController::class);
    Route::get('servidores-temporarios-search', [ServidorTemporarioController::class, 'search']);

    Route::apiResource('unidades', UnidadeController::class);
    Route::get('unidades-search', [UnidadeController::class, 'search']);

    Route::apiResource('usuarios', UserController::class);
    Route::get('usuarios-search', [UserController::class, 'search']);

    Route::apiResource('foto-pessoas', FotoPessoaController::class);
    Route::get('foto-pessoas-search', [FotoPessoaController::class, 'search']);
    Route::post('foto-pessoas', [FotoPessoaController::class, 'upload']);

});
