<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class LbOrden extends Model
{
    use HasFactory;
    protected $table='lb_ordenes';


    public function ordenActualPorCedula($cedula)
    {
        $orden=LbOrden::join('citas','lb_ordenes.id_cita','citas.id')
        ->join('pacientes','citas.id_paciente','pacientes.id')
        ->select([
            'lb_ordenes.*',
            'pacientes.nombre_completo as paciente',
            'pacientes.sexo',
            'pacientes.telefono',
            'pacientes.cedula',
            'pacientes.fecha_nacimiento'
        ])
        ->where('pacientes.cedula','=',$cedula)
        ->orderBy('lb_ordenes.fecha','desc')
        ->orderBy('lb_ordenes.hora','desc')
        ->firstOrFail();
        $pruebas=LbOrdenPrueba::with('prueba')->where('id_orden','=',$orden->id)->get();

        $orden->pruebas=$pruebas;
        return $orden;
    }
    public function ordenesPendientesPorCedula($cedula)
    {
        return LbOrden::join('citas','lb_ordenes.id_cita','citas.id')
        ->join('pacientes','citas.id_paciente','pacientes.id')
        ->select([
            'lb_ordenes.*',
        ])
        ->where('pacientes.cedula','=',$cedula)
        ->where('lb_ordenes.pendiente','=',true)
        ->get();
    }
}
