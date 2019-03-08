<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Template extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          return [
            "TemplateData"=> $request->template_data,
            "model_years"=>$request->model_years,
            "test_mode_id"=> $request->test_mode_id,
            // "Test_Type_Id"=>$request-> ,
            // "Test_Type_Name"=>$request-> ,
            // "Test_Mode_Id"=>$request-> ,
            // "Test_Mode_Name"=>$request-> ,
            // "Result_Generated_No"=> $request->,
            // "Scan_Type"=>$request-> ,
            // "Exam_Start_Date"=>$request-> ,
            // "Exam_Last_Date"=>$request-> ,
            // "Exam_Last_Time_To_Upload"=> $request->,
            // "Exam_Id"=>$request-> 1,
            // "Exam_Status"=>$request-> 6
        ];
    }
}
