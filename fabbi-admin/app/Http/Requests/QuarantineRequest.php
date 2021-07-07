<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class QuarantineRequest extends FormRequest
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
            'patient_id' => 'required',
            'time_start' => 'required|date',
            'time_end' => 'required|date|after_or_equal:time_start',
        ];
    }
}
