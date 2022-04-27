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
        return $this->sendResponse(LbArea::with('groups.tests')->get(), 'Areas de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lb_area = new LbArea();
        $lb_area->code = $request->input('code');
        $lb_area->name = $request->input('name');
        $lb_area->price = $request->input('price');
        $lb_area->save();
        return $this->sendResponse($lb_area, 'Registro creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lbArea  $lb_area
     * @return \Illuminate\Http\Response
     */
    public function show(lbArea $lb_area)
    {
        return $this->sendResponse($lb_area, 'Area de laboratorio');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\lbArea  $lb_area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, lbArea $lb_area)
    {
        $lb_area->code = $request->input('code');
        $lb_area->name = $request->input('name');
        $lb_area->price = $request->input('price');
        $lb_area->save();
        return $this->sendResponse($lb_area, 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lbArea  $lb_area
     * @return \Illuminate\Http\Response
     */
    public function destroy(lbArea $lb_area)
    {
        $lb_area->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
