<?php

namespace App\Http\Controllers;


use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
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
        return $this->sendResponse(User::join('roles', 'rol_id', 'roles.id')
            ->select([
                'users.*',
                'roles.name as rol'
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
        $user->rol_id = $request->input('rol');
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
        if(Hash::check($request->input('old_password'),$user->password)){
            $user->password = Hash::make($request->input('password'));
        }else{
            return $this->sendError('La contraseña actual inválida',[],401);
        }

        $user->rol_id = $request->input('rol');
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

        $permission = new Permission();
        $user_permissions = $permission->getPermissionsByRol($user->rol_id);

        return $this->sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rol_id' => $user->rol_id,
            'permissions' => $user_permissions
        ], 'Usuario logueado');
    }

    public function permissions()
    {
        $permission = new Permission();
        $user_permissions = $permission->getPermissions();
        return $this->sendResponse($user_permissions, 'Permisos del usuario');
    }
}
