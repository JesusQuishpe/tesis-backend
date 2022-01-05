<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnfermeriaRequest;
use App\Models\Enfermeria;
use App\Models\EnfermeriaModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnfermeriaController extends Controller
{

    public function index(Request $request)
    {
        //Buscar paciente por cedula o nombre completo
        if ($request->has('query')) {
            $model = new Enfermeria();
            $texto = $request->query('query', '');
            $datos = $model->buscar($texto);
            return response()->json($datos);
        }
        return response()->json(Enfermeria::all());
    }

    public function show($enfermeria)
    {
        $result = Enfermeria::findOrFail($enfermeria);
        return $this->sendResponse($result, '');
    }

    public function store(EnfermeriaRequest $request)
    {

        //DB::beginTransaction();
        $dataToUpdate = $request->validated();
        unset($dataToUpdate['id_enfermeria']);//Eliminamos el id_enfermeria, porque no debe actualizarse
        $dataToUpdate['atendido'] = true;
        $id_enfermeria = $request->input('id_enfermeria');
        $result = Enfermeria::where('id', '=', $id_enfermeria);
        $result->update($dataToUpdate);
        return $this->sendResponse($result, 'Registro guardado');
    }

    public function update(EnfermeriaRequest $request, Enfermeria $enfermeria)
    {
        $enfermeria->update($request->except('_token', '_method'));
        return $this->sendResponse($enfermeria,'Registro actualizado');
    }

    public function pacientes()
    {
        $model = new Enfermeria();
        $datos = $model->enEspera();
        return response()->json($datos);
    }

    public function destroy(Enfermeria $enfermeria)
    {
        $enfermeria->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
