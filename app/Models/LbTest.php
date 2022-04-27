<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LbTest extends Model
{
    use HasFactory;
    protected $table='lb_tests';

    public function group()
    {
        return $this->belongsTo(LbGroup::class,'group_id','id');
    }
    public function measurement()
    {
        return $this->belongsTo(LbMeasurement::class,'measure_id','id');
    }
}
