<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NursingArea extends Model
{
    use HasFactory;
    protected $table='nursing_area';
    protected $fillable=[
        'user_id',
        'appo_id',
        'weight',
        'stature',
        'temperature',
        'pressure',
        //'nursing_area',
        'doctor',
        'therapy',
        'disability',
        'inyection',
        'healing',
        'pregnancy',
        'nurse',
        'cardiopathy',
        'diabetes',
        'hypertension',
        'surgeries',
        'medicine_allergies',
        'food_allergies',
        //'consulting_room',
        'attended'
    ];



    public function getPatientQueue()
    {
        return DB::table('medical_appointments')
            ->join('patients', 'medical_appointments.patient_id', 'patients.id')
            ->select(
                [
                    'medical_appointments.id as appo_id',
                    'patients.fullname as patient',
                    'patients.birth_date',
                    'patients.gender',
                    'patients.identification_number',
                    'medical_appointments.area',
                    'medical_appointments.created_at'
                ]
            )
            ->where('medical_appointments.date','=',Carbon::now()->format('Y-m-d'))
            ->where('medical_appointments.area', '!=', 'Laboratorio')
            //->where('medical_appointments.estadisticas', '!=', 'o')
            ->where('medical_appointments.attended', '=', false)
            ->where('medical_appointments.nur_attended', '=', false)
            ->where('medical_appointments.cancelled','=',false)
            //->orderBy('medical_appointments.date','asc')
            ->orderBy('medical_appointments.hour','asc')
            ->get();
    }

    public function searchByIdentification($identification)
    {
        return NursingArea::join('medical_appointments','appo_id','=','medical_appointments.id')
        ->join('patients','medical_appointments.patient_id','=','patients.id')
        ->select([
            'medical_appointments.id as appo_id',
            'medical_appointments.date',
            'medical_appointments.hour',
            'nursing_area.id as nur_id',
            'nursing_area.doctor'
        ])
        ->where('patients.identification_number','=',$identification)
        ->get();
    }
    public function medicalAppointment()
    {
        return $this->belongsTo(MedicalAppointment::class,'appo_id','id');
    }
}
