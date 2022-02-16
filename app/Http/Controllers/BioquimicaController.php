<?php

namespace App\Http\Controllers;

use App\Http\Requests\BioquimicaRequest;
use App\Models\Bioquimica;
use App\Models\Doctor;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BioquimicaController extends Controller
{

    public function index(Request $request)
    {
        //Buscar paciente por cedula o nombre completo
        if ($request->has('query')) {
            $model = new Bioquimica();
            $texto = $request->query('query', '');
            $datos = $model->buscar($texto);
            return response()->json($datos);
        }
        return response()->json(Bioquimica::all());
    }

    public function store(BioquimicaRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $validated['atendido'] = true;
            $model = Bioquimica::create($validated);
            $pendiente=Pendiente::find($request->input('id_pendiente'));
            $pendiente->pendiente=false;
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

    public function update(BioquimicaRequest $request, Bioquimica $bioquimica)
    {
        $bioquimica->update($request->validated());
        return $this->sendResponse($bioquimica, 'Registro actualizado');
    }

    public function destroy(Bioquimica $bioquimica)
    {
        $bioquimica->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }


    public function ultimaCita(Request $request)
    {
        $request->validate([
            'cedula' => 'required'
        ]);
        $model = new Bioquimica();
        $datos = $model->ultimaCita($request->input('cedula'));
        return response()->json($datos);
    }
}
