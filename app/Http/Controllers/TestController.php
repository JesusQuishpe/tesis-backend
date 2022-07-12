<?php

namespace App\Http\Controllers;

use App\Models\LbTest;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->sendResponse(LbTest::with('group:id,name,area_id', 'group.area:id,name')
            ->get(), 'Pruebas de laboratorio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lb_test = new LbTest();
        $lb_test->code = $request->input('code');
        $lb_test->name = $request->input('name');
        $lb_test->group_id = $request->input('selected_group.value');
        if ($request->input('selected_measure.value') === -1) {
            $lb_test->measure_id = null;
        } else {
            $lb_test->measure_id = $request->input('selected_measure.value');
        }

        $lb_test->ref_value = $request->input('ref_value');
        $lb_test->of = $request->input('of') ? $request->input('of') : 0;
        $lb_test->until = $request->input('until') ? $request->input('until') : 0;
        $lb_test->operator_type = $request->input('operator_type', '');
        $lb_test->operator_value = $request->input('operator_value') ? $request->input('operator_value') : 0;
        $lb_test->interpretation = $request->input('interpretation', '');
        $lb_test->male_of = $request->input('male_of') ? $request->input('male_of') : 0;
        $lb_test->male_until = $request->input('male_until') ? $request->input('male_until') : 0;
        $lb_test->male_interpretation = $request->input('male_interpretation', '');
        $lb_test->female_of = $request->input('female_of') ? $request->input('female_of') : 0;
        $lb_test->female_until = $request->input('female_until') ? $request->input('female_until') : 0;
        $lb_test->female_interpretation = $request->input('female_interpretation', '');
        $lb_test->qualitative_value = $request->input('qualitative_value', '');
        $lb_test->price = $request->input('price');
        $lb_test->is_numeric = $request->input('is_numeric');
        $lb_test->formula = $request->input('formula');
        $lb_test->operands = $request->input('operands');
        $lb_test->notes = $request->input('notes', '');
        $lb_test->save();
        return $this->sendResponse($lb_test, 'Registro creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LbTest  $lb_test
     * @return \Illuminate\Http\Response
     */
    public function show($test_id)
    {
        $test = LbTest::with('group.area', 'measurement')->find($test_id);
        return $this->sendResponse($test, 'Prueba de laboratorio');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbTest  $lb_test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbTest $test)
    {

        $test->code = $request->input('code');
        $test->name = $request->input('name');
        $test->group_id = $request->input('selected_group.value');
        if ($request->input('selected_measure.value') === -1) {
            $test->measure_id = null;
        } else {
            $test->measure_id = $request->input('selected_measure.value');
        }

        $test->ref_value = $request->input('ref_value');
        $test->of = $request->input('of') ?: 0;
        $test->until = $request->input('until') ? $request->input('until') : 0;
        $test->operator_type = $request->input('operator_type', '');
        $test->operator_value = $request->input('operator_value') ? $request->input('operator_value') : 0;
        $test->interpretation = $request->input('interpretation', '');
        $test->male_of = $request->input('male_of') ? $request->input('male_of') : 0;
        $test->male_until = $request->input('male_until') ? $request->input('male_until') : 0;
        $test->male_interpretation = $request->input('male_interpretation', '');
        $test->female_of = $request->input('female_of') ? $request->input('female_of') : 0;
        $test->female_until = $request->input('female_until') ? $request->input('female_until') : 0;
        $test->female_interpretation = $request->input('female_interpretation');
        $test->qualitative_value = $request->input('qualitative_value');
        $test->price = $request->input('price');
        $test->is_numeric = $request->input('is_numeric');
        $test->formula = $request->input('formula');
        $test->operands = $request->input('operands');
        $test->notes = $request->input('notes');
        $test->save();
        return $this->sendResponse($test, 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LbTest  $lb_test
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbTest $test)
    {
        $test->delete();
        return $this->sendResponse([], 'Registro eliminado');
    }
}
