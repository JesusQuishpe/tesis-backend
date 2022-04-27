<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicinaRequest;
use App\Models\MedicalAppointment;
use App\Models\MedicineArea;
use App\Models\NursingArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicinaController extends Controller
{
    public function index(Request $request)
    {
        //Para obtener información de enfermeria
        if ($request->has('nurId')) {
            $model = new MedicineArea();
            $results = $model->getDataOfNursingArea($request->input('nurId'));
            return $this->sendResponse($results, 'Resultados del paciente por id de enfermeria');
        }
        //Para obtener los pacientes en espera
        if ($request->has('queque')) {
            $model = new MedicineArea();
            $patients = $model->getPatientQueue(); //patients en espera
            return $this->sendResponse($patients, 'Pacientes en espera medicina');
        }
        //Para obtener los resultados por numero de cedula
        if ($request->has('identification')) {
            $model = new MedicineArea();
            $patients = $model->getMedicineRecordsByIdentification($request->input('identification')); //patients en espera
            return $this->sendResponse($patients, 'Pacientes en espera medicina');
        }
        //Devuelve todos los resultados del area de medicina
        $result = MedicineArea::with('nursingArea.medicalAppointment.patient')->get();
        return $this->sendResponse($result, 'Registros del area de medicina');
    }

    public function store(MedicinaRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $validated['attended'] = true;
            MedicineArea::create($validated);
            $cita = MedicalAppointment::find($validated['appo_id']);
            $nur = NursingArea::find($validated['nur_id']);
            $nur->therapy=$request->input('therapy');
            $nur->diabetes = $request->input('diabetes');
            $nur->cardiopathy = $request->input('cardiopathy');
            $nur->hypertension = $request->input('hypertension');
            $nur->surgeries = $request->input('surgeries');
            $nur->medicine_allergies = $request->input('medicine_allergies');
            $nur->food_allergies = $request->input('food_allergies');
            $nur->save();
            $cita->attended = true;
            $cita->save();
            DB::commit();
            return $this->sendResponse([], 'Registro creado');
        } catch (\Throwable $th) {
            //throw $th;
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                throw $th;
            }
            throw $th;
        }
    }

    public function show($medicineId)
    {
        return $this->sendResponse(MedicineArea::with('nursingArea.medicalAppointment.patient')
        ->where('id','=',$medicineId)
        ->firstOrFail(), 'Datos del area de medicina dado el id');
    }

    public function update(MedicinaRequest $request, MedicineArea $medicine)
    {
        try {
            DB::beginTransaction();
            $medicine->update($request->only([
                'symptom1',
                'symptom2',
                'symptom3',
                'presumptive1',
                'presumptive2',
                'presumptive3',
                'definitive1',
                'definitive2',
                'definitive3',
                'medicine1',
                'medicine2',
                'medicine3',
                'medicine4',
                'medicine5',
                'medicine6',
                'dosage1',
                'dosage2',
                'dosage3',
                'dosage4',
                'dosage5',
                'dosage6',
            ]));
            $nur = NursingArea::find($request->input('nur_id'));
            $nur->therapy=$request->input('therapy');
            $nur->diabetes = $request->input('diabetes');
            $nur->cardiopathy = $request->input('cardiopathy');
            $nur->hypertension = $request->input('hypertension');
            $nur->surgeries = $request->input('surgeries');
            $nur->medicine_allergies = $request->input('medicine_allergies');
            $nur->food_allergies = $request->input('food_allergies');
            $nur->save();
            DB::commit();
            return $this->sendResponse([], 'Registro actualizado');
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                throw $th;
            }
            throw $th;
        }
    }

    public function destroy($nurId)
    {
        try {
            DB::beginTransaction();
            $nur = NursingArea::find($nurId);
            $appo=MedicalAppointment::find($nur->appo_id);
            $nur->delete();
            $appo->delete();
            DB::commit();
            return $this->sendResponse([], 'Valores de enfermeria y cita eliminados correctamente');
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
