<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Examlist extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules=[
            "user_type"=>"required",
               "group_id"=>"required",
               "class_id"=>"required",
               "stream_id"=>"required",
               "program_id"=>"required",
               "subject_id"=>"required",
            ];
            if(\Request::segment(2)=="examlist")
            $rules=array_merge($rules,["page"=>"required","mode"=>"required","test_type"=>"required"]);
            if(\Request::segment(2)=="teacher_studentlist")
            $rules=array_merge($rules,["section_id"=>"required","exam_id"=>"required","page"=>"required"]);

            return $rules;

    }
     public function messages()
    {
        $messages=[
            "user_type.required"=>"user_type is required",
           "group_id.required"=>"group_id is required",
           "class_id.required"=>"class_id is required",
           "stream_id.required"=>"stream_id is required",
           "program_id.required"=>"program_id is required",
           "subject_id.required"=>"subject_id is required",
        ];
            if(\Request::segment(2)=="examlist")
         $messages=array_merge($messages,["page.required"=>"page is required","mode.required"=>"mode is required","test_type.required"=>"test_type is required"]);
     if(\Request::segment(2)=="teacher_studentlist")
            $messages=array_merge($messages,["section_id.required"=>"section_id is required","exam_id.required"=>"exam_id is required","page.required"=>"page is required"]);

        return $messages;
    }
}
