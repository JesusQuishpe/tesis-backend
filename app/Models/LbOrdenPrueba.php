<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbOrdenPrueba extends Model
{
    use HasFactory;
    protected $table='lb_orden_pruebas';

    public function prueba()
    {
        return $this->belongsTo(LbPrueba::class,'id_prueba','id');
    }
}
