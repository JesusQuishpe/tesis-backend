<?php

namespace App\Http\Controllers;

use App\Models\Diente;
use Illuminate\Http\Request;

class DienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(Diente::all(),'Dientes');
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
     * @param  \App\Models\Diente  $diente
     * @return \Illuminate\Http\Response
     */
    public function show(Diente $diente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Diente  $diente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diente $diente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Diente  $diente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diente $diente)
    {
        //
    }
}
