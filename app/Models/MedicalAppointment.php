<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAppointment extends Model
{
    use HasFactory;
    protected $table='medical_appointments';
    protected $fillable = [
        'user_id',
        'date',
        'hour',
        'appo_identification_number',
        'area',
        'value',
        'initial_value',
        //'factura_cita',
        //'estado_cita',
        'patient_id',
        //'statistics',
        'attended'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }

}
