<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoproparasitarioRequest;
use App\Models\Coproparasitario;
use App\Models\Doctor;
use Illuminate\Http\Request;

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
        $model = Coproparasitario::create($request->except(['_token']));
        return $this->sendResponse($model, 'Registro guardado');
    }

    public function update(CoproparasitarioRequest $request, Coproparasitario $coproparasitario)
    {
        $coproparasitario->update($request->except('_token', '_method'));
        return $this->sendResponse($coproparasitario, 'Registro actualizado');
    }

    public function destroy(Coproparasitario $coproparasitario)
    {
        $coproparasitario->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }

}
