<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\RolModulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ModuloController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->has('submodulos') && $request->boolean('submodulos')) {
      return $this->sendResponse(Modulo::with('submodulos')
        ->where('id_parent', '=', null)
        ->get(), 'Modulos con submodulos');
    }
    return $this->sendResponse(Modulo::where('id_parent', '=', null)
      ->where('enable', '=', true)
      ->get(), 'Modulos');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $modulo = new Modulo();
    $modulo->nombre = $request->input('nombre');
    $modulo->save();
    return $this->sendResponse($modulo, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Modulo  $modulo
   * @return \Illuminate\Http\Response
   */
  public function show(Modulo $modulo)
  {
    return $this->sendResponse($modulo, 'Modulo');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Modulo  $modulo
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Modulo $modulo)
  {
    $modulo->nombre = $request->input('nombre');
    $modulo->save();
    return $this->sendResponse($modulo, 'Modulo actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Modulo  $modulo
   * @return \Illuminate\Http\Response
   */
  public function destroy(Modulo $modulo)
  {
    //
  }

  public function addRolModule(Request $request)
  {
    $permisos = $request->input('permisos');
    try {
      DB::beginTransaction();
      foreach ($permisos as $permiso) {
        if ($permiso['submodulos'] && count($permiso['submodulos']) > 0) { //Tiene submodulos el permiso
          foreach ($permiso['submodulos'] as $submodulo) {
            RolModulo::updateOrCreate(
              [
                'id_modulo' => $submodulo['id_modulo'],
                'id_rol' => $submodulo['id_rol']
              ],
              [
                'checked' => $submodulo['checked']
              ]
            );
          }
        }
        RolModulo::updateOrCreate(
          [
            'id_modulo' => $permiso['id_modulo'],
            'id_rol' => $permiso['id_rol']
          ],
          [
            'checked' => $permiso['checked']
          ]
        );
      }
      DB::commit();
      return $this->sendResponse([], 'Permisos agregados');
    } catch (\Throwable $th) {
      try {
        DB::rollBack();
      } catch (\Throwable $th) {
        return $this->sendError($th->getMessage());
      }
      return $this->sendError($th->getMessage());
    }
  }
}
