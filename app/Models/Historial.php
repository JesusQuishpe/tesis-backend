<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Historial
{

    public function buildQueryTable($table, $texto)
    {
        return DB::table($table)
            ->join('tipo_examen', "$table.id_tipo", 'tipo_examen.id')
            ->join('citas', "$table.id_cita", '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->join('doctores', "$table.id_doc", '=', 'doctores.id')
            ->select([
                "$table.id",
                'citas.id as id_cita',
                'pacientes.nombre_completo',
                'tipo_examen.id as id_tipo',
                'tipo_examen.nombre AS examen',
                "$table.created_at AS fecha",
                'doctores.nombres AS doctor'
            ])
            ->where('pacientes.cedula', '=', $texto)
            ->where("$table.atendido", '=', true)
            ->where('citas.atendido', '=', true)
            ->get();
    }

    public function buildPendientesQuery($table, $texto)
    {
        return DB::table($table)
            ->join('tipo_examen', "$table.id_tipo", 'tipo_examen.id')
            ->join('citas', "$table.id_cita", '=', 'citas.id')
            ->join('pacientes', 'citas.id_paciente', '=', 'pacientes.id')
            ->select([
                "$table.id",
                DB::raw("CONCAT(pacientes.nombres,' ',pacientes.apellidos) AS paciente"),
                'citas.id as id_cita',
                'tipo_examen.id as id_tipo',
                'tipo_examen.nombre AS examen',
                'citas.fecha_cita as fecha',
                'citas.hora_cita as hora',
                'citas.area',
                "$table.atendido"
            ])
            ->where('pacientes.cedula', '=', $texto)
            ->where('citas.area', '=', 'Laboratorio')
            ->where("$table.atendido", '=', false);
    }


    public function getExamen($table, $cedula)
    {
        return $this->buildQueryTable($table, $cedula);
    }




    public function getExamenPorTipo($id_tipo, $id)
    {
        $id_tipo = intval($id_tipo);
        $id = intval($id);

        if ($id_tipo === 1) {
            return Bioquimica::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 2) {
            return Coprologia::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 3) {
            return Coproparasitario::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 4) {
            return ExamenOrina::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 5) {
            return HelicobacterHeces::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 6) {
            return Helicobacter::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 7) {
            return Hematologia::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 8) {
            return Hemoglobina::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 9) {
            return Embarazo::where('id_cita', '=', $id)->first();
        }
        if ($id_tipo === 10) {
            return Tiroideas::where('id_cita', '=', $id)->first();
        }
        return null;
    }

    public function getHistoriaPorTipo($id_tipo, $cedula)
    {
        $id_tipo = intval($id_tipo);

        if ($id_tipo === 1) {
            return Bioquimica::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "bioquimica.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "bioquimica.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 2) {
            return Coprologia::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "coprologia.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "coprologia.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 3) {
            return Coproparasitario::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "coproparasitario.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "coproparasitario.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 4) {
            return ExamenOrina::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "examen_orina.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "examen_orina.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 5) {
            return HelicobacterHeces::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "helicobacter_heces.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "helicobacter_heces.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 6) {
            return Helicobacter::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "helicobacter_pylori.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "helicobacter_pylori.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 7) {
            return Hematologia::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "hematologia.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "hematologia.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 8) {
            return Hemoglobina::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "hemoglobina_glicosilada.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "hemoglobina_glicosilada.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 9) {
            return Embarazo::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "embarazo.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "embarazo.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        if ($id_tipo === 10) {
            return Tiroideas::join('citas', 'id_cita', 'citas.id')
                ->join('doctores', 'id_doc', 'doctores.id')
                ->join('pacientes','citas.id_paciente','pacientes.id')
                ->join('tipo_examen','id_tipo','tipo_examen.id')
                ->select([
                    "tiroideas.id",
                    'citas.id as id_cita',
                    'pacientes.nombre_completo',
                    'tipo_examen.id as id_tipo',
                    'tipo_examen.nombre AS examen',
                    "tiroideas.created_at AS fecha",
                    'doctores.nombres AS doctor'
                ])
                ->where('citas.cedula_cita', '=', $cedula)
                ->where('eliminado','=',false)
                ->get();
        }
        return null;
    }



    public function obtenerPendientes($texto)
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

        $bioquimica = $this->buildPendientesQuery($tableNames[0], $texto);
        $coprologia = $this->buildPendientesQuery($tableNames[1], $texto);
        $coproparasitario = $this->buildPendientesQuery($tableNames[2], $texto);
        $examenOrina = $this->buildPendientesQuery($tableNames[3], $texto);
        $helicobacterPylori = $this->buildPendientesQuery($tableNames[4], $texto);
        $helicobacterHeces = $this->buildPendientesQuery($tableNames[5], $texto);
        $hematologia = $this->buildPendientesQuery($tableNames[6], $texto);
        $hemoglobina = $this->buildPendientesQuery($tableNames[7], $texto);
        $embarazo = $this->buildPendientesQuery($tableNames[8], $texto);
        $tiroideas = $this->buildPendientesQuery($tableNames[9], $texto);
        return $tiroideas->union($bioquimica)
            ->union($coprologia)
            ->union($coproparasitario)
            ->union($examenOrina)
            ->union($helicobacterPylori)
            ->union($helicobacterHeces)
            ->union($hematologia)
            ->union($hemoglobina)
            ->union($embarazo)
            ->paginate(3)->appends('cedula', $texto);
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

        $bioquimica = $this->buildQueryTable($tableNames[0], $texto);
        $coprologia = $this->buildQueryTable($tableNames[1], $texto);
        $coproparasitario = $this->buildQueryTable($tableNames[2], $texto);
        $examenOrina = $this->buildQueryTable($tableNames[3], $texto);
        $helicobacterPylori = $this->buildQueryTable($tableNames[4], $texto);
        $helicobacterHeces = $this->buildQueryTable($tableNames[5], $texto);
        $hematologia = $this->buildQueryTable($tableNames[6], $texto);
        $hemoglobina = $this->buildQueryTable($tableNames[7], $texto);
        $embarazo = $this->buildQueryTable($tableNames[8], $texto);
        $tiroideas = $this->buildQueryTable($tableNames[9], $texto);
        return $tiroideas->union($bioquimica)
            ->union($coprologia)
            ->union($coproparasitario)
            ->union($examenOrina)
            ->union($helicobacterPylori)
            ->union($helicobacterHeces)
            ->union($hematologia)
            ->union($hemoglobina)
            ->union($embarazo)
            ->paginate(10)->appends('texto', $texto);
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
