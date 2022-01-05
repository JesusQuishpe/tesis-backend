<?php

namespace App\Http\Controllers;

use App\Models\AntecedentesOpcionesModel;
use App\Models\FichaModel;
use App\Models\OdontogramaLayout;
use App\Models\OdontologiaModel;
use App\Models\PatologiaModel;
use Exception;
use Illuminate\Http\Request;

class OdontologiaController extends Controller
{

    public function index()
    {
        $model = new OdontologiaModel();
        $pacientes = $model->getPacientesEnEspera();
        return view('odontologia/index',['pacientes'=>$pacientes]);
    }   

    public function pacientes()
    {
        try {
            $model = new OdontologiaModel();
            $pacientes = $model->getPacientesEnEspera();
            if (!empty($pacientes)) {
                $response = [
                    'err' => false,
                    'result' => $pacientes
                ];
                echo json_encode($response);
            } else {
                $response = [
                    'err' => true,
                    'result' => null
                ];
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = [
                'err' => true,
                'result' => null
            ];
            error_log($e);
            echo json_encode($response);
        }
    }
    public function historiales()
    {
        try {
            $model = new OdontologiaModel();
            $pacientes = $model->getAll();
            if (!empty($pacientes)) {
                $response = [
                    'err' => false,
                    'result' => $pacientes
                ];
                echo json_encode($response);
            } else {
                $response = [
                    'err' => true,
                    'result' => null
                ];
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = [
                'err' => true,
                'result' => null
            ];
            error_log($e);
            echo json_encode($response);
        }
    }

    public function paciente($opcion = '')
    {
        try {
            $model = new OdontologiaModel();
            $datos = $model->getPorCedulaOApellidos($opcion);
            if (!empty($datos)) {
                $response = [
                    'err' => false,
                    'result' => $datos
                ];
                echo json_encode($response);
            } else {
                $response = [
                    'err' => true,
                    'result' => null
                ];
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response = [
                'err' => true,
                'result' => null
            ];
            error_log($e);
            echo json_encode($response);
        }
    }

    public function historialShow($idOdo)
    {
        $model = new FichaModel();
        $data = $model->getFichaPaciente($idOdo);
        $antecedenteOpcionesModel = new AntecedentesOpcionesModel();
        $antecedentes = $antecedenteOpcionesModel->getAll();
        $patologiaModel = new PatologiaModel();
        $patologias = $patologiaModel->getAll();
        //$odoLayout=new OdontogramaLayout($data['odontograma']);
        return view('odontologia/historialReporte', [
            'idOdo' => $idOdo,
            'data' => $data,
            'patologias' => $patologias,
            'antecedentes' => $antecedentes
        ]);
    }

    public function historial($idOdo)
    {
        //Obtener la informacion del paciente 
        $model = new FichaModel();
        $ficha = $model->getFichaPaciente($idOdo);
        return response()->json($ficha);
    }

    public function delete($idOdo)
    {
        try {
            $model = new OdontologiaModel();
            $model->delete($idOdo);
            return redirect('/odontologia');
        } catch (\Throwable $th) {
            
        }
    }
}
