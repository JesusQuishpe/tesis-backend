<?php

namespace App\Http\Controllers;

use App\Http\Requests\BioquimicaRequest;
use App\Models\Bioquimica;
use App\Models\Doctor;
use Illuminate\Http\Request;
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
        $model = Bioquimica::create($request->except(['_token']));
        return $this->sendResponse($model,'Registro guardado');
    }

    public function update(BioquimicaRequest $request, Bioquimica $bioquimica)
    {
        $bioquimica->update($request->except('_token', '_method'));
        return $this->sendResponse($bioquimica,'Registro actualizado');
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
