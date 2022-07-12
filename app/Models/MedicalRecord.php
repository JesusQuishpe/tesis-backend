<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $table = 'medical_records';

    public function patient()
    {
        return $this->belongsTo(Patient::class,'patient_id','id');
    }

    public function antecedentes()
    {
        return $this->hasOne(MedFamilyHistory::class,'recordId','id');
    }
    public function exploracion()
    {
        return $this->hasOne(MedPhysicalExploration::class,'recordId','id');
    }
    public function interrogatorio()
    {
        return $this->hasOne(MedInterrogation::class,'recordId','id');
    }
    public function estiloDeVida()
    {
        return $this->hasOne(MedLifestyle::class,'recordId','id');
    }
    public function alergias()
    {
        return $this->hasOne(MedAllergie::class,'recordId','id');
    }


     /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //'password',
        'created_at',
        'updated_at'
    ];
}
