<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Embarazo;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmbarazoController extends Controller
{
    //
    public function index()
    {
        
    }

    public function validateExamenEmbarazo(Request $request)
    {
        return Validator::make($request->all(), [
            'id_cita'=>'required|numeric',
            'id_doc'=>'required|numeric',
            'id_tipo'=>'required|numeric',
            'resultado'=>'required|max:100',
            'observaciones'=>'required|max:200'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validateExamenEmbarazo($request);
            DB::beginTransaction();
            if (count($validator->errors()) > 0) {
                return $this->sendError('Errores', $validator->errors());
            }
            $validated = $validator->validated();
            $validated['atendido'] = true;
            $model = Embarazo::create($validated);
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

    public function update(Request $request, Embarazo $embarazo)
    {
        $validator = $this->validateExamenEmbarazo($request);
        if (count($validator->errors()) > 0) {
            return $this->sendError('Error en la petición', $validator->errors());
        }
        $embarazo->update($validator->validated());
        return $this->sendResponse($embarazo, 'Registro actualizado');
    }
}
