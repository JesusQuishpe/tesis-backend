<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HelicobacterHeces extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'helicobacter_heces';

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
        return DB::table('helicobacter_heces')
            ->join('citas', 'helicobacter_heces.id_cita', '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->join('doctores', 'helicobacter_heces.id_doc', '=', 'doctores.id')
            ->select(
                'helicobacter_heces.id',
                'pacientes.nombres',
                'pacientes.apellidos',
                'citas.fecha_cita',
                'doctores.nombres',
                'helicobacter_heces.updated_at',
                'helicobacter_heces.observaciones'
            )
            ->where('pacientes.cedula', '=', $texto)
            ->orWhere('pacientes.nombres', 'LIKE', '%' . $texto . '%')
            ->orWhere('pacientes.apellidos', 'LIKE', '%' . $texto . '%')
            ->paginate(1);
    }
}
