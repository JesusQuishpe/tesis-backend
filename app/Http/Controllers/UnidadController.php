<?php

namespace App\Http\Controllers;

use App\Models\LbUnidad;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->sendResponse(LbUnidad::all(), 'Unidades');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $unidad = new LbUnidad();
    $unidad->nombre = $request->input('nombre');
    $unidad->abreviatura = $request->input('abreviatura');
    $unidad->save();
    return $this->sendResponse($unidad, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Unidad  $unidad
   * @return \Illuminate\Http\Response
   */
  public function show(LbUnidad $unidad)
  {
    return $this->sendResponse($unidad, 'Unidad');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Unidad  $unidad
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, LbUnidad $unidad)
  {
    $unidad->nombre = $request->input('nombre');
    $unidad->abreviatura = $request->input('abreviatura');
    $unidad->save();
    return $this->sendResponse($unidad, 'Unidad actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Unidad  $unidad
   * @return \Illuminate\Http\Response
   */
  public function destroy(LbUnidad $unidad)
  {
    $unidad->delete();
    return $this->sendResponse([], 'Registro eliminado');
  }
}
