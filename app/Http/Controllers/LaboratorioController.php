<?php

namespace App\Http\Controllers;

use App\Models\Bioquimica;
use App\Models\BioquimicaModel;
use App\Models\CapturaResultado;
use App\Models\Cita;
use App\Models\Enfermeria;
use App\Models\EstudioDetTemp;
use App\Models\EstudioSel;
use App\Models\EstudioSelDet;
use App\Models\EstudioTemp;
use App\Models\Examen;
use App\Models\ExamenSel;
use App\Models\ExamenTemp;
use App\Models\Historial;
use App\Models\Paciente;
use App\Models\Pendiente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LaboratorioController extends Controller
{
    //
    /*public function index(Request $request)
    {
        $cedula=$request->input('cedula');
        $paciente=Paciente::where('cedula','=',$cedula)->first();
        $model=new Historial();
        $pendientes=$model->obtenerPendientes($cedula);
        $examen=$model->getExamen('bioquimica',$cedula);
        $response=[
            'paciente'=>$paciente,
            'pendientes'=>$pendientes,
            'examen'=>$examen
        ];
        return $this->sendResponse($response,'Laboratorio');
    }*/

    /**
     * Devuelve la cita actual del paciente para el area de laboratorio
     */
    public function getCitaPorCedula(Request $request, $cedula)
    {

        $cita = Cita::join('pacientes', 'citas.id_paciente', 'pacientes.id')
            ->select([
                'citas.id as id_cita',
                'pacientes.*'
            ])
            ->where('pacientes.cedula', '=', $cedula)
            ->where('citas.fecha_cita', '=', Carbon::now()->format('Y-m-d'))
            ->where('citas.area', '=', 'Laboratorio')
            ->where('citas.atendido', '=', false)
            ->firstOrFail();
        return $this->sendResponse($cita, 'Cita de laboratorio');
    }


    public function examen(Request $request)
    {
        $cedula = $request->input('cedula');
        $table = $request->input('table');
        $model = new Historial();
        $result = $model->getExamen($table, $cedula);
        return $this->sendResponse($result, 'examenes');
    }

    public function examenPorTipo(Request $request)
    {
        $id = $request->query('id');
        $id_tipo = $request->query('id_tipo');
        $model = new Historial();
        $result = $model->getExamenPorTipo($id_tipo, $id);
        return $this->sendResponse($result, 'Examen');
    }

    public function pendientes(Request $request)
    {
        $cedula = $request->input('cedula');
        $cita = Cita::join('pacientes', 'id_paciente', 'pacientes.id')
            ->select([
                'pacientes.id as id_paciente',
                'pacientes.nombre_completo as paciente',
                'pacientes.fecha_nacimiento',
                'pacientes.cedula',
                'pacientes.telefono',
                'pacientes.sexo',
                'citas.id as id_cita',
            ])
            ->where('cedula_cita', '=', $cedula)
            ->where('fecha_cita', '=', Carbon::now()->format('Y-m-d'))
            ->firstOrFail();

        $pendientes = ExamenSel::join('lb_examenes', 'id_examen', 'lb_examenes.id')
            ->where('id_cita', '=', $cita->id_cita)->get();

        /*$model = new Historial();
        $pendientes = $model->obtenerPendientes($cedula);*/
        return $this->sendResponse([
            'cita' => $cita,
            'pendientes' => $pendientes
        ], 'Examenes Pendientes');
    }

    public function getEstudiosPorExamen(Request $request)
    {
        $id_examen = $request->input('id_examen');
        $id_cita = $request->input('id_cita');

        $examenes = ExamenSel::join('lb_examenes', 'id_examen', 'lb_examenes.id')
            ->where('id_cita', '=', $id_cita)
            ->where('id_examen', '=', $id_examen)
            ->firstOrFail();

        $estudios = EstudioSel::join('lb_estudios', 'id_estudio', 'lb_estudios.id')
            ->where('id_examen', '=', $id_examen)
            ->get();
    }

    public function deleteExamenCita(Request $request)
    {
        $request->validate([
            'id_tipo' => 'required|numeric',
            'id' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();
            $model = new Historial();
            $examen = $model->getExamenPorTipo($request->input('id_tipo'), $request->input('id'));
            $id_cita = $examen->id_cita;
            $examen->delete();
            $cita = Cita::find($id_cita);
            $cita->delete();
            DB::commit();
            return $this->sendResponse([$request->input('id_tipo'), $request->input('id')], 'Registro eliminado');
        } catch (\Throwable $th) {
            //throw $th;
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                return $this->sendError($th->getMessage());
            }
            return $this->sendError($th->getMessage());
        }
    }

    public function eliminarCitaPendiente(Request $request, $id_cita)
    {
        try {
            DB::beginTransaction();
            $cita = Cita::find($id_cita);
            $model = new Historial();
            $pendientes = Pendiente::where('id_cita', '=', $id_cita);
            //Foreach para eliminar los resultados de los examenes
            foreach ($pendientes->get() as $pendiente) {
                $examen = $model->getExamenPorTipo($pendiente['id_tipo'], $id_cita);
                if ($examen) {
                    $examen->delete();
                }
            }
            //Eliminamos los examenes pendientes de la tabla Pendientes
            $pendientes->delete();
            //Eliminamos la cita
            $cita->delete();
            DB::commit();
            return $this->sendResponse([], 'Cita pendiente eliminada');
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                return $this->sendError($th->getMessage());
            }
            return $this->sendError($th->getMessage());
        }
    }

    public function eliminarHistoriaClinica(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'id_tipo' => 'required|numeric'
        ]);

        if (count($validator->errors()) > 0) {
            return $this->sendError('Error en la petición', $validator->errors());
        }

        try {
            $model = new Historial();
            $examen = $model->getExamenPorTipo($request->input('id_tipo'), $request->input('id'));
            $examen->eliminado = true;
            $examen->save();
            return $this->sendResponse([], 'Historia clinica eliminada');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }
    }
    public function getHistoriaClinica(Request $request)
    {
        $id_tipo = $request->input('id_tipo');
        $cedula = $request->input('cedula');
        $model = new Historial();
        $result = $model->getHistoriaPorTipo($id_tipo, $cedula);
        return $this->sendResponse($result, 'Historia clinica');
    }

    public function crearConsulta(Request $request)
    {
        $examenes = $request->input('examenesSeleccionados');

        $id_cita = $request->input('id_cita');

        $id_user=$request->input('id_user');

        $data = [];

        try {
            DB::beginTransaction();
            //Guardamos en la tabla captura resultados
            $captura=new CapturaResultado();
            $captura->id_user=$id_user;
            $captura->id_cita=$id_cita;
            $captura->fecha=Carbon::now()->format('Y-m-d');
            $captura->hora=Carbon::now()->format('H:i:s');
            $captura->numExamenes=count($examenes);
            $captura->save();
            //Guardamos en la tabla de examenes seleccionados
            foreach ($examenes as $examen) {
                array_push($data, $examen['id_examen']);
                $newExamen = new ExamenSel();
                $newExamen->id_captura=$captura->id;
                $newExamen->id_examen = $examen['id_examen'];
                $newExamen->numEstudios=count($examen['estudios']);
                $newExamen->save();
                foreach ($examen['estudios'] as $estudio) {
                    array_push($data, count($estudio['subestudios']));
                    if (count($estudio['subestudios']) === 0) { //Si no tiene subestudios
                        $newEstudio = new EstudioSel();
                        $newEstudio->id_examen = $examen['id_examen'];
                        $newEstudio->id_estudio = $estudio['id_estudio'];
                        $newEstudio->save();
                    } else {
                        foreach ($estudio['subestudios'] as $subestudio) {
                            $newSubEstudio = new EstudioSelDet();
                            $newSubEstudio->id_est_sel = $estudio['id_estudio'];
                            $newSubEstudio->id_subestudio = $subestudio;
                            $newSubEstudio->save();
                        }
                    }
                }
            }
            DB::commit();
            return $this->sendResponse($data, 'Consulta creada');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage(), 'Error');
        }
    }
}
