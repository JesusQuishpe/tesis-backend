<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table='pacientes';
    protected $fillable=[
        'fecha',
        'cedula',
        'apellidos',
        'nombres',
        'nombre_completo',
        'fecha_nacimiento',
        'sexo',
        'telefono',
        'domicilio',
        'provincia',
        'ciudad'
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
        'fecha',
        'estadisticas',
        'fecha_historial',
        'historial'
    ];

    /**
     * Busca todos los pacientes que coincidan con 
     * el apellido o la cedula
     * @param string $texto cedula 
     */
    public function buscarPorCedula($query)
    {
        return Paciente::where('cedula', '=', $query)
            ->firstOrFail();
    }

    /**
     * Busca todos los pacientes que coincidan con 
     * el apellido o la cedula
     * @param string $texto cedula o apellidos del paciente
     */
    public function buscarPorCedulaOApellidos($query)
    {
        if($query===""){
            return Paciente::take(10);
        }else{
            return Paciente::where('cedula', '=', $query)
            ->orWhere('nombre_completo', 'LIKE','%'.$query.'%')
            ->get();
        }
    }
}
