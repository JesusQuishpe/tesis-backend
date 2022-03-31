<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PacienteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Buscar paciente por cedula o nombre completo
        if ($request->has('cedula')) {
            $model = new Paciente();
            $paciente = $model->buscarPorCedula($request->input('cedula'));
            return $this->sendResponse($paciente,'Paciente por cedula');
        }

        if ($request->has('query')) {
            $model = new Paciente();
            $paciente = $model->buscarPorCedulaOApellidos($request->input('query'));
            return response()->json($paciente);
        }
        return $this->sendResponse(Paciente::all(), 'Pacientes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha = Carbon::now()->format('Y-m-d');
        //$hora = Carbon::now()->format('H:i:s');

        $data = $request->only(
            [
                'cedula', 'apellidos', 'nombres',
                'fecha_nacimiento', 'sexo', 'telefono',
                'domicilio', 'provincia',
                'ciudad'
            ]
        );

        $data['fecha'] = $fecha;
        $data['nombre_completo'] = $data['nombres'] . ' ' . $data['apellidos'];
        $pac = Paciente::create($data);
        $pac->save();
        return $this->sendResponse($pac, 'Paciente creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente)
    {
        return $this->sendResponse($paciente, 'Paciente por id');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paciente $paciente)
    {
        $fecha = Carbon::now()->format('Y-m-d');
        //$hora = Carbon::now()->format('H:i:s');
        $data = $request->only(
            [
                'cedula', 'apellidos', 'nombres',
                'fecha_nacimiento', 'sexo', 'telefono',
                'domicilio', 'provincia',
                'ciudad'
            ]
        );
        $data['fecha'] = $fecha;
        $data['nombre_completo'] = $data['nombres'] . ' ' . $data['apellidos'];
        $paciente->update($data);
        return $this->sendResponse($paciente, 'Paciente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
    }
}
