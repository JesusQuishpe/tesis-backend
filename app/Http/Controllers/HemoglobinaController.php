<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hemoglobina;
use Illuminate\Http\Request;

class HemoglobinaController extends Controller
{
    //
    public function index()
    {
        return view('laboratorio.index');
    }

    public function nuevo(Request $request)
    {
        $model=new Hemoglobina();
        $doctores=Doctor::all();
        if($request->has('texto')){
            $texto=$request->query('texto');
            $ultimaCita=$model->ultimaCita($texto);
            return view('laboratorio.hemoglobina.nuevo',compact('doctores','ultimaCita','texto'));
        }
        
        return view('laboratorio.hemoglobina.nuevo',compact('doctores'));
    }

    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'id_cita'=>'required|numeric',
            'id_doc'=>'required|numeric',
            'id_tipo'=>'required|numeric',
            'resultado'=>'required|numeric',
            'observaciones'=>'required|max:200'
        ]);
    }

    public function guardar(Request $request)
    {
        $this->validateRequest($request);
        $model = Hemoglobina::create($request->except(['_token']));
        $model->save();
        return redirect()->route('hemoglobina.nuevo');
    }

    public function update(Request $request, $id_hemoglobina)
    {
        $this->validateRequest($request);
        $hemoglobina = Hemoglobina::find($id_hemoglobina);
        $hemoglobina->update($request->except(['_token', '_method']));
        return redirect()->route('hemoglobina.editar');
    }


    public function editar(Request $request)
    {
        $model=new Hemoglobina();
        $texto=$request->query('texto','');
        $datos=$model->buscar($texto);
        return view('laboratorio.hemoglobina.editar',compact('texto','datos'));
    }
    public function edit($id_hemoglobina)
    {
        $hemoglobina = Hemoglobina::find($id_hemoglobina);
        if ($hemoglobina == null)
            return abort(404);
        $doctores = Doctor::all();
        return view('laboratorio.hemoglobina.edit', ['hemoglobina' => $hemoglobina, 'doctores' => $doctores]);
    }

    public function delete($id_hemoglobina)
    {
        $hemoglobina = Hemoglobina::find($id_hemoglobina);
        if ($hemoglobina == null)
            return abort(404);
        $hemoglobina->delete();
        return redirect()->route('hemoglobina.editar');
    }

    public function todos()
    {
        return view('laboratorio.hemoglobina.eliminar');
    }
}
