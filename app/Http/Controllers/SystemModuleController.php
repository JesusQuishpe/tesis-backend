<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\SystemModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SystemModuleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->has('submodules') && $request->boolean('submodules')) {
      return $this->sendResponse(SystemModule::with('submodules')
        ->where('parent_id', '=', null)
        ->get(), 'Modulos con submodulos');
    }
    return $this->sendResponse(SystemModule::where('parent_id', '=', null)
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
    $module = new SystemModule();
    $module->name = $request->input('name');
    $module->save();
    return $this->sendResponse($module, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\SystemModule  $module
   * @return \Illuminate\Http\Response
   */
  public function show(SystemModule $module)
  {
    return $this->sendResponse($module, 'Modulo');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\SystemModule  $module
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, SystemModule $module)
  {
    $module->name = $request->input('name');
    $module->save();
    return $this->sendResponse($module, 'Modulo actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\SystemModule  $module
   * @return \Illuminate\Http\Response
   */
  public function destroy(SystemModule $module)
  {
    $module->delete();
    return $this->sendResponse([], 'Registro eliminado');
  }

  public function addRolModule(Request $request)
  {
    $roles = $request->input('permissionsGroupedByRol');

    try {
      DB::beginTransaction();
      foreach ($roles as $rol) {
        if ($rol['permissions'] && count($rol['permissions']) > 0) { //Tiene submodulos el permiso
          foreach ($rol['permissions'] as $permission) {
            Permission::updateOrCreate(
              [
                'module_id' => $permission['module_id'],
                'rol_id' => $permission['rol_id']
              ],
              [
                'checked' => $permission['checked']
              ]
            );
          }
        }
        /*Permission::updateOrCreate(
                    [
                        'module_id' => $permission['id'],
                        'rol_id' => $permission['rol_id']
                    ],
                    [
                        'checked' => true
                    ]
                );*/
      }
      DB::commit();
      return $this->sendResponse([], 'Permisos agregados');
    } catch (\Throwable $th) {
      try {
        DB::rollBack();
      } catch (\Throwable $th) {
        throw $th;
      }
      throw $th;
    }
  }
}
