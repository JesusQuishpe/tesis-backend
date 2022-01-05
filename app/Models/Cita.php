<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $table='citas';
    protected $fillable = [
        'fecha_cita',
        'hora_cita', 
        'cedula_cita',
        'area',
        'valor',
        'factura_cita',
        'estado_cita',
        'id_paciente',
        'estadisticas'
    ];
}
