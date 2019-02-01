<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Totalpercentage extends FormRequest
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
        $rules=array();
        if(request()->get('user_type')=='employee')
       $rules=[
            'group_id'=>'required',
            'class_id'=>'required',
            'stream_id'=>'required',
            'program_id'=>'required',
            'subject_id'=>'required',
        ];
        return $rules;
    }
    public function messages()
    {
        return [
           'group_id.required'=>'group_id is required',
           'class_id.required'=>'class_id is required',
           'stream_id.required'=>'stream_id is required',
           'program_id.required'=>'program_id is required',
           'subject_id.required'=>'subject_id is required',
        ];
    }
}
