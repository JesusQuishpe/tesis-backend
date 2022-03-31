<?php

namespace App\Http\Controllers;

use App\Models\LbOrden;
use App\Models\LbOrdenPrueba;
use Illuminate\Http\Request;

class LbOrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if($request->has('pendiente') && $request->has('cedula')){
            $model=new LbOrden();
            $ordenes=$model->ordenesPendientesPorCedula($request->input('cedula'));
            return $this->sendResponse($ordenes,'Ordenes pendientes del paciente por cedula');
        }

        if($request->has('cedula')){
            $model=new LbOrden();
            $ordenes=$model->ordenActualPorCedula($request->input('cedula'));
            return $this->sendResponse($ordenes,'Ordenes del paciente por cedula');
        }

        return $this->sendResponse(LbOrden::all(),'Ordenes de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LbOrden  $lbOrden
     * @return \Illuminate\Http\Response
     */
    public function show(LbOrden $lbOrden)
    {
        $pruebas=LbOrdenPrueba::with('prueba')->where('id_orden','=',$lbOrden->id)->get();
        $lbOrden->pruebas=$pruebas;
        return $this->sendResponse($lbOrden,'Orden con sus detalles');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbOrden  $lbOrden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbOrden $lbOrden)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LbOrden  $lbOrden
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbOrden $lbOrden)
    {
        //
    }
}
