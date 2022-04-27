<?php

namespace App\Http\Controllers;

use App\Models\Cie;
use App\Models\MedicalAppointment;
use App\Models\NursingArea;
use App\Models\OdoCpoCeoRatio;
use App\Models\OdoDiagnostic;
use App\Models\OdoDiagnosticPlan;
use App\Models\OdoDiseaseList;
use App\Models\OdoFamilyHistory;
use App\Models\OdoIndicator;
use App\Models\OdoOdontogram;
use App\Models\OdoPathologie;
use App\Models\OdoPatientRecord;
use App\Models\OdoPlan;
use App\Models\OdoStomatognathicTest;
use App\Models\OdoTooth;
use App\Models\OdoTreatment;
use Exception;

class OdoPatientRecordController extends Controller
{

    public function patients()
    {
        $model = new OdoPatientRecord();
        $patients = $model->getPatientQueue();
        return $this->sendResponse($patients, 'Pacientes en espera');
    }


    public function result($appo_id)
    {
        $appo = MedicalAppointment::findOrFail($appo_id);
        if ($appo->attended === 1) {
            return $this->sendResponse([
                'message' => 'La cita ya ha sido atendida',
                'attended' => true
            ], 'Cita atendida');
        }
        $patient = $appo->patient;
        $nur = NursingArea::where('appo_id', '=', $appo->id)->firstOrFail();
        $disease_list = OdoDiseaseList::all();
        $pathologies = OdoPathologie::all();
        $plans = OdoPlan::all();
        $cies = Cie::all();
        $teeth = OdoTooth::all();
        //Para obtener el ultimo odontograma
        $odontologyModel = OdoPatientRecord::join('nursing_area', 'odo_patient_records.nur_id', '=', 'nursing_area.id')
            ->join('medical_appointments', 'nursing_area.appo_id', '=', 'medical_appointments.id')
            ->select([
                'odo_patient_records.*'
            ])
            ->where('medical_appointments.patient_id', '=', $patient->id)
            ->where('medical_appointments.attended', '=', true)
            ->orderBy('odo_patient_records.date', 'desc')
            ->orderBy('odo_patient_records.hour', 'desc')
            ->skip(0)
            ->take(1)
            ->first();
        $odontogram = null;
        if ($odontologyModel) {
            $odontogram = OdoOdontogram::with('teeth.symbologie', 'movilitiesRecessions')->where('rec_id', '=', $odontologyModel->id)->first();
        }
        $result = [
            'patient' => $patient,
            'nursing_area' => $nur,
            'disease_list' => $disease_list,
            'pathologies' => $pathologies,
            'plans' => $plans,
            'cies' => $cies,
            'teeth' => $teeth,
            'odontogram' => $odontogram
        ];
        return $this->sendResponse($result, 'Informacion del paciente');
    }

    public function patientRecord($appo_id, $nur_id, $rec_id)
    {
        $appo = MedicalAppointment::find($appo_id);
        $nur = NursingArea::find($nur_id);
        $patientRecord = OdoPatientRecord::find($rec_id);
        $familyHistory = OdoFamilyHistory::with('details')->where('rec_id', '=', $patientRecord->id)->first();
        $stomatognathicTest = OdoStomatognathicTest::with('details')->where('rec_id', '=', $patientRecord->id)->first();
        $indicator = OdoIndicator::with('details')->where('rec_id', '=', $patientRecord->id)->first();
        $cpoCeoRatios = OdoCpoCeoRatio::where('rec_id', '=', $patientRecord->id)->first();
        $planDiagnostic = OdoDiagnosticPlan::with('details.plan')->where('rec_id', '=', $patientRecord->id)->first();
        $diagnostics = OdoDiagnostic::with('cie')->where('rec_id', '=', $patientRecord->id)->get();
        $treatments = OdoTreatment::where('rec_id', '=', $patientRecord->id)->get();
        $odontogram = OdoOdontogram::with('teeth.symbologie', 'movilitiesRecessions')
            ->where('rec_id', '=', $patientRecord->id)->first();

        $diseaseList = OdoDiseaseList::all();
        $pathologies = OdoPathologie::all();
        $plans = OdoPlan::all();
        $cies = Cie::all();
        $teeth = OdoTooth::all();

        $result = [
            'patient' => $appo->patient,
            'patient_record' => $patientRecord,
            'nursingArea' => $nur,
            'diseaseList' => $diseaseList,
            'pathologies' => $pathologies,
            'plans' => $plans,
            'cies' => $cies,
            'teeth' => $teeth,
            'familyHistory' => $familyHistory,
            'stomatognathicTest' => $stomatognathicTest,
            'indicator' => $indicator,
            'cpoCeoRatios' => $cpoCeoRatios,
            'planDiagnostic' => $planDiagnostic,
            'diagnostics' => $diagnostics,
            'treatments' => $treatments,
            'odontogram' => $odontogram
        ];
        return $this->sendResponse($result, 'Datos de la ficha del paciente');
    }
}
