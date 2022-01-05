<?php

namespace App\Http\Controllers;


use App\Models\AntecedentesOpcionesModel;
use App\Models\CieModel;
use App\Models\DiagnosticosModel;
use App\Models\DientesModel;
use App\Models\FichaModel;
use App\Models\MovilidadRecesionModel;
use App\Models\OdontogramaModel;
use App\Models\PatologiaModel;
use App\Models\PlanOpcionesModel;
use App\Models\TratamientosModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichaController extends Controller
{
    public function ficha($idOdo)
    {
        //Obtener la informacion del paciente 
        $model = new FichaModel();
        if ($model->fueAtendidoOdontologia($idOdo)) {
            return abort(404);
        }
        $datos = $model->getDatosPacienteEnfermeria($idOdo);
        if (!$datos) {
            return abort(404);
        }
        $antecedenteOpcionesModel = new AntecedentesOpcionesModel();
        $antecedentes = $antecedenteOpcionesModel->getAll();
        $patologiaModel = new PatologiaModel();
        $patologias = $patologiaModel->getAll();
        $planModel = new PlanOpcionesModel();
        $planes = $planModel->getAll();

        return view('odontologia/ficha', [
            'idOdo' => $idOdo,
            'datos' => $datos,
            'antecedentes' => $antecedentes,
            'patologias' => $patologias,
            'planes' => $planes
        ]);
    }

    public function save(Request $request)
    {
        if ($request->has('json') && $request->hasFile('odontogramaImage')) {
            $data = json_decode($request->input('json'), true);
            $acta = $request->file('acta');
            $odontogramaImage = $request->file('odontogramaImage');

            DB::beginTransaction();
            try {
                $fichaModel = new FichaModel();
                //Guardar acta
                if($acta){
                    $path = $acta->store('actas');
                    if(!$path==false){
                        $data['odontologia']['acta_path'] = null;
                    }else{
                        $data['odontologia']['acta_path'] = $path;
                    }
                }else{
                    $data['odontologia']['acta_path'] = null;
                }
                
                
                
                //Guardar imagen del odontograma en el storage
                if($odontogramaImage){
                    $pathOdontograma = $odontogramaImage->store('odontogramas');
                    if ($pathOdontograma) {
                        $data['odontograma']['odontogramaImage'] = $pathOdontograma;
                    } else {
                        throw new Exception('Error: no se cargó la imagen del odontograma');
                    }
                }else{
                    throw new Exception('Error: la imagen del odontograma es null');
                }
                

                //Odontologia
                $fichaModel->getOdontologiaModel()->from($data['odontologia']);
                //Antecedentes
                $fichaModel->getAntecedenteModel()->setData($data['antecedentes']);
                //Examen del sistema estomatognatico
                $fichaModel->getExamenModel()->setData($data['examen']);
                //Indicadores
                $fichaModel->getIndicadoresModel()->from($data['indicadores']);
                //Indices
                $fichaModel->getIndicesModel()->from($data['indices']);
                //PlanDiagnostico
                $fichaModel->getPlanDiagnostico()->setData($data['planDiagnostico']);
                //Diagnosticos
                $diagnosticos = [];
                foreach ($data['diagnosticos'] as $value) {
                    $diag = new DiagnosticosModel();
                    $diag->from($value);
                    array_push($diagnosticos, $diag);
                }
                $fichaModel->setDiagnosticos($diagnosticos);
                //Tratamientos
                $tratamientos = [];
                foreach ($data['tratamientos'] as $value) {
                    $trat = new TratamientosModel();
                    $trat->from($value);
                    array_push($tratamientos, $trat);
                }
                $fichaModel->setTratamientos($tratamientos);
                //Odontograma
                $dientes = [];
                foreach ($data['odontograma']['dientes'] as $value) {
                    $diente = new DientesModel();
                    $diente->from($value);
                    array_push($dientes, $diente);
                }
                $fichaModel->getOdontogramaModel()->setDientes($dientes);
                $recmovs = [];
                foreach ($data['odontograma']['recmovs'] as $value) {
                    $recmov = new MovilidadRecesionModel();
                    $recmov->from($value);
                    array_push($recmovs, $recmov);
                }
                $fichaModel->getOdontogramaModel()->setMovilidadRecesiones($recmovs);
                $fichaModel->getOdontogramaModel()->setOdontogramaImage($data['odontograma']['odontogramaImage']);
                $fichaModel->save();
                DB::commit();
                return response()->json([
                    'mensajeCliente' => 'Ficha guardada correctamente',
                    'status' => 200,
                    'error' => false
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'mensajeCliente' => 'No se pudo guardar la ficha',
                    'mensajeError' => $th->getMessage(),
                    'status' => 500,
                    'error' => true
                ]);
            }
        }
    }

    /**
     * Devuelve todas las enfermedades CIE
     */
    public function cie()
    {
        $cie = new CieModel();
        return response()->json($cie->getAll());
    }

    public function lastOdontograma(Request $request)
    {
        if($request->has('cedula')){
            $cedula=$request->input('cedula');
            $model=new OdontogramaModel();
            $odontograma=$model->getUltimoOdontograma($cedula);
            return response()->json($odontograma);
        }
    }
}
