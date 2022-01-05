<?php

namespace App\Http\Controllers;

use App\Http\Requests\CajaRequest;
use App\Models\Cita;
use App\Models\Enfermeria;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    
    public function buscar($cedula)
    {
        try {
            $model = new Paciente();
            $res = [
                'err' => false,
                'result' => $model->buscarPorCedula($cedula)
            ];
            return response()->json($res);
        } catch (\Throwable $th) {
            $res = [
                'err' => true,
                'result' => null
            ];
            return response()->json($res);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CajaRequest $request)
    {

        try {
            DB::beginTransaction();
            $paraEnfermeria = ['Medicina', 'Odontologia'];
            $pac = Paciente::where('cedula', '=', $request->cedula)->first();
            $fecha = Carbon::now()->format('Y-m-d');
            $hora = Carbon::now()->format('H:i:s');

            if (!$pac) { //Si no está registrado
                $data = $request->only(
                    [
                        'cedula', 'apellidos', 'nombres',
                        'fecha_nacimiento', 'sexo', 'telefono',
                        'domicilio', 'provincia',
                        'ciudad'
                    ]
                );
                $data['fecha']=$fecha;
                $data['nombre_completo']=$data['nombres'].' '.$data['apellidos'];
                $pac = Paciente::create($data);
                $pac->save();
            }

            $cita = Cita::create([
                'fecha_cita' => $fecha,
                'hora_cita' => $hora,
                'cedula_cita' => $request->cedula,
                'area' => $request->area,
                'valor' => $request->valor,
                'factura_cita' => null,
                'estado_cita' => '',
                'id_paciente' => $pac->id,
                'estadisticas' => ''
            ]);

            if (in_array($request->input('area'), $paraEnfermeria)) {
                $enfermeria = new Enfermeria();
                $enfermeria->id_cita = $cita->id;
                $enfermeria->save();
            }

            DB::commit();
            return $this->sendResponse([
                'cita'=>$cita,
                'paciente'=>$pac
            ],'Cita agregada');
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                return $this->sendError('Error en agregar cita',[]);
            }
            return $this->sendError($th->getMessage(),[]);
        }
    }

    public function pacientes(Request $request)
    {
        $request->validate([
            'query' => 'required'
        ]);

        try {
            $query = $request->input('query');

            $model = new Paciente();
            $pacientes = $model->buscar($query);
            $res = [
                'err' => false,
                'result' => $pacientes
            ];
            return response()->json($res);
        } catch (\Throwable $th) {
            $res = [
                'err' => true,
                'result' => null,
                'errorMessage' => $th->getMessage()
            ];
            return response()->json($res);
        }
    }
}
