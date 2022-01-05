<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Embarazo;
use Illuminate\Http\Request;

class EmbarazoController extends Controller
{
    //
    public function index()
    {
        return view('laboratorio.index');
    }

    public function nuevo(Request $request)
    {
        $model=new Embarazo();
        $doctores=Doctor::all();
        if($request->has('texto')){
            $texto=$request->query('texto');
            $ultimaCita=$model->ultimaCita($texto);
            return view('laboratorio.embarazo.nuevo',compact('doctores','ultimaCita','texto'));
        }
        
        return view('laboratorio.embarazo.nuevo',compact('doctores'));
    }

    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'id_cita'=>'required|numeric',
            'id_doc'=>'required|numeric',
            'id_tipo'=>'required|numeric',
            'resultado'=>'required|max:100',
            'observaciones'=>'required|max:200'
        ]);
    }

    public function guardar(Request $request)
    {
        $this->validateRequest($request);
        $model = Embarazo::create($request->except(['_token']));
        $model->save();
        return redirect()->route('embarazo.nuevo');
    }

    public function update(Request $request, $id_embarazo)
    {
        $this->validateRequest($request);
        $embarazo = Embarazo::find($id_embarazo);
        $embarazo->update($request->except(['_token', '_method']));
        return redirect()->route('embarazo.editar');
    }


    public function editar(Request $request)
    {
        $model=new Embarazo();
        $texto=$request->query('texto','');
        $datos=$model->buscar($texto);
        return view('laboratorio.embarazo.editar',compact('texto','datos'));
    }
    public function edit($id_embarazo)
    {
        $embarazo = Embarazo::find($id_embarazo);
        if ($embarazo == null)
            return abort(404);
        $doctores = Doctor::all();
        return view('laboratorio.embarazo.edit', ['embarazo' => $embarazo, 'doctores' => $doctores]);
    }

    public function delete($id_embarazo)
    {
        $embarazo = Embarazo::find($id_embarazo);
        if ($embarazo == null)
            return abort(404);
        $embarazo->delete();
        return redirect()->route('embarazo.editar');
    }

    public function todos()
    {
        return view('laboratorio.embarazo.eliminar');
    }
}
