<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\HelicobacterHeces;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HelicobacterHecesController extends Controller
{
    //
    public function index()
    {
        
    }

    public function validateExamenHeces(Request $request)
    {
        return Validator::make($request->all(), [
            'id_cita'=>'required|numeric',
            'id_doc'=>'required|numeric',
            'id_tipo'=>'required|numeric',
            'resultado'=>'required|max:45',
            'observaciones'=>'required|max:200'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validateExamenHeces($request);
            if (count($validator->errors()) > 0) {
                return $this->sendError('Errores', $validator->errors());
            }
            DB::beginTransaction();
            $validated = $validator->validated();
            $validated['atendido'] = true;
            $model = HelicobacterHeces::create($validated);
            $pendiente = Pendiente::find($request->input('id_pendiente'));
            $pendiente->pendiente = false;
            $pendiente->save();
            DB::commit();
            return $this->sendResponse($model, 'Registro guardado');
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                return $this->sendError($th->getMessage(),$validated);
            }
            return $this->sendError($th->getMessage(),$validated);
        }
    }

    public function update(Request $request, HelicobacterHeces $hece)
    {
        $validator = $this->validateExamenHeces($request);
        if (count($validator->errors()) > 0) {
            return $this->sendError('Error en la petición', $validator->errors());
        }
        $hece->update($validator->validated());
        return $this->sendResponse($hece, 'Registro actualizado');
    }
}
