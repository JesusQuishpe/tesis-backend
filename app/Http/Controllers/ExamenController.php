<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Examen;
use App\Models\ExamenEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamenController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //Devuelve solo los examenes tipo parametro y perfil
    if($request->has('asignacion') && $request->boolean('asignacion')){
      $examenes=Examen::where('id_tipo','!=',1)->get();//Diferente del tipo individual
      return $this->sendResponse($examenes,'Examenes por parametro y perfil');
    }
    return $this->sendResponse(Examen::all(), 'Examenes');
  }

  public function examenEstudios()
  {
    $examenes=Examen::with('estudios')->get();
    foreach ($examenes as $examen) {
      foreach ($examen->estudios as $estudio) {
        if($estudio['es_individual']===0){
          $children=Estudio::find($estudio['id'])->children;
          $estudio['children']=$children;
        }
      }
    }
    return $this->sendResponse($examenes,'Examenes con estudios');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $examen = new Examen();
    $examen->nombre = $request->input('nombre');
    //$examen->id_tipo=$request->input('id_tipo');
    $examen->save();
    return $this->sendResponse($examen, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Examen  $examen
   * @return \Illuminate\Http\Response
   */
  public function show(Examen $examen)
  {
    return $this->sendResponse($examen, 'Examen');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Examen  $examen
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Examen $examen)
  {
    $examen->nombre = $request->input('nombre');
    //$examen->id_tipo=$request->input('id_tipo');
    $examen->save();
    return $this->sendResponse($examen, 'Examen actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Examen  $examen
   * @return \Illuminate\Http\Response
   */
  public function destroy(Examen $examen)
  {
    $examen->delete();
    return $this->sendResponse([],'Registro eliminado');
  }
}
