<?php

namespace App\Http\Controllers;

use App\Models\Simbologia;
use Illuminate\Http\Request;

class SimbologiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return $this->sendResponse(Simbologia::all(),'Simbologias');
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
     * @param  \App\Models\Simbologia  $simbologia
     * @return \Illuminate\Http\Response
     */
    public function show(Simbologia $simbologia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Simbologia  $simbologia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Simbologia $simbologia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Simbologia  $simbologia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Simbologia $simbologia)
    {
        //
    }
}
