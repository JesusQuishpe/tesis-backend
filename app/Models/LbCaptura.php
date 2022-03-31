<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbCaptura extends Model
{
    use HasFactory;
    protected $table = 'lb_capturas';

    public function resultadosPorCedula($cedula)
    {
        return LbCaptura::join('lb_ordenes', 'lb_capturas.id_orden', '=', 'lb_ordenes.id')
            ->join('citas', 'lb_ordenes.id_cita', '=', 'citas.id')
            ->select([
                'lb_ordenes.fecha',
                'lb_ordenes.hora',
                'lb_ordenes.id as id_orden',
                'lb_capturas.id as id_captura',
                'lb_ordenes.numPruebas',
                'lb_ordenes.total'
            ])
            ->where('citas.cedula_cita', '=', $cedula)
            ->orderBy('lb_ordenes.fecha', 'asc')
            ->orderBy('lb_ordenes.hora', 'asc')
            ->get();
    }

    public function orden()
    {
        return $this->hasOne(LbOrden::class, 'id', 'id_orden');
    }

    public function pruebas()
    {
        return $this->belongsToMany(LbPrueba::class, 'lb_captura_resultados', 'id_prueba', 'id')
            ->withPivot('resultado_string', 'resultado_numerico', 'observaciones');
    }

    public function resultados($idCaptura)
    {
        $cabecera = LbCaptura::join('lb_ordenes', 'lb_capturas.id_orden', '=', 'lb_ordenes.id')
            ->join('citas', 'lb_ordenes.id_cita', '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->select([
                'lb_capturas.id as id_captura',
                'lb_ordenes.id as id_orden',
                'lb_ordenes.fecha',
                'lb_ordenes.hora',
                'lb_ordenes.numPruebas',
                'lb_ordenes.total',
                'pacientes.nombre_completo as paciente',
                'pacientes.cedula',
                'pacientes.sexo',
                'pacientes.telefono',
                'pacientes.fecha_nacimiento'
            ])
            ->where('lb_capturas.id', '=', $idCaptura)
            ->firstOrFail();
        $pruebas = LbCapturaResultado::join('lb_pruebas', 'lb_captura_resultados.id_prueba', '=', 'lb_pruebas.id')
            ->select([
                'lb_pruebas.*',
                'lb_captura_resultados.resultado_string',
                'lb_captura_resultados.resultado_numerico',
                'lb_captura_resultados.observaciones',
                'lb_captura_resultados.id as id_captura_resultado',
            ])
            ->get();
        $cabecera->pruebas = $pruebas;
        return $cabecera;
    }
}
