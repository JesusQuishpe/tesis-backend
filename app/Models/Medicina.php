<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Medicina extends Model
{
    use HasFactory;

    protected $table = 'medicina';
    protected $fillable = [
        'id_enfermeria',
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
        'atendido'
    ];





    public function getPacientes()
    {
        return DB::table('enfermeria')
            ->join('citas', 'enfermeria.id_cita', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', 'pacientes.id')
            ->select([
                'enfermeria.id as id_enfermeria',
                'enfermeria.peso',
                'enfermeria.estatura',
                'enfermeria.temperatura',
                'enfermeria.presion',
                'enfermeria.terapia',
                'enfermeria.discapacidad',
                'enfermeria.embarazo',
                'enfermeria.inyeccion',
                'enfermeria.curacion',
                'enfermeria.doctor',
                'pacientes.id as id_paciente',
                'pacientes.cedula',
                'pacientes.nombres',
                'pacientes.apellidos',
                'pacientes.sexo',
                'pacientes.nombre_completo',
                'pacientes.fecha_nacimiento',
                'citas.id as id_cita',
            ])
            ->where('citas.fecha_cita', '=', Carbon::now()->format('Y-m-d'))
            ->where('citas.area', '=', 'Medicina')
            ->where('citas.atendido','=',false)
            ->where('enfermeria.atendido', '=', true)
            ->orderBy('citas.hora_cita')
            ->get();
    }

    public function getResultadosPorCedula($cedula)
    {
        return Medicina::join('enfermeria','medicina.id_enfermeria','enfermeria.id')
        ->join('citas','enfermeria.id_cita','citas.id')
        ->join('pacientes','citas.id_paciente','pacientes.id')
        ->select([
            'enfermeria.id as id_enfermeria',
            'enfermeria.peso',
            'enfermeria.estatura',
            'enfermeria.temperatura',
            'enfermeria.presion',
            'enfermeria.terapia',
            'enfermeria.discapacidad',
            'enfermeria.embarazo',
            'enfermeria.inyeccion',
            'enfermeria.curacion',
            'enfermeria.doctor',
            'enfermeria.cardiopatia',
            'enfermeria.hipertension',
            'enfermeria.cirugias',
            'enfermeria.diabetes',
            'enfermeria.alergias_medicina',
            'enfermeria.alergias_comida',
            'pacientes.id as id_paciente',
            'pacientes.cedula',
            'pacientes.nombres',
            'pacientes.apellidos',
            'pacientes.sexo',
            'pacientes.nombre_completo',
            'pacientes.fecha_nacimiento',
            'citas.id as id_cita',
            'medicina.id as id_medicina',
            'medicina.*'
        ])
        ->where('pacientes.cedula','=',$cedula)
        ->orderBy('citas.fecha_cita','desc')
        ->orderBy('citas.hora_cita','desc')
        ->firstOrFail();
    }
}
