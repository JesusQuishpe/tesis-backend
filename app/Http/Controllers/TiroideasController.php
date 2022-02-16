<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Pendiente;
use App\Models\Tiroideas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TiroideasController extends Controller
{
    //
    public function index()
    {
        
    }

    public function validateExamenTiroideas(Request $request)
    {
        return Validator::make($request->all(), [
            'id_cita' => 'required|numeric',
            'id_doc' => 'required|numeric',
            'id_tipo' => 'required|numeric',
            't3' => 'required|numeric',
            't4' => 'required|numeric',
            'tsh' => 'required|numeric',
            'observaciones' => 'required|max:200'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validateExamenTiroideas($request);
            DB::beginTransaction();
            if (count($validator->errors()) > 0) {
                return $this->sendError('Errores', $validator->errors());
            }
            $validated = $validator->validated();
            $validated['atendido'] = true;
            $model = Tiroideas::create($validated);
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

    public function update(Request $request, Tiroideas $tiroidea)
    {
        $validator = $this->validateExamenTiroideas($request);
        if (count($validator->errors()) > 0) {
            return $this->sendError('Error en la petición', $validator->errors());
        }
        $tiroidea->update($validator->validated());
        return $this->sendResponse($tiroidea, 'Registro actualizado');
    }
}
