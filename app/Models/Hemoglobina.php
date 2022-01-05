<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hemoglobina extends Model
{
    use HasFactory;
    protected $table = 'hemoglobina_glicosilada';

    protected $fillable = [
        'id_cita',
        'id_doc',
        'id_tipo',
        'resultado',
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
        ) ?:0;
    }
    public function buscar($texto)
    {
        return DB::table('hemoglobina_glicosilada')
            ->join('citas', 'hemoglobina_glicosilada.id_cita', '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->join('doctores', 'hemoglobina_glicosilada.id_doc', '=', 'doctores.id')
            ->select(
                'hemoglobina_glicosilada.id',
                'pacientes.nombres',
                'pacientes.apellidos',
                'citas.fecha_cita',
                'doctores.nombres as doctor',
                'hemoglobina_glicosilada.updated_at',
                'hemoglobina_glicosilada.observaciones'
            )
            ->where('pacientes.cedula', '=', $texto)
            ->orWhere('pacientes.nombres', 'LIKE', '%' . $texto . '%')
            ->orWhere('pacientes.apellidos', 'LIKE', '%' . $texto . '%')
            ->paginate(10);
    }
}
