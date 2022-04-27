<?php

namespace App\Http\Controllers;

use App\Models\LbOrder;
use App\Models\LbOrderTest;
use App\Models\LbResult;
use App\Models\LbResultDetail;
use App\Models\MedicalAppointment;
use App\Models\MedicineArea;
use App\Models\NursingArea;
use App\Models\OdoCpoCeoRatio;
use App\Models\OdoDiagnostic;
use App\Models\OdoDiagnosticPlan;
use App\Models\OdoFamilyHistory;
use App\Models\OdoFamilyHistoryDetail;
use App\Models\OdoIndicator;
use App\Models\OdoIndicatorDetail;
use App\Models\OdoMovilitieRecession;
use App\Models\OdoOdontogram;
use App\Models\OdoPatientRecord;
use App\Models\OdoPlanDetail;
use App\Models\OdoStomatognathicDetail;
use App\Models\OdoStomatognathicTest;
use App\Models\OdoTeethDetail;
use App\Models\OdoTreatment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class MedicalAppoitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Buscar por nombre completo
        if ($request->has('fullname')) {
            return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                ->select([
                    'medical_appointments.*',
                    'patients.fullname',
                    'patients.identification_number'
                ])
                ->where('patients.fullname', 'like', '%' . $request->input('fullname') . '%')
                ->paginate(10, '*', 'page', $request->input('page'))
                ->appends(['fullname' => $request->input('fullname')]), 'Citas por nombre completo');
        }

        if (
            $request->has('identification') &&
            $request->has('startDate') &&
            $request->has('endDate') &&
            $request->has('stateFilter') &&
            $request->has('page')
        ) {
            $identification = $request->input('identification');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $stateFilter = $request->input('stateFilter');
            $page = $request->input('page');

            $dataAppend = [
                'identification' => $identification,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'stateFilter' => $stateFilter,
                'page' => $page
            ];
            if ($identification && !$startDate && !$endDate && !$stateFilter) {
                //Buscar citas solo por cedula
                return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                    ->select([
                        'medical_appointments.*',
                        'patients.fullname',
                        'patients.identification_number'
                    ])
                    //->where('patient_id', '!=', null)
                    ->where('patients.identification_number', '=', $identification)
                    ->paginate(10, '*', 'page', $page)
                    ->appends($dataAppend), 'Citas por numero de cedula');
            }

            if (($startDate && $endDate) && !$identification  && !$stateFilter) {
                //Buscar citas solo por fechas
                return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                    ->select([
                        'medical_appointments.*',
                        'patients.fullname',
                        'patients.identification_number'
                    ])
                    ->where('medical_appointments.date', '>', $startDate)
                    ->where('medical_appointments.date', '<', $endDate)
                    ->paginate(10, '*', 'page', $page)
                    ->appends($dataAppend), 'Citas por fechas');
            }

            if ($stateFilter && (!$startDate && !$endDate) && !$identification) {
                //Buscar citas solo  por estado
                return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                    ->select([
                        'medical_appointments.*',
                        'patients.fullname',
                        'patients.identification_number'
                    ])
                    ->where('attended', '=', $stateFilter === "atendidas" ? 1 : 0)
                    ->paginate(10, '*', 'page', $page)
                    ->appends($dataAppend), 'Citas por estado');
            }

            if (($startDate && $endDate) && $stateFilter && !$identification) {
                //Buscar citas por fechas y estado
                return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                    ->select([
                        'medical_appointments.*',
                        'patients.fullname',
                        'patients.identification_number'
                    ])
                    ->where('medical_appointments.date', '>', $startDate)
                    ->where('medical_appointments.date', '<', $endDate)
                    ->where('attended', '=', $stateFilter === "atendidas" ? 1 : 0)
                    ->paginate(10, '*', 'page', $page)
                    ->appends($dataAppend), 'Citas por fechas y estado');
            }

            if (($startDate && $endDate) && $identification && !$stateFilter) {
                //Buscar citas por fechas y cedula
                return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                    ->select([
                        'medical_appointments.*',
                        'patients.fullname',
                        'patients.identification_number'
                    ])
                    //->where('patient_id', '!=', null)
                    ->where('patients.identification_number', '=', $identification)
                    ->where('medical_appointments.date', '>', $startDate)
                    ->where('medical_appointments.date', '<', $endDate)
                    ->paginate(10, '*', 'page', $page)
                    ->appends($dataAppend), 'Citas por fecha y cedula');
            }

            if ($identification && $stateFilter && (!$startDate && !$endDate)) {
                //Buscar citas por cedula y estado
                return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                    ->select([
                        'medical_appointments.*',
                        'patients.fullname',
                        'patients.identification_number'
                    ])
                    //->where('patient_id', '!=', null)
                    ->where('patients.identification_number', '=', $identification)
                    ->where('attended', '=', $stateFilter === "atendidas" ? 1 : 0)
                    ->paginate(10, '*', 'page', $page)
                    ->appends($dataAppend), 'Citas por cedula y estado');
            }

            //Citas con todos los parametros
            return $this->sendResponse(MedicalAppointment::join('patients', 'patient_id', '=', 'patients.id')
                ->select([
                    'medical_appointments.*',
                    'patients.fullname',
                    'patients.identification_number'
                ])
                //->where('patient_id', '!=', null)
                ->where('patients.identification_number', '=', $identification)
                ->where('medical_appointments.date', '>', $startDate)
                ->where('medical_appointments.date', '<', $endDate)
                ->where('attended', '=', $stateFilter === "atendidas" ? 1 : 0)
                ->paginate(10, '*', 'page', $page)
                ->appends($dataAppend), 'Citas con todos los parametros');
        }
        return $this->sendResponse(MedicalAppointment::with('patient')->paginate(10), 'Todas las citas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d');
        $hour = Carbon::now()->format('H:i:s');

        try {
            DB::beginTransaction();
            $appo = MedicalAppointment::create([
                'user_id' => $request->user_id,
                'date' => $date,
                'hour' => $hour,
                'appo_identification_number' => $request->identification_number,
                'area' => $request->area,
                'value' => $request->value,
                //'factura_cita' => null,
                //'estado_cita' => '',
                'patient_id' => $request->patient_id,
                //'estadisticas' => ''
            ]);

            $tests = $request->input('tests');
            //Agregamos las pruebas en caso de que el area sea laboratorio y haya tests
            if (
                $request->area === 'Laboratorio' &&
                $tests && count($tests) > 0
            ) {
                //Se crea la orden de laboratorio
                $order = new LbOrder();
                $order->appo_id = $appo->id;
                $order->date = $date;
                $order->hour = $hour;
                $order->test_items = count($tests);
                $order->total = $request->value;
                $order->save();
                //Agregamos las pruebas  a la orden
                foreach ($tests as $test) {
                    $newTest = new LbOrderTest();
                    $newTest->order_id = $order->id;
                    $newTest->test_id = $test['id'];
                    $newTest->price = $test['price'];
                    $newTest->save();
                }
            }

            /*if ($request->area !== 'Laboratorio') {
                $nur = new NursingArea();
                $nur->appo_id = $appo->id;
                $nur->save();
            }*/
            DB::commit();
            return $this->sendResponse($appo, 'Cita creada correctamente');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalAppointment  $appo
     * @return \Illuminate\Http\Response
     */
    public function show($appo_id)
    {
        //
        return $this->sendResponse(MedicalAppointment::with('patient')->find($appo_id), 'Cita');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedicalAppointment  $appo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalAppointment $appo)
    {
        //
        $errorMessage = "";
        $nur = NursingArea::where('appo_id', '=', $appo->id)->first();

        if ($nur) {
            //Si no ha sido attended se puede actualizar
            if (!$nur->attended) {
                //Actualizar cita

            } else {
                //No se puede actualizar porque ya ha sido attended por un tratante
                $errorMessage = "Esta cita medica ya fue asignado a medico tratante, el tratante debe primero eliminar";
                return $this->sendError($errorMessage);
            }
        }

        $appo->update($request->only('area', 'value'));
        return $this->sendResponse([], 'Registro actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalAppointment  $appo
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalAppointment $appo)
    {
        try {
            DB::beginTransaction();
            $nur = NursingArea::where('appo_id', '=', $appo->id)->first();
            if ($nur) {
                if ($appo->area === "Medicina") {
                    $medicineArea = MedicineArea::where('nur_id', '=', $nur->id)->firstOrFail();
                    $medicineArea->delete();
                }
                if ($appo->area === "Odontologia") {
                    $record = OdoPatientRecord::where('nur_id', '=', $nur->id)->firstOrFail();
                    $familyHistory = OdoFamilyHistory::where('rec_id', '=', $record->id)->firstOrFail();
                    $familyDetails = OdoFamilyHistoryDetail::where('fam_id', '=', $familyHistory->id);
                    $stomatognathic = OdoStomatognathicTest::where('rec_id', '=', $record->id)->firstOrFail();
                    $stomatognathicDetails = OdoStomatognathicDetail::where('sto_test_id', '=', $stomatognathic->id);
                    $indicator = OdoIndicator::where('rec_id', '=', $record->id)->firstOrFail();
                    $indicatorDetails = OdoIndicatorDetail::where('id_ind', '=', $indicator->id);
                    $cpoCeoRatio = OdoCpoCeoRatio::where('rec_id', '=', $record->id)->firstOrFail();
                    $diagnosticPlan = OdoDiagnosticPlan::where('rec_id', '=', $record->id)->firstOrFail();
                    $planDetails = OdoPlanDetail::where('diag_plan_id', '=', $diagnosticPlan->id);
                    $diagnostics = OdoDiagnostic::where('rec_id', '=', $record->id);
                    $treatments = OdoTreatment::where('rec_id', '=', $record->id);
                    $odontogram = OdoOdontogram::where('rec_id', '=', $record->id)->firstOrFail();
                    $teeth = OdoTeethDetail::where('odo_id', '=', $odontogram->id);
                    $movilitiesReccesions = OdoMovilitieRecession::where('odo_id', '=', $odontogram->id);

                    $movilitiesReccesions->delete();
                    $teeth->delete();
                    $odontogram->delete();
                    $treatments->delete();
                    $diagnostics->delete();
                    $planDetails->delete();
                    $diagnosticPlan->delete();
                    $cpoCeoRatio->delete();
                    $indicatorDetails->delete();
                    $indicator->delete();
                    $stomatognathicDetails->delete();
                    $stomatognathic->delete();
                    $familyDetails->delete();
                    $familyHistory->delete();
                    $record->delete();
                }
                $nur->delete();
            }

            if ($appo->area === "Laboratorio") {
                $order = LbOrder::where('appo_id', '=', $appo->id)->first();
                //dd($order);
                $orderTests = LbOrderTest::where('order_id', '=', $order->id);
                $result = LbResult::where('order_id', '=', $order->id)->first();
                $resultDetails = LbResultDetail::where('result_id', '=', $result->id);

                $orderTests->delete();
                $resultDetails->delete();
                $result->delete();
                $order->delete();
            }

            $appo->delete();
            DB::commit();
            return $this->sendResponse([], 'Cita eliminada');
        } catch (Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                throw $th;
            }
            throw $th;
        }
    }
}
