<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;
use App\Repositories\Specimen\SpecimenRepository;
use Carbon\Carbon;

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
        $rules = [
            'date_infection' => '',
            'date_draw_blood' => 'required|date|before:tomorrow',
            'date_test' => 'required|date|before:tomorrow',
            'result_test' => 'required',
            'address' => 'required',
        ];
       $this->date_infection ? $rules['date_infection'] = 'before:tomorrow' : $rules['date_infection'] = '';

        return $rules;
    }
}
