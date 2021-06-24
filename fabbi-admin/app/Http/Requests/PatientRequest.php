<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class PatientRequest extends FormRequest
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
            'full_name' => 'required|min:3|max:30',
            'citizen_identify' => 'required|min:10|max:12',
            'nation' => 'required',
            'year_birth' => 'required|min:4|max:4',
            'address' => 'required',
            'number' => 'required|min:10|max:12',
            'email' => 'required|email',
            'address_start' => 'required',
            'address_end' => 'required',
        ];
    }
}
