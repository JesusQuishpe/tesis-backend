<?php

namespace App\Http\Controllers;

use App\Models\LbArea;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->sendResponse(LbArea::all(), 'Areas de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lbArea = new LbArea();
        $lbArea->codigo = $request->input('codigo');
        $lbArea->nombre = $request->input('nombre');
        $lbArea->costo = $request->input('costo');
        $lbArea->save();
        return $this->sendResponse($lbArea, 'Registro creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lbArea  $lbArea
     * @return \Illuminate\Http\Response
     */
    public function show(lbArea $lbArea)
    {
        return $this->sendResponse($lbArea, 'Area de laboratorio');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lbArea  $lbArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lbArea $lbArea)
    {
        $lbArea->codigo = $request->input('codigo');
        $lbArea->nombre = $request->input('nombre');
        $lbArea->costo = $request->input('costo');
        $lbArea->save();
        return $this->sendResponse($lbArea, 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lbArea  $lbArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(lbArea $lbArea)
    {
        $lbArea->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
