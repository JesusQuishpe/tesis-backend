<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medicina extends Model
{
    use HasFactory;

    protected $table='medicina';

    public function getPacientes()
    {
        return DB::table('enfermeria')
        ->join('citas','enfermeria.id_cita','citas.id')
        ->join('pacientes','citas.id_paciente','pacientes.id')
        ->select([
            'enfermeria.id',
            'enfermeria.peso',
            'enfermeria.estatura',
            'enfermeria.temperatura',
            'enfermeria.presion',
            'enfermeria.terapia',
            'enfermeria.discapacidad',
            'enfermeria.embarazo',
            'enfermeria.inyeccion',
            'enfermeria.curacion',
            'enfermeria.medico',
            'pacientes.nombre_completo',
            'pacientes.id as id_paciente',
            'pacientes.fecha_nacimiento',
            'citas.id as id_cita',

        ])
        ->where('citas.fecha_cita','=',Carbon::now()->format('Y-m-d'))
        ->where('citas.area','=','Medicina')
        ->orderBy('citas.hora_cita')
        ->get();
    }
}
