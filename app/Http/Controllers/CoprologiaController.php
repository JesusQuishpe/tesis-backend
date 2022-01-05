<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoprologiaRequest;
use App\Models\Coprologia;
use App\Models\Doctor;
use Illuminate\Http\Request;

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
        $model = Coprologia::create($request->except(['_token']));
        return $this->sendResponse($model, 'Registro guardado');
    }

    public function update(CoprologiaRequest $request, Coprologia $coprologia)
    {
        $coprologia->update($request->except('_token', '_method'));
        return $this->sendResponse($coprologia, 'Registro actualizado');
    }

    public function destroy(Coprologia $coprologia)
    {
        $coprologia->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
