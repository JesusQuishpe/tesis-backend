<?php

use App\Http\Controllers\AppointmentRecordController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\MedicalAppoitmentController;
use App\Http\Controllers\OdoTeethController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\NursingAreaController;
use App\Http\Controllers\LbGroupController;
use App\Http\Controllers\LbOrderController;
use App\Http\Controllers\LbResultController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\MedicinaController;
use App\Http\Controllers\OdontologyController;
use App\Http\Controllers\SystemModuleController;
use App\Http\Controllers\OdoPatientRecordController;
use App\Http\Controllers\OdoSymbologieController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('login',[UserController::class,'login']);
Route::apiResource('users',UserController::class);

Route::get('historial/cita/{appoId}/enfermeria/{nurId}/ficha/{recId}',[PDFController::class,'pdf']);
Route::get('resultado/{orderId}/pdf',[LaboratoryController::class,'pdf']);
Route::get('acta/{recId}/download',[PDFController::class,'downloadActa']);
Route::get('odontologia/fichas/{identification}',[AppointmentRecordController::class,'index']);
Route::post('odontologia/save',[OdontologyController::class,'store']);
Route::post('odontologia/update',[OdontologyController::class,'update']);
Route::get('odontologia/dientes',[OdoTeethController::class,'index']);
Route::get('odontologia/pacientes',[OdoPatientRecordController::class,'patients']);
Route::get('odontologia/simbologias',[OdoSymbologieController::class,'index']);
Route::get('odontologia/resultado/{appo_id}',[OdoPatientRecordController::class,'result']);
Route::delete('odontologia/delete/{nurId}',[OdontologyController::class,'destroy']);
Route::get('cita/{appo_id}/enfermeria/{nur_id}/ficha/{rec_id}',[OdoPatientRecordController::class,'patientRecord']);

Route::post('permisos',[SystemModuleController::class,'addRolModule']);
Route::get('permisos',[UserController::class,'permissions']);

Route::apiResource('citas',MedicalAppoitmentController::class)->parameters(['citas'=>'appo']);

Route::apiResource('roles',RolController::class);
Route::apiResource('modulos',SystemModuleController::class)->parameters(['modulos'=>'module']);
Route::apiResource('pacientes',PatientController::class)->parameters(['pacientes'=>'patient']);
Route::apiResource('unidades',MeasurementController::class)->parameters(['unidades'=>'measure']);
Route::apiResource('areas',AreaController::class)->parameters(['areas'=>'lb_area']);
Route::apiResource('pruebas',TestController::class)->parameters(['pruebas'=>'test']);
Route::apiResource('grupos',LbGroupController::class)->parameters(['grupos'=>'lb_group']);
Route::apiResource('ordenes',LbOrderController::class)->parameters(['ordenes'=>'lb_order']);
Route::apiResource('resultados',LbResultController::class)->parameters(['resultados'=>'lb_result']);

Route::get('enfermeria/pacientes',[NursingAreaController::class,'patients']);
Route::apiResource('doctores',DoctorController::class);
Route::apiResource('medicinas',MedicinaController::class)->parameters(['medicinas'=>'medicine']);
Route::apiResource('enfermerias',NursingAreaController::class)->parameters(['enfermerias'=>'nur']);

//require __DIR__ . '/json-api-auth.php';

// An example of how to use the verified email feature with api endpoints

//Route::get('/verified-middleware-example', function () {
//    return response()->json([
//        'message' => 'the email account is already confirmed now you are able to see this message...',
//    ]);
//})->middleware(AuthKit::getMiddleware(), 'verified');
