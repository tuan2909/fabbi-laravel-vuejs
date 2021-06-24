<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class TypePatientUpdate extends FormRequest
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
            'name' => 'required|min:1|max:30|unique:type_patients,name,' . $this->id,
        ];
    }
}
