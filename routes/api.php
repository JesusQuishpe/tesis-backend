<?php

use App\Actions\JsonApiAuth\AuthKit;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\BioquimicaController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CoprologiaController;
use App\Http\Controllers\CoproparasitarioController;
use App\Http\Controllers\DienteController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EmbarazoController;
use App\Http\Controllers\EnfermeriaController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\ExamenController;
use App\Http\Controllers\ExamenEstudioController;
use App\Http\Controllers\ExamenOrinaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\HelicobacterController;
use App\Http\Controllers\HelicobacterHecesController;
use App\Http\Controllers\HematologiaController;
use App\Http\Controllers\HemoglobinaController;
use App\Http\Controllers\LaboratorioController;
use App\Http\Controllers\MedicinaController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\OdontologiaController;
use App\Http\Controllers\OperacionController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PendienteController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SimbologiaController;
use App\Http\Controllers\TipoExamenController;
use App\Http\Controllers\TiroideasController;
use App\Http\Controllers\TituloController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\UserController;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('login',[UserController::class,'login']);
Route::post('laboratorio/crearConsulta',[LaboratorioController::class,'crearConsulta']);
Route::get('laboratorio/pendientes',[LaboratorioController::class,'pendientes']);
Route::post('asignaciones',[ExamenEstudioController::class,'store']);
Route::apiResource('users',UserController::class);
Route::post("caja",[CajaController::class,'store']);
Route::post('confirmarCita',[CitaController::class,'confirmarCita']);
Route::get('odontologia/dientes',[DienteController::class,'index']);
Route::get('odontologia/pacientes',[OdontologiaController::class,'pacientes']);
Route::get('odontologia/simbologias',[SimbologiaController::class,'index']);
Route::get('odontologia/resultado/{id_cita}',[OdontologiaController::class,'resultado']);
Route::post('permisos',[ModuloController::class,'addRolModule']);

Route::get('permisos',[UserController::class,'permisos']);
Route::get('laboratorio/cita/{cedula}',[LaboratorioController::class,'getCitaPorCedula']);
Route::apiResource('roles',RolController::class);
Route::apiResource('modulos',ModuloController::class);
Route::apiResource('operaciones',OperacionController::class);
Route::apiResource('citas',CitaController::class);
Route::apiResource('pacientes',PacienteController::class);
Route::apiResource('tipos',TipoExamenController::class)->parameters(['tipos'=>'tipoExamen']);
Route::apiResource('unidades',UnidadController::class)->parameters(['unidades'=>'unidad']);
Route::apiResource('titulos',TituloController::class)->parameters(['titulos'=>'titulo']);
Route::apiResource('areas',AreaController::class)->parameters(['areas'=>'lbArea']);
Route::apiResource('pruebas',PruebaController::class)->parameters(['pruebas'=>'lbPrueba']);
Route::apiResource('grupos',GrupoController::class)->parameters(['grupos'=>'lbGrupo']);
//Route::apiResource('estudios',EstudioController::class)->parameters(['estudios'=>'estudio']);
Route::get('examenes/estudios',[ExamenController::class,'examenEstudios']);
Route::apiResource('examenes',ExamenController::class)->parameters(['examenes'=>'examen']);


Route::apiResource('bioquimicas',BioquimicaController::class);
Route::apiResource('coprologias',CoprologiaController::class);
Route::apiResource('coproparasitarios',CoproparasitarioController::class);
Route::apiResource('orinas',ExamenOrinaController::class);
Route::apiResource('heces',HelicobacterHecesController::class);
Route::apiResource('helycobacteres',HelicobacterController::class);
Route::apiResource('hematologias',HematologiaController::class);
Route::apiResource('hemoglobinas',HemoglobinaController::class);
Route::apiResource('embarazos',EmbarazoController::class);
Route::apiResource('tiroideas',TiroideasController::class);

Route::get('enfermeria/pacientes',[EnfermeriaController::class,'pacientes']);
Route::apiResource('doctores',DoctorController::class);
//Route::apiResource('pendientes',PendienteController::class);
Route::apiResource('medicina',MedicinaController::class);
Route::apiResource('enfermerias',EnfermeriaController::class);

Route::delete('eliminarCitaPendiente/{id_cita}',[LaboratorioController::class,'eliminarCitaPendiente']);
Route::post('eliminarHistoria',[LaboratorioController::class,'eliminarHistoriaClinica']);


Route::get('tiposExamen',[TipoExamenController::class,'index']);
Route::get('examenPorTipo',[LaboratorioController::class,'examenPorTipo']);
Route::get('examen',[LaboratorioController::class,'examen']);
Route::get('laboratorio/historia',[LaboratorioController::class,'getHistoriaClinica']);
//Route::get('pendientes',[LaboratorioController::class,'pendientes']);
Route::post('eliminarCitaExamen',[LaboratorioController::class,'deleteExamenCita']);
//require __DIR__ . '/json-api-auth.php';

// An example of how to use the verified email feature with api endpoints

//Route::get('/verified-middleware-example', function () {
//    return response()->json([
//        'message' => 'the email account is already confirmed now you are able to see this message...',
//    ]);
//})->middleware(AuthKit::getMiddleware(), 'verified');
