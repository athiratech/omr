<?php

namespace App\OmrModels;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
include_once($_SERVER['DOCUMENT_ROOT'].'/sri_chaitanya/Exam_Admin/3_view_created_exam/z_ias_format.php');
class Exam extends Model
{
  protected $table='1_exam_admin_create_exam';
  protected $primaryKey='sl';
  public $timestamps=false;
  public static function total($data){
    $mode=array();
    $calculation="";
    $marklist=array(); 
    $stud=Campus::whereRaw('CAMPUS_ID ='.Auth::user()->CAMPUS_ID)->select('STATE_ID')
            ->get();
            //List the exam which is based on STATE_ID of the student
    $exam=static::whereRaw('FIND_IN_SET(?,state_id)', $stud[0]->STATE_ID)
          ->whereRaw('result_generated1_no0 =1')                
          ->select('mode','rank_generated_type','max_marks','sl','test_code','model_year','paper','omr_scanning_type','subject_string_final')
          ;
          //Validate test_type_id is set otherwise set as 1
    if(isset($data->test_type_id))
      $exam->where('test_type',$data->test_type_id);
    else
      $exam->where('test_type','1');

    if(isset($data->mode_id))
      $exam->where('mode',$data->mode_id);
    if(isset($data->date))
      $exam->where('start_date','like',$data->date.'%');
    $exam=$exam->get();

    foreach ($exam as $key => $value) 
    {
      //Fetch 0_test_modes details for table name
      $subject_marks=Mode::whereRaw('test_mode_id ='.$value->mode)
                  ->get();
      //Fetch record from that table name
      $exam_data=DB::table($subject_marks[0]->marks_upload_final_table_name)
            ->whereRaw('STUD_ID ="'.Auth::id().'"')
            ->whereRaw('test_code_sl_id ="'.$value->sl.'"')
            ->select('test_code_sl_id','STUD_ID','TOTAL','STREAM_RANK','PROGRAM_RANK','SEC_RANK','CAMP_RANK','CITY_RANK','DISTRICT_RANK','STATE_RANK','ALL_INDIA_RANK')
            ->get();
      //Add max marks and test_mode_name for calculation
        if(isset($exam_data[0])){
          $marklist[]=$exam_data;
      $calculation=static::overallmarklist1(array_sum(explode(',',$value->max_marks)),$exam_data[0]->TOTAL); 
        if(array_key_exists($subject_marks[0]->test_mode_name, $mode)){
          $sum=$mode[$subject_marks[0]->test_mode_name]+$calculation;
          $mode[$subject_marks[0]->test_mode_name]=$sum/2;
        }
        else{
        $mode[$subject_marks[0]->test_mode_name]=$calculation;  
        }       
      } 
    }
    foreach($mode as $key=>$value){
        $res_key[] = $key;
        $res_val[] = $value;
        }
    return [
        "Mode"=>["Mode_name"=>$res_key,
                  "Percentage"=>$res_val],
        "Marklist"=>$marklist,
        ];
    
  }
  //Calculation for individual subject with maxmark
  public static function overallmarklist($data){
    //This function is not finalised yet
    foreach ($data as $key => $value) {
      for($i=0;$i<=count($value->max_marks)-1;$i++)
      {
        if($value->omr_scanning_type=="advanced"){
          $subject_name=Subject::where('subject_name','LIKE',$value->subject_string_final[$i]."%")
                ->get();
              }
        else{
          $subject_name=Subject::where('subject_id',$value->subject_string_final[$i])
                ->get();
        }
        $percentage[$i]=($value->{strtoupper($subject_name[0]->subject_name)}/$value->max_marks[$i])*100;
      }
      $sum = array_sum($percentage)/count($percentage);
      return $sum;
    }
  }
  //Caluculate overall mark with sum ofmax_mark 
  public static function overallmarklist1($max_marks,$total){

    // foreach ($data as $key => $value) {
      return ($total/$max_marks)*100;
    // }

  }
  public static function type($data){
    $out=static::total($data)['Mode'];
    return $out;
  }
  public static function examlist($data){
    $out=static::total($data)['Marklist'];
    return $out;
  }
  public static function test_type_list($data){
    $out=DB::table('0_test_types')->select('test_type_id','test_type_name')->get();
    return $out;
  }
}
