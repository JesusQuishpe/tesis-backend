<?php

namespace App\Http\Controllers;

use App\Models\Pendiente;
use Illuminate\Http\Request;

class PendienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $id_cita=$request->input('id_cita');
        $model=new Pendiente();
        $result=$model->getPendientes($id_cita);
        return $this->sendResponse($result,'Pendientes por cita');
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
     * @param  \App\Models\Pendiente  $pendiente
     * @return \Illuminate\Http\Response
     */
    public function show(Pendiente $pendiente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pendiente  $pendiente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pendiente $pendiente)
    {
        //
        $pendiente->update($request->only(['pendiente']));
        return $this->sendResponse($pendiente, 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pendiente  $pendiente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pendiente $pendiente)
    {
        //
    }
}
