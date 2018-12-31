<?php

namespace App\OmrModels;
use App\BaseModels\Campus;
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
  public static function AnswerDetails($data){
   $correctans=static::where('sl',$data->exam_id)->select('key_answer_file_long_string as CorrectAnswer','model_year','paper','omr_scanning_type','to_from_range','subject_string_final')->get();

    return static::AnswerObtain($data,$correctans);
    $marked="";

   if($correctans[0]->omr_scanning_type=='advanced')
   {
     $filedata=ias_model_year_paper($correctans[0]->model_year,$correctans[0]->paper);

     return static::AdvanceAnswer($filedata,$correctans,$marked);
    }
    else
    {
      $subj=array();

      $filedata[6]=$correctans[0]->to_from_range;

      foreach (explode(',',$correctans[0]->subject_string_final) as $key => $value) 
      {
        $subj[]=DB::table('0_subjects')->where('subject_id',$value)->pluck('subject_name')[0];
      }
      $filedata[0]=$subj;

       return static::NonAdvanceAnswer($filedata,$correctans,$marked);
    }

  }
  public static function NonAdvanceAnswer($data,$ans,$marked){
   $list=array();
   $correct=explode(',', $ans[0]->CorrectAnswer);
    $b1=explode(',', $data[6]);
    $b2=end($b1);
    $b3=explode('-', $b2);

    $i=1;    $s=0;    $su=0;    $sub=0;    $ans=0;

    $subject_list=explode(',', $data[6]);

    $subject_name=array_filter($data[0]);

    $temp="";

    for ($key=0; $key <= end($b3)-1; $key++) 
    { 
      $subjectwise=explode('-',$subject_list[$su]);

        $subject=$subject_name[$sub];

      if($key==end($subjectwise))
      {
        $su++;        $sub++;
      }
      $list[$i]= new \stdClass();
      $list[$i]->{'question_no'}=$i;
      $list[$i]->{'subject_name'}=$subject;
      $list[$i]->{'correct_answer'}=$correct[$ans];
      $list[$i]->{'marked_answer'}=$marked;
      $i++;
      $ans++;
    }
    return $list;
  }
  public static function AdvanceAnswer($data,$ans,$marked){
    $list=array();

    $correct=explode(',', $ans[0]->CorrectAnswer);

    $i=1;    $s=0;    $su=0;    $sub=1;    $ans=0;

    $subject_list=explode(',', $data[6]);
    $subject_name=array_filter($data[0]);
    $section_list=array_filter($data[1]);
    $temp="";

    foreach ($section_list as $key => $value) 
    {
      $subjectwise=explode('-',$subject_list[$su]);
        $subject=$subject_name[$sub];
      if($key==end($subjectwise))
      {
        $su++;        $sub++;
      }
      if($temp!=$value)
      {
        $temp=$value;
        $s++;
      }
      $list[$i]= new \stdClass();
      $list[$i]->{'question_no'}=$key;
      $list[$i]->{'question_type'}=$value;
      $list[$i]->{'section'}='Section'.$s;
      $list[$i]->{'subject_name'}=$subject;
      $list[$i]->{'correct_answer'}=$correct[$ans];
       $list[$i]->{'marked_answer'}=$marked;
      $i++;
      $ans++;
      }
      return $list;
  }
  public static function AnswerObtain($data,$ans)
  {
    $alphabet = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' ); 
     $pqrst = array('p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'); 
    if($ans[0]->omr_scanning_type=="advanced")
    {
    $path='/var/www/html/sri_chaitanya/College/3_view_created_exam/uploads/'.Auth::user()->CAMPUS_ID.'/final/'.Auth::user()->ADM_NO.'.iit';
    $astring="x,8464277-A,3,2,4,0,1,2,3,3,4,3,4,0,3,4,1,2,4,235,1235,245,145,0,0,0,0,1,4,4,3,0,1,0,2,1,2,4,3,1,0,2,1,3,2,4,1,3,4,1,2,5,0,0,3,4";
    }
    else
    {
    $path='/var/www/html/sri_chaitanya/College/3_view_created_exam/uploads/'.Auth::user()->CAMPUS_ID.'/final/'.Auth::user()->ADM_NO.'.dat';
    $nstring="x,8464277-A,3,2,4,0,1,2,3,3,4,3,4,0,3,4,1,2,4,235,1235,245,145,0,0,0,0,1,4,4,3,0,1,0,2,1,2,4,3,1,0,2,1,3,2,4,1,3,4,1,2,5,0,0,3,4";
    }
  $answer=explode(',', $astring);
  // $answer2=array_splice($answer, 2);
  $answer1=array_slice($answer, 2);
  for($i=0;$i<=count($answer1);$i++) 
  {
    $data=$answer1[$i];
    if($i<'26')
    $ob[]=$alphabet[$data];
  }
    return [
          "ansdata"=>$ob,
          // "ans"=>explode(',',$ans[0]->CorrectAnswer),
          // "ADM_NO"=>Auth::user()->ADM_NO,
          // "CAMPUS_ID"=>Auth::user()->CAMPUS_ID,
          // "Exam_Id"=>$data->exam_id,
          // "Answer_path"=>$path,
          // "Answer"=>$answer1
            ];
  }
}
