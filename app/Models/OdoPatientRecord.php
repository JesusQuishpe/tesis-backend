<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoPatientRecord extends Model
{
    use HasFactory;
    protected $table='odo_patient_records';

    public function getPatientQueue()
    {
        return NursingArea::join('medical_appointments', 'nursing_area.appo_id', 'medical_appointments.id')
            ->join('patients', 'medical_appointments.patient_id', 'patients.id')
            ->select([
                'nursing_area.id as nur_id',
                'patients.identification_number',
                'patients.fullname as patient',
                'medical_appointments.date',
                'medical_appointments.hour',
                'medical_appointments.id as appo_id'
            ])
            //->where('nursing_area.attended', '=', true)
            ->where('medical_appointments.attended', '=', false)
            ->where('medical_appointments.nur_attended', '=', true)
            ->where('medical_appointments.area', '=', 'Odontologia')
            ->where('medical_appointments.date', '=', Carbon::now()->format('Y-m-d'))
            ->orderBy('medical_appointments.hour','asc')
            ->get();
    }


    public function getPatientRecordData($rec_id)
    {

        $patientRecord = OdoPatientRecord::with('nursingArea.medicalAppointment.patient')->find($rec_id);
        //dd($patientRecord);
        $nur=$patientRecord->nursingArea;
        $appo=$nur->medicalAppointment;
        $patient=$appo->patient;
        $familyHistory = OdoFamilyHistory::with('details')->where('rec_id', '=', $patientRecord->id)->first();
        $stomatognathicTest = OdoStomatognathicTest::with('details')->where('rec_id', '=', $patientRecord->id)->first();
        $indicator = OdoIndicator::with('details')->where('rec_id', '=', $patientRecord->id)->first();
        $cpoCeoRatios=OdoCpoCeoRatio::where('rec_id', '=', $patientRecord->id)->first();
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
            'patient' => $patient,
            'patient_record'=>$patientRecord,
            'nursingArea' => $nur,
            'diseaseList' => $diseaseList,
            'pathologies' => $pathologies,
            'plans' => $plans,
            'cies' => $cies,
            'teeth' => $teeth,
            'familyHistory'=>$familyHistory,
            'stomatognathicTest'=>$stomatognathicTest,
            'indicator'=>$indicator,
            'cpoCeoRatios'=>$cpoCeoRatios,
            'planDiagnostic'=>$planDiagnostic,
            'diagnostics'=>$diagnostics,
            'treatments'=>$treatments,
            'odontogram' => $odontogram
        ];

        return $result;
    }

    public function nursingArea()
    {
        return $this->belongsTo(NursingArea::class,'nur_id','id');
    }
}
