<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\LbCaptura;
use App\Models\LbCapturaPrueba;
use App\Models\LbCapturaResultado;
use App\Models\LbOrden;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LbCapturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('cedula')) {
            $model = new LbCaptura();
            $resultados = $model->resultadosPorCedula($request->input('cedula'));
            return $this->sendResponse($resultados, 'Resultados del paciente');
        }
        return $this->sendResponse(LbCaptura::all(), 'Resultados de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $fecha = Carbon::now()->format('Y-m-d');
            $hora = Carbon::now()->format('H:i:s');
            $idOrden = $request->input('id_orden');
            $newCaptura = new LbCaptura();
            $newCaptura->id_orden = $idOrden;
            $newCaptura->fecha = $fecha;
            $newCaptura->hora = $hora;
            $newCaptura->save();
            $tests = $request->input('tests');
            foreach ($tests as $test) {
                $newResultado = new LbCapturaResultado();
                $newResultado->id_captura = $newCaptura->id;
                $newResultado->id_prueba = $test['id'];
                if (array_key_exists('resultado', $test)) {
                    if ($test['esNumerico'] === 1) {
                        $newResultado->resultado_numerico = $test['resultado'];
                        $newResultado->resultado_string = null;
                    } else {
                        $newResultado->resultado_string = $test['resultado'];
                        $newResultado->resultado_numerico = null;
                    }
                } else {
                    $newResultado->resultado_string = null;
                    $newResultado->resultado_numerico = null;
                }
                if (array_key_exists('observaciones', $test)) {
                    $newResultado->observaciones = $test['observaciones'];
                } else {
                    $newResultado->observaciones = null;
                }
                $newResultado->save();
            }
            $orden = LbOrden::find($idOrden);
            $orden->pendiente = false;
            $orden->save();

            $cita = Cita::find($orden->id_cita);
            $cita->atendido = true;
            $cita->save();
            DB::commit();
            return $this->sendResponse([], 'Resultados guardados correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LbCaptura  $lbCaptura
     * @return \Illuminate\Http\Response
     */
    public function show(LbCaptura $lbCaptura)
    {
        $model = new LbCaptura();
        $resultados = $model->resultados($lbCaptura->id);
        return $this->sendResponse($resultados, 'Resultados');
        //$paciente=$lbCaptura->join('')
        //return $this->sendResponse($lbCaptura->with('orden','pruebas')->firstOrFail(),'Resultados');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbCaptura  $lbCaptura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbCaptura $lbCaptura)
    {
        try {
            DB::beginTransaction();
            $tests = $request->input('tests');
            foreach ($tests as $test) {
                $resultFinded = LbCapturaResultado::find($test['id_captura_resultado']);
                if (array_key_exists('resultado', $test)) {
                    if ($test['esNumerico'] === 1) {
                        $resultFinded->resultado_numerico = $test['resultado'];
                        $resultFinded->resultado_string = null;
                    } else {
                        $resultFinded->resultado_string = $test['resultado'];
                        $resultFinded->resultado_numerico = null;
                    }
                }
                if (array_key_exists('observaciones', $test)) {
                    $resultFinded->observaciones = $test['observaciones'];
                }
                $resultFinded->save();
            }
            DB::commit();
            return $this->sendResponse([], 'Resultados actualizados correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LbCaptura  $lbCaptura
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbCaptura $lbCaptura)
    {
        //
    }
}
