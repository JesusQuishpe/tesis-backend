<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Tiroideas;
use Illuminate\Http\Request;

class TiroideasController extends Controller
{
    //
    public function index()
    {
        return view('laboratorio.index');
    }

    public function nuevo(Request $request)
    {
        $model=new Tiroideas();
        $doctores=Doctor::all();
        if($request->has('texto')){
            $texto=$request->query('texto');
            $ultimaCita=$model->ultimaCita($texto);
            return view('laboratorio.tiroideas.nuevo',compact('doctores','ultimaCita','texto'));
        }
        
        return view('laboratorio.tiroideas.nuevo',compact('doctores'));
    }

    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'id_cita' => 'required|numeric',
            'id_doc' => 'required|numeric',
            'id_tipo' => 'required|numeric',
            't3' => 'required|numeric',
            't4' => 'required|numeric',
            'tsh' => 'required|numeric',
            'observaciones' => 'required|max:200'
        ]);
    }

    public function guardar(Request $request)
    {
        $this->validateRequest($request);
        $model = Tiroideas::create($request->except(['_token']));
        $model->save();
        return redirect()->route('tiroideas.nuevo');
    }

    public function update(Request $request, $id_tiroideas)
    {
        $this->validateRequest($request);
        $tiroideas = Tiroideas::find($id_tiroideas);
        $tiroideas->update($request->except(['_token', '_method']));
        return redirect()->route('tiroideas.editar');
    }


    public function editar(Request $request)
    {
        $model=new Tiroideas();
        $texto=$request->query('texto','');
        $datos=$model->buscar($texto);
        return view('laboratorio.tiroideas.editar',compact('texto','datos'));
    }
    public function edit($id_tiroideas)
    {
        $tiroideas = Tiroideas::find($id_tiroideas);
        if ($tiroideas == null)
            return abort(404);
        $doctores = Doctor::all();
        return view('laboratorio.tiroideas.edit', ['tiroideas' => $tiroideas, 'doctores' => $doctores]);
    }

    public function delete($id_tiroideas)
    {
        $tiroideas = Tiroideas::find($id_tiroideas);
        if ($tiroideas == null)
            return abort(404);
        $tiroideas->delete();
        return redirect()->route('tiroideas.editar');
    }

    public function todos()
    {
        return view('laboratorio.tiroideas.eliminar');
    }
}
