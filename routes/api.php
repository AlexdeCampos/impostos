<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ImpostoController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('imposto')->group(function () {

    //Insere um novo imposto
    Route::post('/', [ImpostoController::class, 'setImposto']);

    //Lista todos os impostos
    Route::get('/', [ImpostoController::class, 'getImpostos']);

    //Deleta um imposto
    Route::delete('/{id}', [ImpostoController::class, 'deleteImposto']);

    //Simula o cálculo de acordo com o valor do produto/imposto
    Route::put('/', [ImpostoController::class, 'getCalculoimposto']);
});
