<?php

namespace App\Http\Controllers;

use App\Models\LbPrueba;
use Illuminate\Http\Request;

class PruebaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    return $this->sendResponse(LbPrueba::with('grupo.area')->get(), 'Pruebas de laboratorio');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $lbPrueba = new LbPrueba();
    $lbPrueba->codigo = $request->input('codigo');
    $lbPrueba->nombre = $request->input('nombre');
    $lbPrueba->id_grupo = $request->input('grupo_sel.value');
    if($request->input('unidad_sel.value')===-1){
        $lbPrueba->id_unidad =null;
    }else{
        $lbPrueba->id_unidad = $request->input('unidad_sel.value');
    }
    $lbPrueba->valor_ref = $request->input('valor_ref');
    $lbPrueba->de = $request->input('de',0);
    $lbPrueba->hasta = $request->input('hasta',0);
    $lbPrueba->interpretacion = $request->input('interpretacion','');
    $lbPrueba->valor_cualitativo = $request->input('valor_cualitativo','');
    $lbPrueba->costo = $request->input('costo');
    $lbPrueba->numerico=$request->input('numerico');
    $lbPrueba->formula=$request->input('formula');
    $lbPrueba->operandos=$request->input('operandos');
    $lbPrueba->save();
    return $this->sendResponse($lbPrueba, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\LbPrueba  $lbPrueba
   * @return \Illuminate\Http\Response
   */
  public function show($idPrueba)
  {
    $prueba=LbPrueba::with('grupo','unidad')->find($idPrueba);
    return $this->sendResponse($prueba, 'Prueba de laboratorio');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\LbPrueba  $lbPrueba
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, LbPrueba $lbPrueba)
  {
    $lbPrueba->codigo = $request->input('codigo');
    $lbPrueba->nombre = $request->input('nombre');
    $lbPrueba->id_grupo = $request->input('grupo_sel.value');
    if($request->input('unidad_sel.value')===-1){
        $lbPrueba->id_unidad =null;
    }else{
        $lbPrueba->id_unidad = $request->input('unidad_sel.value');
    }

    $lbPrueba->valor_ref = $request->input('valor_ref');
    $lbPrueba->de = $request->input('de',0);
    $lbPrueba->hasta = $request->input('hasta',0);
    $lbPrueba->interpretacion = $request->input('interpretacion','');
    $lbPrueba->valor_cualitativo = $request->input('valor_cualitativo','');
    $lbPrueba->costo = $request->input('costo');
    $lbPrueba->numerico=$request->input('numerico');
    $lbPrueba->formula=$request->input('formula');
    $lbPrueba->operandos=$request->input('operandos');
    $lbPrueba->save();
    return $this->sendResponse($lbPrueba, 'Registro actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\LbPrueba  $lbPrueba
   * @return \Illuminate\Http\Response
   */
  public function destroy(LbPrueba $lbPrueba)
  {
    $lbPrueba->delete();
    return $this->sendResponse([], 'Registro eliminado');
  }
}
