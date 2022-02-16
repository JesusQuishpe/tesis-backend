<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hematologia;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HematologiaController extends Controller
{
    //
    public function index()
    {
        
    }

    public function validateExamenHematologia(Request $request)
    {
        return Validator::make($request->all(), [
            'id_cita' => 'required|numeric',
            'id_doc' => 'required|numeric',
            'id_tipo' => 'required|numeric',
            'sedimento' => 'required|numeric',
            'hematocrito' => 'required|numeric',
            'hemoglobina' => 'required|numeric',
            'hematies' => 'required|numeric',
            'leucocitos' => 'required|numeric',
            'segmentados' => 'required|numeric',
            'linfocitos' => 'required|numeric',
            'eosinofilos' => 'required|numeric',
            'monocitos' => 'required|numeric',
            't_coagulacion' => 'required|max:45',
            't_sangria' => 'required|max:45',
            't_plaquetas' => 'required|max:45',
            't_protombina_tp' => 'required|max:45',
            't_parcial_de_tromboplastine' => 'required|max:45',
            'fibrinogeno' => 'required|max:45',
            'observaciones' => 'required|max:200'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validateExamenHematologia($request);
            DB::beginTransaction();
            if (count($validator->errors()) > 0) {
                return $this->sendError('Errores', $validator->errors());
            }
            $validated = $validator->validated();
            $validated['atendido'] = true;
            $model = Hematologia::create($validated);
            $pendiente = Pendiente::find($request->input('id_pendiente'));
            $pendiente->pendiente = false;
            $pendiente->save();
            DB::commit();
            return $this->sendResponse($model, 'Registro guardado');
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                return $this->sendError($th->getMessage());
            }
            return $this->sendError($th->getMessage());
        }
    }

    public function update(Request $request, Hematologia $hematologia)
    {
        $validator = $this->validateExamenHematologia($request);
        if (count($validator->errors()) > 0) {
            return $this->sendError('Error en la petición', $validator->errors());
        }
        $hematologia->update($validator->validated());
        return $this->sendResponse($hematologia, 'Registro actualizado');
    }
}
