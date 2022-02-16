<?php

namespace App\Http\Controllers;

use App\Models\TipoExamen;
use Illuminate\Http\Request;

class TipoExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Buscar paciente por cedula o nombre completo
        return $this->sendResponse(TipoExamen::all(),'Tipos de examen');
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
     * @param  \App\Models\TipoExamen  $tipoExamen
     * @return \Illuminate\Http\Response
     */
    public function show(TipoExamen $tipoExamen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoExamen  $tipoExamen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoExamen $tipoExamen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoExamen  $tipoExamen
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoExamen $tipoExamen)
    {
        //
    }
}
