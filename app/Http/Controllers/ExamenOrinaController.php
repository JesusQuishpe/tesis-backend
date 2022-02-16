<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\ExamenOrina;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExamenOrinaController extends Controller
{
    //
    public function index()
    {
       
    }

    public function validateExamenOrina(Request $request)
    {
        return Validator::make($request->all(), [
            'id_cita' => 'required|numeric',
            'id_doc' => 'required|numeric',
            'id_tipo' => 'required|numeric',
            'color' => 'required|max:45',
            'olor' => 'required|max:45',
            'sedimento' => 'required|max:45',
            'ph' => 'required|numeric',
            'densidad' => 'required|numeric',
            'leucocituria' => 'required|max:45',
            'nitritos' => 'required|max:45',
            'albumina' => 'required|max:45',
            'glucosa' => 'required|max:45',
            'cetonas' => 'required|max:45',
            'urobilinogeno' => 'required|max:45',
            'bilirrubina' => 'required|max:45',
            'sangre_enteros' => 'required|max:45',
            'sangre_lisados' => 'required|max:45',
            'acido_ascorbico' => 'required|max:45',
            'hematies' => 'required|max:45',
            'leucocitos' => 'required|max:45',
            'cel_epiteliales' => 'required|max:45',
            'fil_mucosos' => 'required|max:45',
            'bacterias' => 'required|max:45',
            'bacilos' => 'required|max:45',
            'cristales' => 'required|max:45',
            'cilindros' => 'required|max:45',
            'piocitos' => 'required|max:45',
            'observaciones' => 'required|max:200'
        ]);
    }
    
    public function store(Request $request)
    {
        try {
            $validator = $this->validateExamenOrina($request);
            DB::beginTransaction();
            if (count($validator->errors()) > 0) {
                return $this->sendError('Errores', $validator->errors());
            }
            $validated = $validator->validated();
            $validated['atendido'] = true;
            $model = ExamenOrina::create($validated);
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

    public function update(Request $request, ExamenOrina $orina)
    {
        $validator = $this->validateExamenOrina($request);
        if (count($validator->errors()) > 0) {
            return $this->sendError('Error en la petición', $validator->errors());
        }
        $orina->update($validator->validated());
        return $this->sendResponse($orina, 'Registro actualizado');
    }
}
