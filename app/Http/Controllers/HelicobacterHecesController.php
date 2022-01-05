<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\HelicobacterHeces;
use Illuminate\Http\Request;

class HelicobacterHecesController extends Controller
{
    //
    public function index()
    {
        return view('laboratorio.index');
    }

    public function nuevo(Request $request)
    {
        $model=new HelicobacterHeces();
        $doctores=Doctor::all();
        if($request->has('texto')){
            $texto=$request->query('texto');
            $ultimaCita=$model->ultimaCita($texto);
            return view('laboratorio.helicobacterHeces.nuevo',compact('doctores','ultimaCita','texto'));
        }
        
        return view('laboratorio.helicobacterHeces.nuevo',compact('doctores'));
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
        $model = HelicobacterHeces::create($request->except(['_token']));
        $model->save();
        return redirect()->route('helicobacterHeces.nuevo');
    }

    public function update(Request $request, $id_helicobacterHeces)
    {
        $this->validateRequest($request);
        $helicobacterHeces = HelicobacterHeces::find($id_helicobacterHeces);
        $helicobacterHeces->update($request->except(['_token', '_method']));
        return redirect()->route('helicobacterHeces.editar');
    }


    public function editar(Request $request)
    {
        $model=new HelicobacterHeces();
        $texto=$request->query('texto','');
        $datos=$model->buscar($texto);
        return view('laboratorio.helicobacterHeces.editar',compact('texto','datos'));
    }
    
    public function edit($id_helicobacterHeces)
    {
        $helicobacterHeces = HelicobacterHeces::find($id_helicobacterHeces);
        if ($helicobacterHeces == null)
            return abort(404);
        $doctores = Doctor::all();
        return view('laboratorio.helicobacterHeces.edit', ['helicobacterHeces' => $helicobacterHeces, 'doctores' => $doctores]);
    }

    public function delete($id_helicobacterHeces)
    {
        $helicobacterHeces = HelicobacterHeces::find($id_helicobacterHeces);
        if ($helicobacterHeces == null)
            return abort(404);
        $helicobacterHeces->delete();
        return redirect()->route('helicobacterHeces.editar');
    }

    public function todos()
    {
        return view('laboratorio.helicobacterHeces.eliminar');
    }
}
