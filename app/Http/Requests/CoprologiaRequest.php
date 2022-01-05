<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoprologiaRequest extends FormRequest
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
            'consistencia'=>'required|max:100',
            'moco'=>'required|max:45',
            'sangre'=>'required|max:45',
            'ph'=>'required|numeric',
            'azucares_reductores'=>'required|max:45',
            'levadura_y_micelos'=>'required|max:45',
            'gram'=>'required|max:100',
            'leucocitos'=>'required|max:45',
            'polimorfonucleares'=>'required|max:100',
            'mononucleares'=>'required|max:100',
            'protozoarios'=>'required|max:100',
            'helmintos'=>'required|max:100',
            'esteatorrea'=>'required|max:100',
            'observaciones'=>'required|max:100'
        ];
    }
}
