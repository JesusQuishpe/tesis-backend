<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CajaModel;
use App\Models\IngresarModel;
use Error;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function save(Request $request)
    {
        if($request->isJson()){
           
            $data=[
                'num'=>$request->input('num'),
                'cedula'=>$request->input('cedula'),
                'apellidos'=>$request->input('apellidos'),
                'nombres'=>$request->input('nombres'),
                'nacimiento'=>$request->input('nacimiento'),
                'sexo'=>$request->input('sexo'),
                'telefono'=>$request->input('telefono'),
                'domicilio'=>$request->input('domicilio'),
                'fecha'=>$request->input('fecha'),
                'hora'=>$request->input('hora'),
                'provincia'=>$request->input('provincia'),
                'ciudad'=>$request->input('ciudad'),
                'area'=>$request->input('area'),
                'valor'=>$request->input('valor')
            ];
            $model=new CajaModel();
            $model->from($data);
            $result=$model->save();
            if($result){
                echo json_encode(['res'=>true]);
            }else{
                echo json_encode(['res'=>false]);
            }
        }
        /*if($request->existJsonPost()){
            
            $json = $request->getJson();
            $data=[
                'num'=>$json['num'],
                'cedula'=>$json['cedula'],
                'apellidos'=>$json['apellidos'],
                'nombres'=>$json['nombres'],
                'nacimiento'=>$json['nacimiento'],
                'sexo'=>$json['sexo'],
                'telefono'=>$json['telefono'],
                'domicilio'=>$json['domicilio'],
                'fecha'=>$json['fecha'],
                'hora'=>$json['hora'],
                'provincia'=>$json['provincia'],
                'ciudad'=>$json['ciudad'],
                'area'=>$json['area'],
                'valor'=>$json['valor']
            ];
            $model=new CajaModel();
            $model->from($data);
            $result=$model->save();
            if($result){
                echo json_encode(['res'=>true]);
            }else{
                echo json_encode(['res'=>false]);
            }
        }*/
    }
    public function buscar(Request $request)
    {
        
        if($request->has('cedula')){
            $cedula=$request->input('cedula');
            $model=new IngresarModel();
            $paciente=$model->buscar($cedula);
            if($paciente){
                $response=[
                    'err'=>false,
                    'result'=>$paciente
                ];
                echo json_encode($response);
            }else{
                $response=[
                    'err'=>true,
                    'result'=>null
                ];
                echo json_encode($response);
            }
        }else{
            error_log("NO  EXISTE POST line 65 caja.php:");
        }
    }
    public function pacientes(Request $request)
    {
    
        if($request->has('opcion')){
            $opcion=$request->input('opcion');
            $model=new IngresarModel();
            $paciente=$model->buscarPorCedulaOApellido($opcion);
            if($paciente){
                $response=[
                    'err'=>false,
                    'result'=>$paciente
                ];
                echo json_encode($response);
            }else{
                $response=[
                    'err'=>true,
                    'result'=>null
                ];
                echo json_encode($response);
            }
        }else{
            error_log("NO  EXISTE POST opcion linea 87 caja.php");
        }
    }
}

