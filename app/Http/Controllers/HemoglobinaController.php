<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hemoglobina;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HemoglobinaController extends Controller
{
    //
    public function index()
    {
       
    }

    public function validateExamenHemoglobina(Request $request)
    {
        return Validator::make($request->all(), [
            'id_cita'=>'required|numeric',
            'id_doc'=>'required|numeric',
            'id_tipo'=>'required|numeric',
            'resultado'=>'required|numeric',
            'observaciones'=>'required|max:200'
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            $validator = $this->validateExamenHemoglobina($request);
            DB::beginTransaction();
            if (count($validator->errors()) > 0) {
                return $this->sendError('Errores', $validator->errors());
            }
            $validated = $validator->validated();
            $validated['atendido'] = true;
            $model = Hemoglobina::create($validated);
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

    public function update(Request $request, Hemoglobina $hemoglobina)
    {
        $validator = $this->validateExamenHemoglobina($request);
        if (count($validator->errors()) > 0) {
            return $this->sendError('Error en la petición', $validator->errors());
        }
        $hemoglobina->update($validator->validated());
        return $this->sendResponse($hemoglobina, 'Registro actualizado');
    }
}
