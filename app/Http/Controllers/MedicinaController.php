<?php

namespace App\Http\Controllers;

use App\Models\Medicina;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MedicinaController extends Controller
{
    public function index()
    {
        $model=new Medicina();
        $pacientes=$model->getPacientes();
        //$pacientes=Carbon::now()->format('Y-m-d');
        return view('medicina.index',['pacientes'=>$pacientes]);
    }
}
