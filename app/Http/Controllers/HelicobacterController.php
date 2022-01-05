<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Helicobacter;
use Illuminate\Http\Request;

class HelicobacterController extends Controller
{
    //
    public function index()
    {
        return view('laboratorio.index');
    }

    public function nuevo(Request $request)
    {
        $model=new Helicobacter();
        $doctores=Doctor::all();
        if($request->has('texto')){
            $texto=$request->query('texto');
            $ultimaCita=$model->ultimaCita($texto);
            return view('laboratorio.helicobacter.nuevo',compact('doctores','ultimaCita','texto'));
        }
        
        return view('laboratorio.helicobacter.nuevo',compact('doctores'));
    }

    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'id_cita'=>'required|numeric',
            'id_doc'=>'required|numeric',
            'id_tipo'=>'required|numeric',
            'resultado'=>'required|max:45',
            'observaciones'=>'required|max:200'
        ]);
    }

    public function guardar(Request $request)
    {
        $this->validateRequest($request);
        $model = Helicobacter::create($request->except(['_token']));
        $model->save();
        return redirect()->route('helicobacter.nuevo');
    }

    public function update(Request $request, $id_helicobacter)
    {
        $this->validateRequest($request);
        $helicobacter = Helicobacter::find($id_helicobacter);
        $helicobacter->update($request->except(['_token', '_method']));
        return redirect()->route('helicobacter.editar');
    }


    public function editar(Request $request)
    {
        $model=new Helicobacter();
        $texto=$request->query('texto','');
        $datos=$model->buscar($texto);
        return view('laboratorio.helicobacter.editar',compact('texto','datos'));
    }
    public function edit($id_helicobacter)
    {
        $helicobacter = Helicobacter::find($id_helicobacter);
        if ($helicobacter == null)
            return abort(404);
        $doctores = Doctor::all();
        return view('laboratorio.helicobacter.edit', ['helicobacter' => $helicobacter, 'doctores' => $doctores]);
    }

    public function delete($id_helicobacter)
    {
        $helicobacter = Helicobacter::find($id_helicobacter);
        if ($helicobacter == null)
            return abort(404);
        $helicobacter->delete();
        return redirect()->route('helicobacter.editar');
    }

    public function todos()
    {
        return view('laboratorio.helicobacter.eliminar');
    }
}
