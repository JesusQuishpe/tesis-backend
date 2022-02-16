<?php

namespace App\Http\Controllers;

use App\Models\Titulo;
use Illuminate\Http\Request;

class TituloController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->sendResponse(Titulo::all(), 'Titulos');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $titulo = new Titulo();
    $titulo->nombre = $request->input('nombre');
    $titulo->save();
    return $this->sendResponse($titulo, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Titulo  $titulo
   * @return \Illuminate\Http\Response
   */
  public function show(Titulo $titulo)
  {
    return $this->sendResponse($titulo, 'Titulo');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Titulo  $titulo
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Titulo $titulo)
  {
    $titulo->nombre = $request->input('nombre');
    $titulo->save();
    return $this->sendResponse($titulo, 'Titulo actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Titulo  $titulo
   * @return \Illuminate\Http\Response
   */
  public function destroy(Titulo $titulo)
  {
    $titulo->delete();
    return $this->sendResponse([], 'Registro eliminado');
  }
}
