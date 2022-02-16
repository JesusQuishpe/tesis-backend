<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoproparasitarioRequest;
use App\Models\Coproparasitario;
use App\Models\Doctor;
use App\Models\Pendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoproparasitarioController extends Controller
{
    //
    public function index(Request $request)
    {
        //Buscar paciente por cedula o nombre completo
        if ($request->has('query')) {
            $model = new Coproparasitario();
            $texto = $request->query('query', '');
            $datos = $model->buscar($texto);
            return response()->json($datos);
        }
        return response()->json(Coproparasitario::all());
    }

    public function show($coproparasitario)
    {
        $result = Coproparasitario::findOrFail($coproparasitario);
        return $this->sendResponse($result, '');
    }

    public function store(CoproparasitarioRequest $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $validated['atendido'] = true;
            $model = Coproparasitario::create($validated);
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

    public function update(CoproparasitarioRequest $request, Coproparasitario $coproparasitario)
    {
        $coproparasitario->update($request->validated());
        return $this->sendResponse($coproparasitario, 'Registro actualizado');
    }

    public function destroy(Coproparasitario $coproparasitario)
    {
        $coproparasitario->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }

}
