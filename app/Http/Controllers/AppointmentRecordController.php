<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRecord;
use App\Models\MedicalAppointment;
use App\Models\OdoPatientRecord;
use Illuminate\Http\Request;

class AppointmentRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($identification)
    {

        $result=OdoPatientRecord::join('nursing_area','nur_id','=','nursing_area.id')
        ->join('medical_appointments','nursing_area.appo_id','=','medical_appointments.id')
        ->join('patients','medical_appointments.patient_id','=','patients.id')
        ->select([
            'medical_appointments.id as appo_id',
            'odo_patient_records.id as rec_id',
            'patients.fullname as patient',
            'odo_patient_records.date',
            'odo_patient_records.hour',
            'nursing_area.id as nur_id'
        ])
        ->where('patients.identification_number','=',$identification)
        ->get();
        return $this->sendResponse($result,'Fichas odontologicas por cedula');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppointmentRecord  $appointmentRecord
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalAppointment $appo,OdoPatientRecord $patrec)
    {
        $data=[
            'rec_id'=>$patrec->id,
            'appo_id'=>$appo->id,

        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppointmentRecord  $appointmentRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppointmentRecord $appointmentRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppointmentRecord  $appointmentRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentRecord $appointmentRecord)
    {
        //
    }
}
