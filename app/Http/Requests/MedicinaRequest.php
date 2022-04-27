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
            'user_id'=>'numeric',
            'appo_id'=>'numeric',
            'nur_id'=>'numeric',
            'symptom1'=>'max:255',
            'symptom2'=>'max:255',
            'symptom3'=>'max:255',
            'presumptive1'=>'max:255',
            'presumptive2'=>'max:255',
            'presumptive3'=>'max:255',
            'definitive1'=>'max:255',
            'definitive2'=>'max:255',
            'definitive3'=>'max:255',
            'medicine1'=>'max:255',
            'medicine2'=>'max:255',
            'medicine3'=>'max:255',
            'medicine4'=>'max:255',
            'medicine5'=>'max:255',
            'medicine6'=>'max:255',
            'dosage1'=>'max:255',
            'dosage2'=>'max:255',
            'dosage3'=>'max:255',
            'dosage4'=>'max:255',
            'dosage5'=>'max:255',
            'dosage6'=>'max:255',
        ];
    }
}
