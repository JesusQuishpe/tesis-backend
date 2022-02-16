<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoproparasitarioRequest extends FormRequest
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
            'protozoarios'=>'required|max:45',
            'ameba_histolitica'=>'required|max:100',
            'ameba_coli'=>'required|max:100',
            'giardia_lmblia'=>'required|max:100',
            'trichomona_hominis'=>'required|max:45',
            'chilomastik_mesnile'=>'required|max:45',
            'helmintos'=>'required|max:45',
            'trichuris_trichura'=>'required|max:45',
            'ascaris_lumbricoides'=>'required|max:45',
            'strongyloides_stercolarie'=>'required|max:45',
            'oxiuros'=>'required|max:45',
            'observaciones'=>'required|max:200'
        ];
    }
}
