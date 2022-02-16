<?php

namespace App\Http\Controllers;

use App\Models\Bioquimica;
use App\Models\BioquimicaModel;
use App\Models\Cita;
use App\Models\Enfermeria;
use App\Models\Historial;
use App\Models\Paciente;
use App\Models\Pendiente;
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
        $model = new Historial();
        $pendientes = $model->obtenerPendientes($cedula);
        return $this->sendResponse($pendientes, 'Pendientes');
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
            $examen->eliminado=true;
            $examen->save();
            return $this->sendResponse([],'Historia clinica eliminada');
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage());
        }

    }
    public function getHistoriaClinica(Request $request)
    {
        $id_tipo=$request->input('id_tipo');
        $cedula=$request->input('cedula');
        $model=new Historial();
        $result=$model->getHistoriaPorTipo($id_tipo,$cedula);
        return $this->sendResponse($result,'Historia clinica');
    }
}
