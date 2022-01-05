<?php

use App\Http\Controllers\BioquimicaController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CoprologiaController;
use App\Http\Controllers\CoproparasitarioController;
use App\Http\Controllers\EnfermeriaController;
use App\Http\Controllers\PacienteController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('pacientes',PacienteController::class);

Route::post('caja', [CajaController::class,'store']);

Route::apiResource('enfermerias',EnfermeriaController::class);

Route::get('enfermeria/pacientes',[EnfermeriaController::class,'pacientes']);

Route::apiResource('bioquimicas',BioquimicaController::class);

Route::apiResource('coprologias',CoprologiaController::class);

Route::apiResource('coproparasitarios',CoproparasitarioController::class);
