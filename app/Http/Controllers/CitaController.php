<?php

namespace App\Http\Controllers;

use App\Models\Bioquimica;
use App\Models\Cita;
use App\Models\Coprologia;
use App\Models\Coproparasitario;
use App\Models\Enfermeria;
use App\Models\Medicina;
use App\Models\Paciente;
use App\Models\Pendiente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (
      $request->has('area') &&
      $request->has('atendido') &&
      $request->has('cedula')
    ) {
      $atendido = $request->boolean('atendido');
      $area = $request->input('area');
      $cedula = $request->input('cedula');
      $result = Cita::where('area', '=', $area)
        ->where('atendido', '=', $atendido)
        ->where('cedula_cita', '=', $cedula)
        ->get();

      /*foreach ($result['data'] as $value) {
                $id_cita=$value['id_cita'];
                $count=Pendiente::where('id_cita','=',$id_cita)->count();
                $value['examenes']=$count;
            }*/
      //dd($result);
      return $this->sendResponse($result, 'Citas no atendidas por cedula del paciente');
    }
    //Devuelve la cita actual por cedula del paciente
    if ($request->has('cedula')) {
      $cita = Cita::where('cedula_cita', '=', $request->input('cedula'))
        ->where('citas.atendido', '=', false)
        //->where('fecha_cita','=',Carbon::now()->format('Y-m-d'))
        ->orderBy('fecha_cita', 'desc')
        ->orderBy('hora_cita', 'desc')
        ->firstOrFail();
      return $this->sendResponse($cita, 'Cita actual por cedula');
    }

    if ($request->has('filtro')) {
      if ($request->input('filtro') === 'pendientes') {
        return $this->sendResponse(Cita::join('pacientes', 'id_paciente', 'pacientes.id')
          ->select([
            'citas.*',
            'pacientes.nombre_completo as paciente'
          ])
          ->where('atendido', '=', false)
          ->get(), 'Citas pendientes');
      }
      if ($request->input('filtro') === 'atendidas') {
        return $this->sendResponse(Cita::join('pacientes', 'id_paciente', 'pacientes.id')
          ->where('atendido', '=', true)
          ->select([
            'citas.*',
            'pacientes.nombre_completo as paciente'
          ])
          ->get(), 'Citas atendidas');
      }
      if ($request->input('filtro') === 'todos') {
        return $this->sendResponse(Cita::join('pacientes', 'id_paciente', 'pacientes.id')
          ->select([
            'citas.*',
            'pacientes.nombre_completo as paciente'
          ])
          ->get(), 'Todas las citas');
      }
    }

    return $this->sendResponse(Cita::all(), 'Citas');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $fecha = Carbon::now()->format('Y-m-d');
    $hora = Carbon::now()->format('H:i:s');

    $cita = Cita::create([
      'fecha_cita' => $fecha,
      'hora_cita' => $hora,
      'cedula_cita' => $request->cedula,
      'area' => $request->area,
      'valor' => $request->valor,
      'factura_cita' => null,
      'estado_cita' => '',
      'id_paciente' => $request->id,
      'estadisticas' => ''
    ]);

    if($request->area!=='Laboratorio'){
        $enfermeria=new Enfermeria();
        $enfermeria->id_cita=$cita->id;
        $enfermeria->save();
    }
    return $this->sendResponse($cita,'Cita creada correctamente');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Cita  $cita
   * @return \Illuminate\Http\Response
   */
  public function show($id_cita)
  {
    //
    return $this->sendResponse(Cita::with('paciente')->find($id_cita), 'Cita');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Cita  $cita
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Cita $cita)
  {
    //
    $errorMessage = "";
    $enfermeria = Enfermeria::where('id_cita', '=', $cita->id)->first();

    if ($enfermeria) {
      //Si no ha sido atendido se puede actualizar
      if (!$enfermeria->atendido) {
        //Actualizar cita

      } else {
        //No se puede actualizar porque ya ha sido atendido por un tratante
        $errorMessage = "Esta cita medica ya fue asignado a medico tratante, el tratante debe primero eliminar";
        return $this->sendError($errorMessage);
      }
    }

    //verificar si hay datos en laboratorio
    $bioquimica = Bioquimica::where('id_cita', '=', $cita->id);
    $coprologia = Coprologia::where('id_cita', '=', $cita->id);
    $coproparasitario = Coproparasitario::where('id_cita', '=', $cita->id);
    $coprologia = Coprologia::where('id_cita', '=', $cita->id);
    $coprologia = Coprologia::where('id_cita', '=', $cita->id);
    $coprologia = Coprologia::where('id_cita', '=', $cita->id);
    $coprologia = Coprologia::where('id_cita', '=', $cita->id);

    $medicina = Medicina::join();
    $cita->update($request->only('area', 'valor'));
    return $this->sendResponse([], 'Registro actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Cita  $cita
   * @return \Illuminate\Http\Response
   */
  public function destroy(Cita $cita)
  {
    try {
      $cita->delete();
      return $this->sendResponse([], 'Cita eliminada');
    } catch (\Illuminate\Database\QueryException $ex) {

      return response()->json($ex->getSql(), 400);
    }
  }
  public function confirmarCita(Request $request)
  {
    try {
      $validator = Validator::make($request->all(), [
        'id_cita' => 'required|numeric'
      ]);
      if (count($validator->errors()) > 0) {
        return $this->sendError('Error en la petición', $validator->errors());
      }
      $id_cita = $request->input('id_cita');
      DB::beginTransaction();
      $cita = Cita::find($id_cita);
      $cita->atendido = true;
      $cita->save();
      Pendiente::where('id_cita', '=', $id_cita)->delete();
      DB::commit();
      return $this->sendResponse([], 'Cita confirmada');
    } catch (\Throwable $th) {
      try {
        DB::rollBack();
      } catch (\Throwable $th) {
        return $this->sendError($th->getMessage(), []);
      }
      return $this->sendError($th->getMessage(), []);
    }
  }
}
