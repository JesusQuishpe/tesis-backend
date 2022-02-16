<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicinaRequest;
use App\Models\Cita;
use App\Models\Enfermeria;
use App\Models\Medicina;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicinaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('cedula')) {
            $model = new Medicina();
            $resultados = $model->getResultadosPorCedula($request->input('cedula'));
            return $this->sendResponse($resultados, 'Resultados del paciente');
        }
        $model = new Medicina();
        $pacientes = $model->getPacientes();
        //$pacientes=Carbon::now()->format('Y-m-d');
        return $this->sendResponse($pacientes, 'Pacientes en espera medicina');
    }

    public function store(MedicinaRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $validated['atendido'] = true;
            Medicina::create($validated);
            $cita = Cita::find($validated['id_cita']);
            $enfermeria = Enfermeria::find($validated['id_enfermeria']);
            $enfermeria->diabetes = $request->input('diabetes');
            $enfermeria->cardiopatia = $request->input('cardiopatia');
            $enfermeria->hipertension = $request->input('hipertension');
            $enfermeria->cirugias = $request->input('cirugias');
            $enfermeria->alergias_medicina = $request->input('alergias_medicina');
            $enfermeria->alergias_comida = $request->input('alergias_comida');
            $enfermeria->save();
            $cita->atendido = true;
            $cita->update();
            DB::commit();
            return $this->sendResponse([], 'Registro creado');
        } catch (\Throwable $th) {
            //throw $th;
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                return $this->sendError($th->getMessage());
            }
            return $this->sendError($th->getMessage());
        }
    }
    public function update(MedicinaRequest $request, Medicina $medicina)
    {
        try {
            DB::beginTransaction();
            $medicina->update($request->only([
                'sintoma1',
                'sintoma2',
                'sintoma3',
                'presuntivo1',
                'presuntivo2',
                'presuntivo3',
                'definitivo1',
                'definitivo2',
                'definitivo3',
                'medicamento1',
                'medicamento2',
                'medicamento3',
                'medicamento4',
                'medicamento5',
                'medicamento6',
                'dosificacion1',
                'dosificacion2',
                'dosificacion3',
                'dosificacion4',
                'dosificacion5',
                'dosificacion6',
            ]));
            $enfermeria = Enfermeria::find($request->input('id_enfermeria'));
            $enfermeria->diabetes = $request->input('diabetes');
            $enfermeria->cardiopatia = $request->input('cardiopatia');
            $enfermeria->hipertension = $request->input('hipertension');
            $enfermeria->cirugias = $request->input('cirugias');
            $enfermeria->alergias_medicina = $request->input('alergias_medicina');
            $enfermeria->alergias_comida = $request->input('alergias_comida');
            $enfermeria->save();
            DB::commit();
            return $this->sendResponse([], 'Registro actualizado');
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
