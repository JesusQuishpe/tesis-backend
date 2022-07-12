<?php

namespace App\Http\Controllers;

use App\Models\MedicalAppointment;
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
use App\Models\Patient;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OdontologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $actaPath = null;
        $odontogramPath = null;
        try {
            /*$odontogramName=time().'odontogram';
            $actaName=time().'acta';
            Storage::putFileAs('odontogramas',$request->file('odontogram_image'),$actaName);*/
            if ($request->hasFile('odontogram_image')) {
                $odontogramPath = $request->file('odontogram_image')->store('odontogramas');
            } else {
                return $this->sendError('No se ha podido cargar la imagen del odontograma');
            }
            //Guardamos el acta de constitucion si existe
            if ($request->hasFile('acta')) {
                $actaPath = $request->file('acta')->store('actas');
            }
            //if (!$actaPath) return $this->sendError('No se ha podido guardar el acta de constitucion en el servidor');


            /*$patient = NursingArea::join('medical_appointments', 'nursing_area.appo_id', '=', 'medical_appointments.id')
                ->join('patients', 'medical_appointments.patient_id', '=', 'patients.id')
                ->select([
                    'patients.*'
                ])
                ->firstOrFail();*/
            DB::beginTransaction();
            $data = json_decode($request->input('data'), true);
            //return $this->sendResponse($data,'Prueba');
            $record = new OdoPatientRecord();
            $record->date = $date;
            $record->hour=$hour;
            $record->age_range = $data['patient_record']['age_range'];
            $record->reason_consultation = $data['patient_record']['reason_consultation'];
            $record->current_disease_and_problems = $data['patient_record']['current_disease_and_problems'];
            $record->nur_id = $data['nur_id'];
            $record->user_id = $data['user_id'];
            $record->odontogram_path = $odontogramPath;
            $record->acta_path = $actaPath ? $actaPath : null;
            $record->attended = true;
            $record->value = $data['patient_record']['value'];
            $record->save();
            //Guardamos los antecedentes familiares
            $familyHistoryModel = new OdoFamilyHistory();
            $familyHistoryModel->description = $data['family_history']['familyHistoryDescription'];
            $familyHistoryModel->rec_id = $record->id;
            $familyHistoryModel->save();
            //Detalles de los antecedentes familiares
            foreach ($data['family_history']['selectedFamilyHistory'] as $detail) {
                $familyHistoryDetailModel = new OdoFamilyHistoryDetail();
                $familyHistoryDetailModel->fam_id = $familyHistoryModel->id;
                $familyHistoryDetailModel->disease_id = $detail;
                $familyHistoryDetailModel->save();
            }
            //Guardamos el examen stomatognatico
            $stomatognathicModel = new OdoStomatognathicTest();
            $stomatognathicModel->rec_id = $record->id;
            $stomatognathicModel->description = $data['family_history']['pathologiesDescription'];
            $stomatognathicModel->save();
            //Detalles del examen stomatognatico (patologias seleccionadas)
            foreach ($data['family_history']['selectedPathologies'] as $detail) {
                $stomatognathicDetailModel = new OdoStomatognathicDetail();
                $stomatognathicDetailModel->pat_id = $detail;
                $stomatognathicDetailModel->sto_test_id = $stomatognathicModel->id;
                $stomatognathicDetailModel->save();
            }
            //Guardamos los indicadores de salud bucal
            $indicatorModel = new OdoIndicator();
            $indicatorModel->rec_id = $record->id;
            $indicatorModel->per_disease = $data['indicators']['per_disease'];
            $indicatorModel->bad_occlu = $data['indicators']['bad_occlu'];
            $indicatorModel->fluorosis = $data['indicators']['fluorosis'];
            $indicatorModel->plaque_total = $data['indicators']['plaque_total'];
            $indicatorModel->calc_total = $data['indicators']['calc_total'];
            $indicatorModel->gin_total = $data['indicators']['gin_total'];
            $indicatorModel->save();
            //Guardamos los detalles de los indicadores
            foreach ($data['indicators']['indicator_details'] as $indicator) {
                $indicatorDetailModel = new OdoIndicatorDetail();
                $indicatorDetailModel->id_ind = $indicatorModel->id;
                $indicatorDetailModel->piece1 = $indicator['piece1'];
                $indicatorDetailModel->piece2 = $indicator['piece2'];
                $indicatorDetailModel->piece3 = $indicator['piece3'];
                $indicatorDetailModel->plaque = $indicator['plaque'];
                $indicatorDetailModel->calc = $indicator['calc'];
                $indicatorDetailModel->gin = $indicator['gin'];
                $indicatorDetailModel->save();
            }
            //Guardamos los indices
            $cpoCeoRatioModel = new OdoCpoCeoRatio();
            $cpoCeoRatioModel->rec_id = $record->id;
            $cpoCeoRatioModel->cd = $data['cpo_ceo_ratios']['cpo_c'] ?: 0;
            $cpoCeoRatioModel->pd = $data['cpo_ceo_ratios']['cpo_p'] ?: 0;
            $cpoCeoRatioModel->od = $data['cpo_ceo_ratios']['cpo_o'] ?: 0;
            $cpoCeoRatioModel->ce = $data['cpo_ceo_ratios']['ceo_c'] ?: 0;
            $cpoCeoRatioModel->ee = $data['cpo_ceo_ratios']['ceo_e'] ?: 0;
            $cpoCeoRatioModel->oe = $data['cpo_ceo_ratios']['ceo_o'] ?: 0;
            $cpoCeoRatioModel->cpo_total = $data['cpo_ceo_ratios']['cpo_total'] ?: 0;
            $cpoCeoRatioModel->ceo_total = $data['cpo_ceo_ratios']['ceo_total'] ?: 0;
            $cpoCeoRatioModel->save();
            //Guardamos el plan diagnostico
            $diagnosticPlanModel = new OdoDiagnosticPlan();
            $diagnosticPlanModel->rec_id = $record->id;
            $diagnosticPlanModel->description = $data['diagnostic_plans']['plan_description'];
            $diagnosticPlanModel->save();
            //Guardamos los detalles del plan diagnostico (viene como un array de ids)
            foreach ($data['diagnostic_plans']['selected_plans'] as $detail) {
                $diagnosticPlanDetailModel = new OdoPlanDetail();
                $diagnosticPlanDetailModel->diag_plan_id = $diagnosticPlanModel->id;
                $diagnosticPlanDetailModel->plan_id = $detail['plan_id'];
                $diagnosticPlanDetailModel->save();
            }
            //Guardamos los diagnosticos
            foreach ($data['diagnostic_plans']['diagnostics'] as $diagnostic) {
                $diagnosticModel = new OdoDiagnostic();
                $diagnosticModel->rec_id = $record->id;
                $diagnosticModel->cie_id = $diagnostic['cie']['value'];
                $diagnosticModel->diagnostic = $diagnostic['description'];
                $diagnosticModel->type = $diagnostic['type'];
                $diagnosticModel->save();
            }
            //Guardamos los tratamientos
            foreach ($data['treatments'] as $treatment) {
                $treatmentModel = new OdoTreatment();
                $treatmentModel->rec_id = $record->id;
                $treatmentModel->sesion = $treatment['sesion'];
                $treatmentModel->date = $date;
                $treatmentModel->complications = $treatment['complications'];
                $treatmentModel->procedures = $treatment['procedures'];
                $treatmentModel->prescriptions = $treatment['prescriptions'];
                $treatmentModel->save();
            }
            //Guardar odontograma
            $odontogramModel = new OdoOdontogram();
            $odontogramModel->rec_id = $record->id;
            $odontogramModel->save();
            //Guardar movilidades y recesiones
            foreach ($data['odontogram']['movilities_recessions'] as $item) {
                $movilitieRecessionModel = new OdoMovilitieRecession();
                $movilitieRecessionModel->odo_id = $odontogramModel->id;
                $movilitieRecessionModel->type = $item['type'];
                $movilitieRecessionModel->value = $item['value'];
                $movilitieRecessionModel->pos = $item['pos'];
                $movilitieRecessionModel->save();
            }
            //Guardamos los dientes que han sido llenados
            foreach ($data['odontogram']['teeth'] as $tooth) {
                $toothModel = new OdoTeethDetail();
                $toothModel->odo_id = $odontogramModel->id;
                $toothModel->tooth_id = $tooth['tooth_id'];
                $toothModel->symb_id = $tooth['symb_id'] === "" ? null : $tooth['symb_id'];
                $toothModel->top_side = $tooth['top_side'];
                $toothModel->right_side = $tooth['right_side'];
                $toothModel->left_side = $tooth['left_side'];
                $toothModel->bottom_side = $tooth['bottom_side'];
                $toothModel->center_side = $tooth['center_side'];
                //$toothModel->pos = $tooth['pos'];
                $toothModel->save();
            }
            //Actualizar el estado de la cita como atendida
            $appo = MedicalAppointment::find($data['appo_id']);
            $appo->attended = true;
            $appo->value = $appo->initial_value + $record->value;
            $appo->save();
            DB::commit();
            return $this->sendResponse([], 'Ficha del paciente guardada correctamente');
        } catch (\Throwable $th) {
            if (isset($odontogramPath) && Storage::exists($odontogramPath)) {
                Storage::delete($odontogramPath);
            }
            if (isset($actaPath) && Storage::exists($actaPath)) {
                Storage::delete($actaPath);
            }
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                throw $th;
            }
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d');
        $hour = Carbon::now()->format('H:i:s');

        $actaPath = null;
        $odontogramPath = null;
        $data = json_decode($request->input('data'), true);
        $actaNameOfFile = basename(Storage::path($data['patient_record']['acta_path']));
        $odontogramNameOfFile = basename(Storage::path($data['patient_record']['odontogram_path']));

        try {

            if ($request->hasFile('odontogram_image')) {
                Storage::move($data['patient_record']['odontogram_path'], 'odontogramas-eliminados/' . $odontogramNameOfFile);
                $odontogramPath = $request->file('odontogram_image')->store('odontogramas');
                if (!$odontogramPath) return $this->sendError('No se ha podido guardar la imagen del odontograma');
            } else {
                return $this->sendError('No se ha podido cargar la imagen del odontograma');
            }

            //Validamos si a enviado una nueva acta
            if ($request->hasFile('acta')) {
                if ($data['patient_record']['acta_path']) { //Verificamos si ya ha guardado una acta antes
                    //Movemos la anterior acta al directorio actas-eliminadas
                    Storage::move($data['patient_record']['acta_path'], 'actas-eliminadas/' . $actaNameOfFile);
                }
                //Agregamos la nueva
                $actaPath = $request->file('acta')->store('actas');
            } else {
                if ($data['patient_record']['acta_path']) {
                    $actaPath = $data['patient_record']['acta_path']; //Mantiene la path anterior
                }
            }

            DB::beginTransaction();

            $record = OdoPatientRecord::find($data['patient_record']['id']);
            $record->date = $date;
            $record->hour=$hour;
            $record->age_range = $data['patient_record']['age_range'];
            $record->reason_consultation = $data['patient_record']['reason_consultation'];
            $record->current_disease_and_problems = $data['patient_record']['current_disease_and_problems'];
            $record->user_id = $data['user_id'];
            $record->odontogram_path = $odontogramPath;
            $record->acta_path = $actaPath;
            $record->value = $data['patient_record']['value'];
            $record->save();

            //Actualizamos los antecedentes familiares
            $familyHistoryModel = OdoFamilyHistory::find($data['family_history']['fam_id']);
            $familyHistoryModel->description = $data['family_history']['familyHistoryDescription'];
            $familyHistoryModel->save();

            //Detalles de los antecedentes familiaress
            //Primero eliminamos
            OdoFamilyHistoryDetail::where('fam_id', '=', $familyHistoryModel->id)->delete();
            foreach ($data['family_history']['selectedFamilyHistory'] as $item) {
                $familyHistoryDetailModel = new OdoFamilyHistoryDetail();
                $familyHistoryDetailModel->fam_id = $familyHistoryModel->id;
                $familyHistoryDetailModel->disease_id = $item;//$item es el disease_id
                $familyHistoryDetailModel->save();
            }

            //Actualizamos el examen stomatognatico
            $stomatognathicModel = OdoStomatognathicTest::find($data['family_history']['sto_test_id']);
            $stomatognathicModel->description = $data['family_history']['pathologiesDescription'];
            $stomatognathicModel->save();

            //Detalles del examen stomatognatico (patologias seleccionadas)
            //Primero eliminamos
            OdoStomatognathicDetail::where('sto_test_id', '=', $stomatognathicModel->id)->delete();
            foreach ($data['family_history']['selectedPathologies'] as $item) {
                $stomatognathicDetailModel = new OdoStomatognathicDetail();
                $stomatognathicDetailModel->pat_id = $item;//item es el pat_id
                $stomatognathicDetailModel->sto_test_id = $stomatognathicModel->id;
                $stomatognathicDetailModel->save();
            }

            //Guardamos los indicadores de salud bucal
            $indicatorModel = OdoIndicator::findOrFail($data['indicators']['id']);
            $indicatorModel->per_disease = $data['indicators']['per_disease'];
            $indicatorModel->bad_occlu = $data['indicators']['bad_occlu'];
            $indicatorModel->fluorosis = $data['indicators']['fluorosis'];
            $indicatorModel->plaque_total = $data['indicators']['plaque_total'];
            $indicatorModel->calc_total = $data['indicators']['calc_total'];
            $indicatorModel->gin_total = $data['indicators']['gin_total'];
            $indicatorModel->save();

            //Guardamos los detalles de los indicadores
            foreach ($data['indicators']['indicator_details'] as $indicator) {
                OdoIndicatorDetail::updateOrCreate(
                    ['id' => $indicator['id']],
                    [
                        'id_ind' => $indicatorModel->id,
                        'piece1' => $indicator['piece1'],
                        'piece2' => $indicator['piece2'],
                        'piece3' => $indicator['piece3'],
                        'plaque' => $indicator['plaque'],
                        'calc' => $indicator['calc'],
                        'gin' => $indicator['gin'],
                    ]
                );
            }

            //Guardamos los indices
            $cpoCeoRatioModel = OdoCpoCeoRatio::findOrFail($data['cpo_ceo_ratios']['id']);
            $cpoCeoRatioModel->cd = $data['cpo_ceo_ratios']['cpo_c'] ?: 0;
            $cpoCeoRatioModel->pd = $data['cpo_ceo_ratios']['cpo_p'] ?: 0;
            $cpoCeoRatioModel->od = $data['cpo_ceo_ratios']['cpo_o'] ?: 0;
            $cpoCeoRatioModel->ce = $data['cpo_ceo_ratios']['ceo_c'] ?: 0;
            $cpoCeoRatioModel->ee = $data['cpo_ceo_ratios']['ceo_e'] ?: 0;
            $cpoCeoRatioModel->oe = $data['cpo_ceo_ratios']['ceo_o'] ?: 0;
            $cpoCeoRatioModel->cpo_total = $data['cpo_ceo_ratios']['cpo_total'] ?: 0;
            $cpoCeoRatioModel->ceo_total = $data['cpo_ceo_ratios']['ceo_total'] ?: 0;
            $cpoCeoRatioModel->save();

            //Guardamos el plan diagnostico
            $diagnosticPlanModel = OdoDiagnosticPlan::findOrFail($data['diagnostic_plans']['id']);
            $diagnosticPlanModel->description = $data['diagnostic_plans']['plan_description'];
            $diagnosticPlanModel->save();

            //Guardamos los detalles del plan diagnostico (viene como un array de ids)
            //Primero eliminamos
            OdoPlanDetail::where('diag_plan_id', '=', $diagnosticPlanModel->id)->delete();
            foreach ($data['diagnostic_plans']['selected_plans'] as $item) {
                $diagnosticPlanDetailModel = new OdoPlanDetail();
                $diagnosticPlanDetailModel->diag_plan_id = $diagnosticPlanModel->id;
                $diagnosticPlanDetailModel->plan_id = $item['plan_id'];
                $diagnosticPlanDetailModel->save();
            }

            //Primero eliminamos los diagnosticos
            OdoDiagnostic::where('rec_id', '=', $record->id)->delete();
            foreach ($data['diagnostic_plans']['diagnostics'] as $diagnostic) {
                //Guardamos los nuevos diagnosticos
                $diagnosticModel = new OdoDiagnostic();
                $diagnosticModel->rec_id = $record->id;
                $diagnosticModel->cie_id = $diagnostic['cie']['value'];
                $diagnosticModel->diagnostic = $diagnostic['description'];
                $diagnosticModel->type = $diagnostic['type'];
                $diagnosticModel->save();
            }

            //Primero eliminamos los tratamientos
            OdoTreatment::where('rec_id', '=', $record->id)->delete();
            //Guardamos los tratamientos
            foreach ($data['treatments'] as $treatment) {
                $treatmentModel = new OdoTreatment();
                $treatmentModel->rec_id = $record->id;
                $treatmentModel->sesion = $treatment['sesion'];
                $treatmentModel->date = $date;
                $treatmentModel->complications = $treatment['complications'];
                $treatmentModel->procedures = $treatment['procedures'];
                $treatmentModel->prescriptions = $treatment['prescriptions'];
                $treatmentModel->save();
            }

            //Eliminamos las movilidades y recesiones
            OdoMovilitieRecession::where('odo_id', $data['odontogram']['id'])->delete();
            foreach ($data['odontogram']['movilities_recessions'] as $item) {
                //Agregamos las nuevas
                $movilitieRecessionModel = new OdoMovilitieRecession();
                $movilitieRecessionModel->odo_id = $data['odontogram']['id'];
                $movilitieRecessionModel->type = $item['type'];
                $movilitieRecessionModel->value = $item['value'];
                $movilitieRecessionModel->pos = $item['pos'];
                $movilitieRecessionModel->save();
            }
            //Eliminamos los dientes que han sido llenados
            OdoTeethDetail::where('odo_id', $data['odontogram']['id'])->delete();
            foreach ($data['odontogram']['teeth'] as $tooth) {
                $toothModel = new OdoTeethDetail();
                $toothModel->odo_id = $data['odontogram']['id'];
                $toothModel->tooth_id = $tooth['tooth_id'];
                $toothModel->symb_id = $tooth['symb_id'] === "" ? null : $tooth['symb_id'];
                $toothModel->top_side = $tooth['top_side'];
                $toothModel->right_side = $tooth['right_side'];
                $toothModel->left_side = $tooth['left_side'];
                $toothModel->bottom_side = $tooth['bottom_side'];
                $toothModel->center_side = $tooth['center_side'];
                $toothModel->save();
            }
            //Actualizar el valor de la cita
            $appo = MedicalAppointment::findOrFail($data['appo_id']);
            $appo->attended = true;
            $appo->value = $appo->initial_value + $record->value; //El valor de dos es fijo, corresponde al valor de la consulta
            $appo->save();
            DB::commit();
            //Si todo se completa eliminamos los odontogramas y actas movidos
            Storage::delete('odontogramas-eliminados/' . $odontogramNameOfFile);
            Storage::delete('actas-eliminadas/' . $actaNameOfFile);
            return $this->sendResponse([], 'Ficha del paciente guardada correctamente');
        } catch (\Throwable $th) {
            if (isset($odontogramPath) && Storage::exists($odontogramPath)) {
                //Restablecemos el anterior odontograma y eliminamos el nuevo
                Storage::move(
                    'odontogramas-eliminados/' . $odontogramNameOfFile,
                    $data['patient_record']['odontogram_path']
                ); //Movemos el antiguo odontograma a su respectivo directorio
                Storage::delete($odontogramPath); //Eliminamos el nuevo odontograma
            }
            if (isset($actaPath) && Storage::exists($actaPath)) {
                //Restablecemos la anterior acta y eliminamos la nueva
                Storage::move(
                    'actas-eliminadas/' . $actaNameOfFile,
                    $data['patient_record']['acta_path']
                ); //Movemos la antiguo acta a su respectivo directorio
                Storage::delete($actaPath); //Eliminamos el acta que se ha actualizado
            }
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                throw $th;
            }
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nurId)
    {
        try {
            DB::beginTransaction();
            $nur = NursingArea::find($nurId);
            $appo = MedicalAppointment::find($nur->appo_id);
            $nur->delete();
            $appo->delete();
            DB::commit();
            return $this->sendResponse([], 'Valores de enfermeria y cita eliminados correctamente');
        } catch (\Throwable $th) {
            try {
                DB::rollBack();
            } catch (\Throwable $th) {
                throw $th;
            }
            throw $th;
        }
    }
}
