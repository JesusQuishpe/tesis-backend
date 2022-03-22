<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbGrupo extends Model
{
    use HasFactory;
    protected $table='lb_grupos';

    public function area()
    {
        return $this->belongsTo(LbArea::class,'id_area','id');
    }
}