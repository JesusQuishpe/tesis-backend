<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table='roles';
    
    public function permisos()
    {
        return $this->belongsToMany(Modulo::class,'rol_modulos','id_rol','id_modulo');
    }
}
