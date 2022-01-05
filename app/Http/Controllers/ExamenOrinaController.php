<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\ExamenOrina;
use Illuminate\Http\Request;

class ExamenOrinaController extends Controller
{
    //
    public function index()
    {
        return view('laboratorio.index');
    }

    public function nuevo(Request $request)
    {
        $model=new ExamenOrina();
        $doctores=Doctor::all();
        if($request->has('texto')){
            $texto=$request->query('texto');
            $ultimaCita=$model->ultimaCita($texto);
            return view('laboratorio.orina.nuevo',compact('doctores','ultimaCita','texto'));
        }
        
        return view('laboratorio.orina.nuevo',compact('doctores'));
    }

    private function validateRequest(Request $request)
    {
        $validated = $request->validate([
            'id_cita' => 'required|numeric',
            'id_doc' => 'required|numeric',
            'id_tipo' => 'required|numeric',
            'color'=> 'required|max:45',
            'olor'=> 'required|max:45',
            'sedimento'=> 'required|max:45',
            'ph'=> 'required|numeric',
            'densidad'=> 'required|numeric',
            'leucocituria'=> 'required|max:45',
            'nitritos'=> 'required|max:45',
            'albumina'=> 'required|max:45',
            'glucosa'=> 'required|max:45',
            'cetonas'=> 'required|max:45',
            'urobilinogeno'=> 'required|max:45',
            'bilirrubina'=> 'required|max:45',
            'sangre_enteros'=> 'required|max:45',
            'sangre_lisados'=> 'required|max:45',
            'acido_ascorbico'=> 'required|max:45',
            'hematies'=> 'required|max:45',
            'leucocitos'=> 'required|max:45',
            'cel_epiteliales'=> 'required|max:45',
            'fil_mucosos'=> 'required|max:45',
            'bacterias'=> 'required|max:45',
            'bacilos'=> 'required|max:45',
            'cristales'=> 'required|max:45',
            'cilindros'=> 'required|max:45',
            'piocitos'=> 'required|max:45',
            'observaciones' => 'required|max:200'
        ]);
    }

    public function guardar(Request $request)
    {
        $this->validateRequest($request);
        $model = ExamenOrina::create($request->except(['_token']));
        $model->save();
        return redirect()->route('examenOrina.nuevo');
    }

    public function update(Request $request, $id_examenOrina)
    {
        $this->validateRequest($request);
        $examenOrina = ExamenOrina::find($id_examenOrina);
        $examenOrina->update($request->except(['_token', '_method']));
        return redirect()->route('examenOrina.editar');
    }


    public function editar(Request $request)
    {
        $model=new ExamenOrina();
        $texto=$request->query('texto','');
        $datos=$model->buscar($texto);
        return view('laboratorio.orina.editar',compact('texto','datos'));
    }
    public function edit($id_examenOrina)
    {
        $examenOrina = ExamenOrina::find($id_examenOrina);
        if ($examenOrina == null)
            return abort(404);
        $doctores = Doctor::all();
        return view('laboratorio.orina.edit', ['examenOrina' => $examenOrina, 'doctores' => $doctores]);
    }

    public function delete($id_examenOrina)
    {
        $examenOrina = ExamenOrina::find($id_examenOrina);
        if ($examenOrina == null)
            return abort(404);
        $examenOrina->delete();
        return redirect()->route('examenOrina.editar');
    }

    public function todos()
    {
        return view('laboratorio.orina.eliminar');
    }
}
