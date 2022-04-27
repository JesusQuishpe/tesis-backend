<?php

namespace App\Http\Controllers;

use App\Models\LbGroup;
use Illuminate\Http\Request;

class LbGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->sendResponse(LbGroup::with('area')->get(), 'Grupos de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lb_group = new LbGroup();
        $lb_group->code = $request->input('code');
        $lb_group->name = $request->input('name');
        $lb_group->area_id=$request->input('area.value');
        $lb_group->price = $request->input('price');
        $lb_group->showAtPrint=$request->input('showAtPrint');
        $lb_group->save();
        return $this->sendResponse($lb_group, 'Registro creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LbGroup  $lb_group
     * @return \Illuminate\Http\Response
     */
    public function show(LbGroup $lb_group)
    {
        return $this->sendResponse($lb_group->with('area')->findOrFail($lb_group->id), 'Grupo de laboratorio');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbGroup  $lb_group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbGroup $lb_group)
    {
        $lb_group->code = $request->input('code');
        $lb_group->name = $request->input('name');
        $lb_group->area_id=$request->input('area.value');
        $lb_group->price = $request->input('price');
        $lb_group->showAtPrint=$request->input('showAtPrint');
        $lb_group->save();
        return $this->sendResponse($lb_group, 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LbGroup  $lb_group
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbGroup $lb_group)
    {
        $lb_group->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
