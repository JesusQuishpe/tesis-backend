<?php

namespace App\Http\Controllers;

use App\Models\LbMeasurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->sendResponse(LbMeasurement::all(), 'Unidades');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $measure = new LbMeasurement();
    $measure->name = $request->input('name');
    $measure->abbreviation = $request->input('abbreviation');
    $measure->save();
    return $this->sendResponse($measure, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Unidad  $measure
   * @return \Illuminate\Http\Response
   */
  public function show(LbMeasurement $measure)
  {
    return $this->sendResponse($measure, 'Unidad');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Unidad  $measure
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, LbMeasurement $measure)
  {
    $measure->name = $request->input('name');
    $measure->abbreviation = $request->input('abbreviation');
    $measure->save();
    return $this->sendResponse($measure, 'Unidad actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Unidad  $measure
   * @return \Illuminate\Http\Response
   */
  public function destroy(LbMeasurement $measure)
  {
    $measure->delete();
    return $this->sendResponse([], 'Registro eliminado');
  }
}
