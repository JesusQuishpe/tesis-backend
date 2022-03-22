<?php

namespace App\Http\Controllers;

use App\Models\LbGrupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->sendResponse(LbGrupo::all(), 'Grupos de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lbGrupo = new LbGrupo();
        $lbGrupo->codigo = $request->input('codigo');
        $lbGrupo->nombre = $request->input('nombre');
        $lbGrupo->id_area=$request->input('id_area');
        $lbGrupo->costo = $request->input('costo');
        $lbGrupo->save();
        return $this->sendResponse($lbGrupo, 'Registro creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LbGrupo  $lbGrupo
     * @return \Illuminate\Http\Response
     */
    public function show(LbGrupo $lbGrupo)
    {
        return $this->sendResponse($lbGrupo->with('area')->firstOrFail(), 'Grupo de laboratorio');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbGrupo  $lbGrupo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbGrupo $lbGrupo)
    {
        $lbGrupo->codigo = $request->input('codigo');
        $lbGrupo->nombre = $request->input('nombre');
        $lbGrupo->id_area=$request->input('id_area');
        $lbGrupo->costo = $request->input('costo');
        $lbGrupo->save();
        return $this->sendResponse($lbGrupo, 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LbGrupo  $lbGrupo
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbGrupo $lbGrupo)
    {
        $lbGrupo->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
