<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\FormRequest;

class UserStore extends FormRequest
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
            "name" => 'required|min:3|max:20',
            "email" => 'required|email|unique:users',
            "password" => 'required|min:8|max:20',
            "password_confirmation" => 'required|same:password',
        ];
    }

}
