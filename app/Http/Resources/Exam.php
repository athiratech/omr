<?php

namespace App\Http\Resources;
use App\OmrModels\Mode;
use App\OmrModels\Type;
use App\OmrModels\Modesyear;
use Illuminate\Http\Resources\Json\JsonResource;

    // include('status.php');
    // include_once($_SERVER['DOCUMENT_ROOT'].'/sri_chaitanya/College/3_view_created_exam/status.php');
class Exam extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    /*
Available Status:
 Status_number  Description

     1          IMK-Incomplete
     2          Date and time to upload is over
     3          Can upload  (CAN SCAN)
     4          Webprocessing is Pending
     5          Campus Result Generated but Final Ranking not generated yet
     6          Final Ranking Generated by Exam Admin
     7          Reupload.   (CAN SCAN)
*/

    public function toArray($request)
    {
        $mode=Type::where('test_type_id',$this->test_type)->get();
        $year=Mode::where('test_mode_id',$this->mode)->get();
        return [
            "Exam_Name"=> $this->test_code,
            "Test_Type_Id"=>$mode[0]->test_type_id ,
            "Test_Type_Name"=>$mode[0]->test_type_name ,
            "Test_Mode_Id"=>$year[0]->test_mode_id,
            "Test_Mode_Name"=>$year[0]->test_mode_name ,
            "Result_Generated_No"=> $this->result_generated1_no0 ,
            "Scan_Type"=>$this->omr_scanning_type,
            "Exam_Start_Date"=>$this->start_date,
            "Paper"=>$this->paper,
            "Model_year"=>$this->model_year,
            "Exam_Last_Date"=>$this->last_date_to_upload ,
            "Exam_Last_Time_To_Upload"=> $this->last_time_to_upload,
            "Exam_Id"=>$this->sl,
            "Exam_Status"=>intval(preg_replace('/[^0-9]+/', '',get_status($this->sl,120)), 10)
        ];
    }
}
