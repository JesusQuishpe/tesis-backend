<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Rol;
use App\Models\RolModulo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->sendResponse(User::join('roles','id_rol','roles.id')
    ->select([
      'users.*',
      'roles.nombre as rol'
    ])
    ->get(), 'Usuarios');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $user = new User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));
    $user->id_rol = $request->input('rol');
    $user->save();
    return $this->sendResponse($user, 'Registro creado');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    return $this->sendResponse($user, 'Usuario');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));
    $user->rol = $request->input('rol');
    $user->save();
    return $this->sendResponse($user, 'Usuario actualizado');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\User  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    $user->delete();
    return $this->sendResponse([], 'Registro eliminado');
  }

  public function login(Request $request)
  {
    $email = $request->input('email');
    $password = $request->input('password');
    $user = User::where('email', '=', $email)->first();
    if (!$user) {
      return $this->sendError('No existe el usuario');
    }
    if ($user->email !== $email || !Hash::check($password, $user->password)) {
      return $this->sendError('Credenciales incorrectas', [], 401);
    }

    $rolModulo = new RolModulo();
    $permisos = $rolModulo->getPermisosPorRol($user->id_rol);

    return $this->sendResponse([
      'name' => $user->name,
      'email' => $user->email,
      'id_rol' => $user->id_rol,
      'permisos' => $permisos
    ], 'Usuario logueado');
  }

  public function permisos()
  {
    $rolModulo = new RolModulo();
    $permisos = $rolModulo->getPermisos();
    return $this->sendResponse($permisos, 'Permisos del usuario');
  }
}
