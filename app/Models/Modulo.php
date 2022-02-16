<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    protected $table='modulos';

    public function operaciones()
    {
        return $this->belongsToMany(Operacion::class,'modulo_operaciones','id_modulo','id_operacion');
    }

    public function submodulos()
    {
        return $this->hasMany(Modulo::class,'id_parent','id')->where('enable','=',true);
    }
}
