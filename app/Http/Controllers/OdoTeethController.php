<?php

namespace App\Http\Controllers;


use App\Models\OdoTooth;

class OdoTeethController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(OdoTooth::all(),'Dientes');
    }
}
