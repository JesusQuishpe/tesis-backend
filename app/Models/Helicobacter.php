<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Helicobacter extends Model
{
    use HasFactory;
    protected $table = 'helicobacter_pylori';

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
        return DB::table('helicobacter_pylori')
            ->join('citas', 'helicobacter_pylori.id_cita', '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->join('doctores', 'helicobacter_pylori.id_doc', '=', 'doctores.id')
            ->select(
                'helicobacter_pylori.id',
                'pacientes.nombres',
                'pacientes.apellidos',
                'citas.fecha_cita',
                'doctores.nombres',
                'helicobacter_pylori.updated_at',
                'helicobacter_pylori.observaciones'
            )
            ->where('pacientes.cedula', '=', $texto)
            ->orWhere('pacientes.nombres', 'LIKE', '%' . $texto . '%')
            ->orWhere('pacientes.apellidos', 'LIKE', '%' . $texto . '%')
            ->paginate(1);
    }
}
