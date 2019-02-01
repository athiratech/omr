<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginResult extends FormRequest
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
           'USERNAME'=>'required',
           'PASSWORD'=>'required',
           'user_type'=>'required',
        ];
    }
    public function messages()
    {
        return [
           'USERNAME.required'=>'USERNAME is required',
           'PASSWORD.required'=>'PASSWORD is required',
           'user_type.required'=>'user_type is required',
        ];
    }
}
