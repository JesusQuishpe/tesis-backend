<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnfermeriaRequest extends FormRequest
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
            'id_enfermeria'=>'required|numeric',
            'peso'=>'required|numeric',
            'estatura'=>'required|numeric',
            'temperatura'=>'required|numeric',
            'presion'=>'required',
            'discapacidad'=>'required|numeric',
            'embarazo'=>'required|numeric',
            'inyeccion'=>'required',
            'curacion'=>'required',
            'doctor'=>'required',
            'enfermera'=>'required'
        ];
    }
}
