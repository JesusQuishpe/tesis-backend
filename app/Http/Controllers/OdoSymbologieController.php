<?php

namespace App\Http\Controllers;

use App\Models\OdoSymbologie;


class OdoSymbologieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return $this->sendResponse(OdoSymbologie::all(),'Simbologias');
    }
}
