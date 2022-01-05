<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BioquimicaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_cita'=>'required|numeric',
            'id_doc'=>'required|numeric',
            'id_tipo'=>'required|numeric',
            'glucosa'=>'required|numeric',
            'urea'=>'required|numeric',
            'creatinina'=>'required|numeric',
            'acido_urico'=>'required|numeric',
            'colesterol_total'=>'required|numeric',
            'colesterol_hdl'=>'required|numeric',
            'colesterol_ldl'=>'required|numeric',
            'trigliceridos'=>'required|numeric',
            'proteinas_totales'=>'required|numeric',
            'albumina'=>'required|numeric',
            'globulina'=>'required|numeric',
            'relacion_ag'=>'required|numeric',
            'bilirrubina_directa'=>'required|numeric',
            'bilirrubina_indirecta'=>'required|numeric',
            'bilirrubina_total'=>'required|numeric',
            'gamma_gt'=>'required|numeric',
            'calcio'=>'required|numeric',
            'vdrl'=>'required',
            'proteinas_c_react'=>'required',
            'ra_test_latex'=>'required',
            'asto'=>'required',
            'salmonella_o'=>'required',
            'salmonella_h'=>'required',
            'paratifica_a'=>'required',
            'paratifica_b'=>'required',
            'proteus_0x19'=>'required',
            'proteus_0x2'=>'required',
            'proteus_0xk'=>'required',
            'transaminasa_ox'=>'required|numeric',
            'transaminasa_pir'=>'required|numeric',
            'fosfatasa_alcalina_adultos'=>'required|numeric',
            'fosfatasa_alcalina_ninos'=>'required|numeric',
            'amilasa'=>'required|numeric',
            'lipasa'=>'required|numeric',
            'observaciones'=>'required'
        ];
    }
}
