<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pendiente extends Model
{
    use HasFactory;
    protected $table='pendientes';
    protected $fillable=[
        'id_cita',
        'id_tipo',
        'tablename_tipo',
        'atendido'
    ];

    public function getPendientes($id_cita)
    {
        return DB::table('pendientes')
        ->join('tipo_examen','id_tipo','tipo_examen.id')
        ->join('citas','id_cita','citas.id')
        ->select([
            'pendientes.id as id_pendiente',
            'pendientes.id_cita',
            'pendientes.tablename_tipo',
            'pendientes.id_tipo',
            'tipo_examen.nombre as examen',
            'pendientes.pendiente',
        ])
        ->where('pendientes.id_cita','=',$id_cita)
        ->get();
    }
   
}
