<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table='patients';
    protected $fillable=[
        'date',
        'identification_number',
        'lastname',
        'name',
        'fullname',
        'birth_date',
        'gender',
        'cellphone_number',
        'address',
        'province',
        'city'
    ];
    protected $hidden=[
        'created_at',
        'updated_at',
        'date',
        'statistics',
        'history_date',
        'medical_history'
    ];

    /**
     * Busca todos los pacientes que coincidan con
     * el apellido o la cedula
     * @param string $texto cedula
     */
    public function searchByIdentification($query)
    {
        return Patient::where('identification_number', '=', $query)
            ->firstOrFail();
    }

    /**
     * Busca todos los pacientes que coincidan con
     * el apellido o la cedula
     * @param string $texto cedula o apellidos del paciente
     */
    public function searchByIdentificationOrLastname($query)
    {
        if($query===""){
            return Patient::take(10);
        }else{
            return Patient::where('identification_number', '=', $query)
            ->orWhere('fullname', 'LIKE','%'.$query.'%')
            ->get();
        }
    }
}
