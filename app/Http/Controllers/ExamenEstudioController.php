<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\ExamenEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamenEstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $estudios=$request->input('estudios');
      $id_examen=$request->input('id_examen');
      try {
        DB::beginTransaction();
        foreach ($estudios as $estudio) {
          $examenEstudio=new ExamenEstudio();
          $examenEstudio->id_examen=$id_examen;
          $examenEstudio->id_estudio=$estudio['id'];
          $examenEstudio->save();
        }
        $examen=Examen::find($id_examen);
        $examen->tieneEstudios=true;
        $examen->save();
        DB::commit();
        return $this->sendResponse([],'Estudios asignados correctamente');
      } catch (\Throwable $th) {
        DB::rollBack();
        return $this->sendError($th->getMessage());
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExamenEstudio  $examenEstudio
     * @return \Illuminate\Http\Response
     */
    public function show(ExamenEstudio $examenEstudio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExamenEstudio  $examenEstudio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamenEstudio $examenEstudio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExamenEstudio  $examenEstudio
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamenEstudio $examenEstudio)
    {
        //
    }
}
