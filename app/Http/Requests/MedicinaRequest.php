<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicinaRequest extends FormRequest
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
            'id_enfermeria'=>'required|numeric',
            'sintoma1'=>'required|max:255',
            //'sintoma2'=>'max:255',
            //'sintoma3'=>'max:255',
            'presuntivo1'=>'required|max:255',
            //'presuntivo2'=>'max:255',
            //'presuntivo3'=>'max:255',
            'definitivo1'=>'required|max:255',
            //'definitivo2'=>'max:255',
            //'definitivo3'=>'max:255',
            'medicamento1'=>'required|max:255',
            /*'medicamento2'=>'max:255',
            'medicamento3'=>'max:255',
            'medicamento4'=>'max:255',
            'medicamento5'=>'max:255',
            'medicamento6'=>'max:255',*/
            'dosificacion1'=>'required|max:255',
            /*'dosificacion2'=>'max:255',
            'dosificacion3'=>'max:255',
            'dosificacion4'=>'max:255',
            'dosificacion5'=>'max:255',
            'dosificacion6'=>'max:255',*/
        ];
    }
}
