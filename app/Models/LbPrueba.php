<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbPrueba extends Model
{
    use HasFactory;
    protected $table='lb_pruebas';

    public function grupo()
    {
        return $this->belongsTo(LbGrupo::class,'id_grupo','id');
    }
    public function unidad()
    {
        return $this->belongsTo(LbUnidad::class,'id_unidad','id');
    }
}
