<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Historial
{

    public function buildQueryTable($table,$texto)
    {
        return DB::table($table)
        ->join('tipo_examen', "$table.id_tipo", 'tipo_examen.id')
        ->join('citas', "$table.id_cita", '=', 'citas.id')
        ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
        ->join('doctores', "$table.id_doc", '=', 'doctores.id')
        ->select([
            "$table.id",
            DB::raw("CONCAT(pacientes.nombres,' ',pacientes.apellidos) AS paciente"),
            'tipo_examen.id as id_tipo',
            'tipo_examen.nombre AS examen',
            "$table.created_at AS fecha",
            'doctores.nombres AS doctor'
        ])
        ->where('pacientes.cedula', '=', $texto)
        ->orWhere('pacientes.nombres', '=', $texto)
        ->orWhere('pacientes.apellidos', '=', $texto)
        ->orWhere('pacientes.nombre_completo', '=', $texto);
    }

    /**
     * @param {$texto} puede ser la cedula, nombres o apellidos del paciente
     * @return 
     */
    public function obtenerHistorial($texto)
    {
        $tableNames = [
            'bioquimica',
            'coprologia',
            'coproparasitario',
            'examen_orina',
            'helicobacter_pylori',
            'helicobacter_heces',
            'hematologia',
            'hemoglobina_glicosilada',
            'embarazo',
            'tiroideas'
        ];

        $bioquimica=$this->buildQueryTable($tableNames[0],$texto);
        $coprologia=$this->buildQueryTable($tableNames[1],$texto);
        $coproparasitario=$this->buildQueryTable($tableNames[2],$texto);
        $examenOrina=$this->buildQueryTable($tableNames[3],$texto);
        $helicobacterPylori=$this->buildQueryTable($tableNames[4],$texto);
        $helicobacterHeces=$this->buildQueryTable($tableNames[5],$texto);
        $hematologia=$this->buildQueryTable($tableNames[6],$texto);
        $hemoglobina=$this->buildQueryTable($tableNames[7],$texto);
        $embarazo=$this->buildQueryTable($tableNames[8],$texto);
        $tiroideas=$this->buildQueryTable($tableNames[9],$texto);
        return $tiroideas->union($bioquimica)
        ->union($coprologia)
        ->union($coproparasitario)
        ->union($examenOrina)
        ->union($helicobacterPylori)
        ->union($helicobacterHeces)
        ->union($hematologia)
        ->union($hemoglobina)
        ->union($embarazo)
        ->paginate(10)->appends('texto',$texto);
    }

    public function ver($examen, $id)
    {
        return DB::table($examen)
            ->join('tipo_examen', "$examen.id_tipo", 'tipo_examen.id')
            ->join('citas', "$examen.id_cita", '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->join('doctores', "$examen.id_doc", '=', 'doctores.id')
            ->select([
                "$examen.id",
                'pacientes.id as id_paciente',
                DB::raw("CONCAT(pacientes.nombres,' ',pacientes.apellidos) AS paciente"),
                'pacientes.sexo',

                'tipo_examen.nombre AS examen',
                "$examen.created_at AS fecha",
                'doctores.nombres AS doctor',
                "$examen.*"
            ])
            ->where("$examen.id", '=', $id)
            ->get();
    }
    public function verHistorial($idTipoExamen, $id)
    {
        if ($idTipoExamen === 1) return $this->ver('bioquimica', $id);

        if ($idTipoExamen === 2) return $this->ver('coprologia', $id);

        if ($idTipoExamen === 3) return $this->ver('coproparasitario', $id);

        if ($idTipoExamen === 4) return $this->ver('examen_orina', $id);

        if ($idTipoExamen === 5) return $this->ver('helicobacter_heces', $id);

        if ($idTipoExamen === 6) return $this->ver('helicobacter_pylori', $id);

        if ($idTipoExamen === 7) return $this->ver('hematologia', $id);

        if ($idTipoExamen === 8) return $this->ver('hemoglobina_glicosilada', $id);

        if ($idTipoExamen === 9) return $this->ver('embarazo', $id);

        if ($idTipoExamen === 10) return $this->ver('tiroideas', $id);

        return null;
    }
}
