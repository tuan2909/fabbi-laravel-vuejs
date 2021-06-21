<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class SpecimenRequest extends FormRequest
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
            'date_infection' => 'required',
            'date_draw_blood' => 'required',
            'date_test' => 'required',
            'result_test' => 'required',
            'address' => 'required',
        ];
    }
}
