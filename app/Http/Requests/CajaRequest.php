<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CajaRequest extends FormRequest
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
            'cedula'=>'required|max:10',
            'apellidos'=>'required|max:50',
            'nombres'=>'required|max:50',
            'fecha_nacimiento'=>'required|max:12',
            'sexo'=>'required|max:10',
            'telefono'=>'required|max:20',
            'domicilio'=>'required|max:150',
            'provincia'=>'required|max:50',
            'ciudad'=>'required|max:50',
            'valor'=>'required|numeric'
        ];
    }
}
