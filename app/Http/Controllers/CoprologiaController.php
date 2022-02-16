<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoprologiaRequest;
use App\Models\Coprologia;
use App\Models\Doctor;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoprologiaController extends Controller
{
    //
    public function index(Request $request)
    {
        //Buscar paciente por cedula o nombre completo
        if ($request->has('query')) {
            $model = new Coprologia();
            $texto = $request->query('query', '');
            $datos = $model->buscar($texto);
            return response()->json($datos);
        }
        return response()->json(Coprologia::all());
    }

    public function show($coprologia)
    {
        $result = Coprologia::findOrFail($coprologia);
        return $this->sendResponse($result, '');
    }

    public function store(CoprologiaRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $validated['atendido'] = true;
            $model = Coprologia::create($validated);
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

    public function update(CoprologiaRequest $request, Coprologia $coprologia)
    {
        $coprologia->update($request->validated());
        return $this->sendResponse($coprologia, 'Registro actualizado');
    }

    public function destroy(Coprologia $coprologia)
    {
        $coprologia->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
