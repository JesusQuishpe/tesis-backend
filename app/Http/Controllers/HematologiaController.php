<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hematologia;
use Illuminate\Http\Request;

class HematologiaController extends Controller
{
    //
    public function index()
    {
        return view('laboratorio.index');
    }

    public function nuevo(Request $request)
    {
        $model=new Hematologia();
        $doctores=Doctor::all();
        if($request->has('texto')){
            $texto=$request->query('texto');
            $ultimaCita=$model->ultimaCita($texto);
            return view('laboratorio.hematologia.nuevo',compact('doctores','ultimaCita','texto'));
        }
        
        return view('laboratorio.hematologia.nuevo',compact('doctores'));
    }

    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'id_cita' => 'required|numeric',
            'id_doc' => 'required|numeric',
            'id_tipo' => 'required|numeric',
            'sedimento'=> 'required|numeric',
            'hematocrito'=> 'required|numeric',
            'hemoglobina'=> 'required|numeric',
            'hematies'=> 'required|numeric',
            'leucocitos'=> 'required|numeric',
            'segmentados'=> 'required|numeric',
            'linfocitos'=> 'required|numeric',
            'eosinofilos'=> 'required|numeric',
            'monocitos'=> 'required|numeric',
            't_coagulacion'=> 'required|max:45',
            't_sangria'=> 'required|max:45',
            't_plaquetas'=> 'required|max:45',
            't_protombina_tp'=> 'required|max:45',
            't_parcial_de_tromboplastine'=> 'required|max:45',
            'fibrinogeno'=> 'required|max:45',
            'observaciones'=> 'required|max:200'
        ]);
    }

    public function guardar(Request $request)
    {
        $this->validateRequest($request);
        $model = Hematologia::create($request->except(['_token']));
        $model->save();
        return redirect()->route('hematologia.nuevo');
    }

    public function update(Request $request, $id_hematologia)
    {
        $this->validateRequest($request);
        $hematologia = Hematologia::find($id_hematologia);
        $hematologia->update($request->except(['_token', '_method']));
        return redirect()->route('hematologia.editar');
    }


    public function editar(Request $request)
    {
        $model=new Hematologia();
        $texto=$request->query('texto','');
        $datos=$model->buscar($texto);
        return view('laboratorio.hematologia.editar',compact('texto','datos'));
    }
    public function edit($id_hematologia)
    {
        $hematologia = Hematologia::find($id_hematologia);
        if ($hematologia == null)
            return abort(404);
        $doctores = Doctor::all();
        return view('laboratorio.hematologia.edit', ['hematologia' => $hematologia, 'doctores' => $doctores]);
    }

    public function delete($id_hematologia)
    {
        $hematologia = Hematologia::find($id_hematologia);
        if ($hematologia == null)
            return abort(404);
        $hematologia->delete();
        return redirect()->route('hematologia.editar');
    }

    public function todos()
    {
        return view('laboratorio.hematologia.eliminar');
    }
}
