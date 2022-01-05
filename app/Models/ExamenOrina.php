<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExamenOrina extends Model
{
    use HasFactory;
    protected $table = 'examen_orina';

    protected $fillable = [
        'id_cita',
        'id_doc',
        'id_tipo',
        'color',
        'olor',
        'sedimento',
        'ph',
        'densidad',
        'leucocituria',
        'nitritos',
        'albumina',
        'glucosa',
        'cetonas',
        'urobilinogeno',
        'bilirrubina',
        'sangre_enteros',
        'sangre_lisados',
        'acido_ascorbico',
        'hematies',
        'leucocitos',
        'cel_epiteliales',
        'fil_mucosos',
        'bacterias',
        'bacilos',
        'cristales',
        'cilindros',
        'piocitos',
        'observaciones'

    ];


    public function cita()
    {
        return $this->hasOne(Cita::class, 'id', 'id_cita');
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'id', 'id_doc');
    }

    public static function ultimaCita($cedula)
    {
        return DB::selectOne(
            'select c.id as id_cita,p.cedula,p.nombres,p.apellidos,p.sexo,c.fecha_cita from 
        citas c inner join pacientes p
        on p.id=c.id_paciente
        where p.cedula=? and c.fecha_cita=(select max(fecha_cita) from citas inner join pacientes on pacientes.id=citas.id_paciente
        where pacientes.cedula=?)',
            [$cedula, $cedula]
        ) ?:0 ;
    }
    public function buscar($texto)
    {
        return DB::table('examen_orina')
            ->join('citas', 'examen_orina.id_cita', '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->join('doctores', 'examen_orina.id_doc', '=', 'doctores.id')
            ->select(
                'examen_orina.id',
                'pacientes.nombres',
                'pacientes.apellidos',
                'citas.fecha_cita',
                'doctores.nombres',
                'examen_orina.updated_at',
                'examen_orina.observaciones'
            )
            ->where('pacientes.cedula', '=', $texto)
            ->orWhere('pacientes.nombres', 'LIKE', '%' . $texto . '%')
            ->orWhere('pacientes.apellidos', 'LIKE', '%' . $texto . '%')
            ->paginate(1);
    }
}
