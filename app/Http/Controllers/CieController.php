<?php

namespace App\Http\Controllers;

use App\Models\Cie;
use Illuminate\Http\Request;

class CieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('name')) {
            return $this->sendResponse(Cie::where('name', $request->name)
                ->paginate(10), 'Cies 10 por nombre');
        }
        return $this->sendResponse(Cie::paginate(10), 'Cies 10');
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
     * @param  \App\Models\Cie  $cie
     * @return \Illuminate\Http\Response
     */
    public function show(Cie $cie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cie  $cie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cie $cie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cie  $cie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cie $cie)
    {
        //
    }
}
