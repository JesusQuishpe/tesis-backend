<?php

namespace App\Http\Controllers;

use App\Models\MedAllergie;
use App\Models\MedFamilyHistory;
use App\Models\MedicalRecord;
use App\Models\MedInterrogation;
use App\Models\MedLifestyle;
use App\Models\MedPhysicalExploration;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('identification')) {
            return $this->sendResponse(
                MedicalRecord::join('patients', 'patient_id', '=', 'patients.id')
                    ->select([
                        'medical_records.id as id',
                        'patients.id as patient_id',
                        'patients.identification_number',
                        'patients.city',
                        'patients.fullname'
                    ])
                    ->where('patients.identification_number', $request->identification)
                    ->first(),
                'Expediente del paciente'
            );
        }
        return $this->sendResponse(MedicalRecord::join('patients', 'patient_id', '=', 'patients.id')
            ->select([
                'medical_records.id as id',
                'patients.id as patient_id',
                'patients.identification_number',
                'patients.city',
                'patients.fullname'
            ])
            ->paginate(10), 'Expedientes medicos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $record = MedicalRecord::create($request->all());
        return $this->sendResponse($record, 'Registro creado correctamente', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->sendResponse(
            MedicalRecord::with(
                ['patient', 'antecedentes', 'exploracion', 'interrogatorio', 'estiloDeVida', 'alergias']
            )->find($id),
            'Expediente del paciente por id'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        try {
            DB::beginTransaction();
            $recId = $request->input('id');
            $patientInfo = $request->input('patientInfo');
            //Actualizamos la informacion del paciente, personal y adicional
            Patient::find($patientInfo['id'])->update($patientInfo);
            //Actualizamos los antecedentes
            MedFamilyHistory::where('recordId', $recId)->update($request->input('familyHistory'));
            //Actualizamos la exploracion fisica
            MedPhysicalExploration::where('recordId', $recId)->update($request->input('physicalExploration'));
            //Actualizamos el interrogatorio
            MedInterrogation::where('recordId', $recId)->update($request->input('interrogation'));
            //Actualizamos el estilo de vida
            MedLifestyle::where('recordId', $recId)->update($request->input('lifestyle'));
            //Actualizamos las alergias
            $alergieModel = MedAllergie::where('recordId', $recId)->firstOrFail();
            $alergieModel->description = $request->input('alergies.description');
            $alergieModel->save();
            DB::commit();
            return $this->sendResponse([], 'Expediente actualizado correctamente', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalRecord  $medicalRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
        return $this->sendResponse([], 'Expediente eliminado', 204);
    }
}
