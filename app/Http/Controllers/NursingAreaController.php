<?php

namespace App\Http\Controllers;

use App\Http\Requests\NursingAreaRequest;
use App\Models\MedicalAppointment;
use App\Models\NursingArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NursingAreaController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('identification')) {
            $model = new NursingArea();
            $result = $model->searchByIdentification($request->input('identification'));
            return $this->sendResponse($result, 'Resultados por cedula');
        }
        return $this->sendResponse(NursingArea::all(), 'Datos de la tabla enfermeria');
    }

    public function show(NursingArea $nur)
    {
        return $this->sendResponse($nur->with('medicalAppointment')->find($nur->id), 'Registro de enfermeria');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $nur = new NursingArea();
            $nur->user_id = $request->input('user_id');
            $nur->appo_id = $request->input('appo_id');
            $nur->weight = $request->input('weight');
            $nur->stature = $request->input('stature');
            $nur->temperature = $request->input('temperature');
            $nur->pressure = $request->input('pressure');
            $nur->doctor = $request->input('doctor');
            $nur->nurse = $request->input('nurse');
            $nur->disability = $request->input('disability');
            $nur->healing = $request->input('healing');
            $nur->inyection = $request->input('inyection');
            $nur->pregnancy = $request->input('pregnancy');
            $nur->attended = true;
            $nur->save();

            $appo = MedicalAppointment::find($request->input('appo_id'));
            $appo->nur_attended = true;
            $appo->save();
            DB::commit();
            return $this->sendResponse($nur, 'Registro guardado');
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                throw $th;
            }
            throw $th;
        }
    }

    public function update(Request $request, NursingArea $nur)
    {
        $nur->user_id = $request->input('user_id');
        $nur->weight = $request->input('weight');
        $nur->stature = $request->input('stature');
        $nur->temperature = $request->input('temperature');
        $nur->pressure = $request->input('pressure');
        $nur->doctor = $request->input('doctor');
        $nur->nurse = $request->input('nurse');
        $nur->disability = $request->input('disability');
        $nur->healing = $request->input('healing');
        $nur->inyection = $request->input('inyection');
        $nur->pregnancy = $request->input('pregnancy');
        $nur->save();
        return $this->sendResponse($nur, 'Registro actualizado');
    }

    public function patients()
    {
        $model = new NursingArea();
        $data = $model->getPatientQueue();
        return $this->sendResponse($data, 'Pacientes en espera enfermeria');
    }

    public function destroy(NursingArea $nur)
    {
        try {
            DB::beginTransaction();
            $nurId=$nur->id;
            $nur->delete();
            MedicalAppointment::where('id',$nurId)->delete();
            DB::commit();
            return $this->sendResponse([], 'Valores de cita eliminados correctamente',204);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
