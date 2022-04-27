<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdoIndicatorDetail extends Model
{
    use HasFactory;
    protected $table = 'odo_indicator_details';
    protected $fillable = [
        'id_ind',
        'piece1',
        'piece2',
        'piece3',
        'plaque',
        'calc',
        'gin',
    ];
}
