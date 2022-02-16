<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bioquimica extends Model
{
    use HasFactory;

    protected $table = 'bioquimica';
    protected $fillable = [
        'id_cita',
        'id_doc',
        'id_tipo',
        'glucosa',
        'urea',
        'creatinina',
        'acido_urico',
        'colesterol_total',
        'colesterol_hdl',
        'colesterol_ldl',
        'trigliceridos',
        'proteinas_totales',
        'albumina',
        'globulina',
        'relacion_ag',
        'bilirrubina_directa',
        'bilirrubina_indirecta',
        'bilirrubina_total',
        'gamma_gt',
        'calcio',
        'vdrl',
        'proteinas_c_react',
        'ra_test_latex',
        'asto',
        'salmonella_o',
        'salmonella_h',
        'paratifica_a',
        'paratifica_b',
        'proteus_0x19',
        'proteus_0x2',
        'proteus_0xk',
        'transaminasa_ox',
        'transaminasa_pir',
        'fosfatasa_alcalina_adultos',
        'fosfatasa_alcalina_ninos',
        'amilasa',
        'lipasa',
        'observaciones',
        'atendido'
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
        $dato=DB::selectOne(
            'select c.id as id_cita,p.cedula,p.nombres,p.apellidos,p.sexo,c.fecha_cita from 
        citas c inner join pacientes p
        on p.id=c.id_paciente
        where p.cedula=? and c.fecha_cita=(select max(fecha_cita) from citas inner join pacientes on pacientes.id=citas.id_paciente
        where pacientes.cedula=?)',
            [$cedula, $cedula]
        );

        return $dato ?:0;
    }
    public function buscar($texto)
    {
        return DB::table('bioquimica')
            ->join('citas', 'bioquimica.id_cita', '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->join('doctores', 'bioquimica.id_doc', '=', 'doctores.id')
            ->select('bioquimica.id','pacientes.nombres', 'pacientes.apellidos', 'citas.fecha_cita', 'doctores.nombres as doctor'
            , 'bioquimica.updated_at', 'bioquimica.observaciones')
            ->where('pacientes.cedula', '=', $texto)
            ->orWhere('pacientes.nombres', 'LIKE', '%' . $texto . '%')
            ->orWhere('pacientes.apellidos', 'LIKE', '%' . $texto . '%')
            ->paginate(10);
    }
}
