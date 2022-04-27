<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Buscar paciente por cedula o nombre completo
        if ($request->has('identification') && $request->has('isSearch')) {
            return $this->sendResponse(
                Patient::where('identification_number', '=', $request->input('identification'))
                ->paginate(1, '*', 'page', 1),
                'Buscar paciente por cedula para mostrar en tabla'
            );
        }

        if ($request->has('identification_number')) {
            $model = new Patient();
            $patient = $model->searchByIdentification($request->input('identification_number'));
            return $this->sendResponse($patient, 'Paciente por cedula');
        }

        if ($request->has('query')) {
            $model = new Patient();
            $patient = $model->searchByIdentificationOrLastname($request->input('query'));
            return $this->sendResponse($patient, 'Paciente por cedula o apellido');
        }
        return $this->sendResponse(Patient::paginate(10), 'Pacientes');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d');
        //$hora = Carbon::now()->format('H:i:s');

        $data = $request->only(
            [
                'identification_number', 'lastname', 'name',
                'birth_date', 'gender', 'cellphone_number',
                'address', 'province',
                'city'
            ]
        );

        $data['date'] = $date;
        $data['fullname'] = $data['name'] . ' ' . $data['lastname'];
        $pac = Patient::create($data);
        $pac->save();
        return $this->sendResponse($pac, 'Paciente creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return $this->sendResponse($patient, 'Paciente por id');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $date = Carbon::now()->format('Y-m-d');
        //$hora = Carbon::now()->format('H:i:s');
        $data = $request->only(
            [
                'identification_number', 'lastname', 'name',
                'birth_date', 'gender', 'cellphone_number',
                'address', 'province',
                'city'
            ]
        );
        $data['date'] = $date;
        $data['fullname'] = $data['name'] . ' ' . $data['lastname'];
        $patient->update($data);
        return $this->sendResponse($patient, 'Paciente actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return $this->sendResponse([], 'Registro eliminado correctamente');
    }
}
