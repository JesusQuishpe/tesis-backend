<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;
    
    protected $table='lb_examenes';

    public function estudios()
    {
      return $this->belongsToMany(Estudio::class,'lb_examenes_estudios','id_examen','id_estudio');
    }
}
