<?php

namespace App\Http\Controllers;

use App\Models\LbOrder;
use App\Models\LbOrderTest;
use Illuminate\Http\Request;

class LbOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        if($request->has('pending') && $request->has('identification_number')){
            $model=new LbOrder();
            $orders=$model->pendingOrdersByIdentification($request->input('identification_number'));
            return $this->sendResponse($orders,'Ordenes pendientes del paciente por cedula');
        }

        if($request->has('identification_number')){
            $model=new LbOrder();
            $orders=$model->currentOrderByIdentification($request->input('identification_number'));
            return $this->sendResponse($orders,'Ordenes del paciente por cedula');
        }

        return $this->sendResponse(LbOrder::all(),'Ordenes de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LbOrder  $lb_order
     * @return \Illuminate\Http\Response
     */
    public function show(LbOrder $lb_order)
    {
        $tests=LbOrderTest::with('test')->where('order_id','=',$lb_order->id)->get();
        $lb_order->tests=$tests;
        return $this->sendResponse($lb_order,'Orden con sus detalles');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbOrder  $lb_order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbOrder $lb_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LbOrder  $lb_order
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbOrder $lb_order)
    {
        //
    }
}
