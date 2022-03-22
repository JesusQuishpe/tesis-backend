<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\EstudioDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudioController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if($request->has('individuales') && $request->boolean('individuales')){
      return $this->sendResponse(Estudio::with('unidad')
      ->where('es_individual','=',true)
      ->get(),'Estudios individuales');
    }
    return $this->sendResponse(Estudio::with(['children','unidad'])->get(), 'Estudios');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      DB::beginTransaction();
      //return $this->sendResponse($request->input('estudios'),'Estudios');
      $newEstudio = new Estudio();
      $newEstudio->clave = $request->input('clave');
      $newEstudio->nombre = $request->input('nombre');
      $newEstudio->indicaciones = $request->input('indicaciones') ?: "";
      $newEstudio->es_individual = $request->boolean('tipo');
      $newEstudio->costo=$request->input('costo');
      if ($request->input('id_unidad') === "-1") {
        $newEstudio->id_unidad = null;
      } else {
        $newEstudio->id_unidad = $request->input('id_unidad');
      }
      $newEstudio->save();
      //Guardar estudios en caso de que tenga
      if (!$newEstudio->es_individual && $request->has('estudios') && count($request->input('estudios')) > 0) {
        foreach ($request->input('estudios') as $estudio) {
          $estudioDetalle = new EstudioDetalle();
          $estudioDetalle->id_estudio_padre = $newEstudio->id;
          $estudioDetalle->id_estudio_hijo = $estudio['id'];
          $estudioDetalle->save();
        }
      }
      DB::commit();
      return $this->sendResponse($newEstudio, 'Registro creado');
    } catch (\Throwable $th) {
      DB::rollBack();
      return $this->sendError($th->getMessage());
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Estudio  $estudio
   * @return \Illuminate\Http\Response
   */
  public function show(Estudio $estudio)
  {
    return $this->sendResponse($estudio, 'Estudio');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Estudio  $estudio
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Estudio $estudio)
  {
    $estudio->clave = $request->input('clave');
    $estudio->nombre = $request->input('nombre');
    $estudio->indicaciones = $request->input('indicaciones') || "";
    $estudio->costo = $request->input('costo');
    if ($request->input('id_medida') === "-1") {
      $estudio->id_medida = null;
    } else {
      $estudio->id_medida = $request->input('id_medida');
    }
    $estudio->save();
    return $this->sendResponse($estudio, 'Estudio actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Estudio  $estudio
   * @return \Illuminate\Http\Response
   */
  public function destroy(Estudio $estudio)
  {
    $estudio->delete();
    return $this->sendResponse([], 'Registro eliminado');
  }
}
