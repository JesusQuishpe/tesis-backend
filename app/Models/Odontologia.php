<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontologia extends Model
{
    use HasFactory;
    
    public function getPacientesEnEspera()
    {
        return Enfermeria::join('citas', 'enfermeria.id_cita', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', 'pacientes.id')
            ->select([
                'enfermeria.id as id_enfermeria',
                'pacientes.cedula',
                'pacientes.nombre_completo',
                'citas.fecha_cita',
                'citas.hora_cita',
                'citas.id as id_cita'
            ])
            ->where('enfermeria.atendido', '=', true)
            ->where('citas.atendido', '=', false)
            ->where('citas.area', '=', 'Odontologia')
            ->where('citas.fecha_cita', '=', Carbon::now()->format('Y-m-d'))
            ->orderBy('citas.hora_cita','asc')
            ->get();
    }
}
