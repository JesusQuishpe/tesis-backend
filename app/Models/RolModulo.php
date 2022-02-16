<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RolModulo extends Model
{
  use HasFactory;
  protected $table = 'rol_modulos';
  protected $fillable = [
    'id_rol',
    'id_modulo',
    'checked'
  ];

  public function modulos()
  {
    return $this->hasMany(Modulo::class, 'id', 'id_modulo');
  }

  public function getPermisosPorRol($idRol)
  {
    $permisos = [];

    $modulos = DB::table('rol_modulos')
      ->join('modulos', 'rol_modulos.id_modulo', 'modulos.id')
      ->select([
        'rol_modulos.id as id_permiso',
        'rol_modulos.id_modulo',
        'rol_modulos.id_rol',
        'modulos.nombre',
        'rol_modulos.checked',
        'modulos.path',
        'modulos.id_parent'
      ])
      ->where('modulos.id_parent', '=', null)
      ->where('rol_modulos.id_rol','=',$idRol)
      ->where('rol_modulos.checked','=',true)
      ->get();

    foreach ($modulos as $modulo) {
      $submodulos = DB::table('rol_modulos')
        ->join('modulos', 'rol_modulos.id_modulo', 'modulos.id')
        ->select([
          'rol_modulos.id as id_permiso',
          'rol_modulos.id_modulo',
          'rol_modulos.id_rol',
          'modulos.nombre',
          'rol_modulos.checked',
          'modulos.path',
          'modulos.id_parent'
        ])
        ->where('id_parent', '=', $modulo->id_modulo)
        ->where('rol_modulos.id_rol','=',$idRol)
        ->get();

      $modulo->submodulos = $submodulos;
      array_push($permisos, $modulo);
    }

    return $permisos;
  }

  public function getPermisos()
  {
    $permisos = [];

    $modulos = DB::table('rol_modulos')
      ->join('modulos', 'rol_modulos.id_modulo', 'modulos.id')
      ->select([
        'rol_modulos.id as id_permiso',
        'rol_modulos.id_modulo',
        'rol_modulos.id_rol',
        'modulos.nombre',
        'rol_modulos.checked',
        'modulos.path',
        'modulos.id_parent'
      ])
      ->where('modulos.id_parent', '=', null)
      ->get();

    foreach ($modulos as $modulo) {
      $submodulos = DB::table('rol_modulos')
        ->join('modulos', 'rol_modulos.id_modulo', 'modulos.id')
        ->select([
          'rol_modulos.id as id_permiso',
          'rol_modulos.id_modulo',
          'rol_modulos.id_rol',
          'modulos.nombre',
          'rol_modulos.checked',
          'modulos.path',
          'modulos.id_parent'
        ])
        ->where('id_parent', '=', $modulo->id_modulo)
        ->get();

      $modulo->submodulos = $submodulos;
      array_push($permisos, $modulo);
    }

    return $permisos;
  }
}
