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
    // sleep(10);
    $res_key=array();
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
    if(isset($data->test_type))
      $exam->where('test_type',$data->test_type);
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
      ->join('1_exam_admin_create_exam as e','e.sl','=',$subject_marks[0]->marks_upload_final_table_name.'.test_code_sl_id')
            ->whereRaw('STUD_ID ="'.Auth::id().'"')
            ->whereRaw('test_code_sl_id ="'.$value->sl.'"')
            ->select('test_code_sl_id','STUD_ID','TOTAL','PROGRAM_RANK','STREAM_RANK','SEC_RANK','CAMP_RANK','CITY_RANK','DISTRICT_RANK','STATE_RANK','ALL_INDIA_RANK',DB::raw("DATE_FORMAT(e.start_date,'%d-%m-%Y') as start_date"),'e.test_code','e.max_marks')
            ->get();
            foreach ($exam_data as $keya => $valuea) {
              $exam_data[$keya]->DISTOTAL=(int)$valuea->TOTAL."/".array_sum(explode(',',$valuea->max_marks));
            }
      //Add max marks and test_mode_name for calculation
        if(isset($exam_data[0])){

          $marklist[]=$exam_data[0];
      $calculation=static::overallmarklist1(array_sum(explode(',',$value->max_marks)),$exam_data[0]->TOTAL); 
        if(array_key_exists($subject_marks[0]->test_mode_name, $mode)){
          $sum=$mode[$subject_marks[0]->test_mode_name]+$calculation;
          $mode[$subject_marks[0]->test_mode_name]=$sum/2;
          $modeid['test_mode_id'][$subject_marks[0]->test_mode_name]=$subject_marks[0]->test_mode_id;
        }
        else{
        $mode[$subject_marks[0]->test_mode_name]=$calculation;
        $modeid['test_mode_id'][$subject_marks[0]->test_mode_name]=$subject_marks[0]->test_mode_id;

        }       
      } 
    }

    $a=0;
    foreach($mode as $key=>$value){
        $res_key[$a]["Mode_name"] = $key;
        $res_key[$a][ "Percentage"] = number_format((float) $value, '2', '.', '');
        $res_key[$a][ "Mode_id"] = $modeid['test_mode_id'][$key];
        $a++;
        }
        if(empty($res_key))
          return [
                        'Mode' =>['Login'=> [
                            'response_message'=>"Student Record Not Found",
                            'response_code'=>"1"
                           ],"data"=>array()],
                             'Marklist' =>['Login'=> [
                            'response_message'=>"Exam List Not Found",
                            'response_code'=>"1"
                           ],"data"=>array()],
                    ];
    return [
        "Mode"=>['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],"data"=>$res_key],
        "Marklist"=>['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],"data"=>$marklist],
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
      if($max_marks)
      return ($total/$max_marks)*100;

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
    return 
                     ['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],"data"=>$out];
  }
  public static function AnswerDetails($data){
    $type="";
   $correctans=static::where('sl',$data->exam_id)->select('key_answer_file_long_string as CorrectAnswer','model_year','paper','omr_scanning_type','to_from_range','subject_string_final','sl','test_code')->get();

   if($correctans[0]->omr_scanning_type=='advanced')
   {

     $filedata=ias_model_year_paper($correctans[0]->model_year,$correctans[0]->paper);
     $marked=static::AnswerObtain($data,$correctans,array_filter($filedata[1]));

     return static::AdvanceAnswer($filedata,$correctans,$marked);
    }
    else
    {
     $marked=static::AnswerObtain($data,$correctans,$type);

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
    $sl=$ans[0]->sl;
    $test_code=$ans[0]->test_code;
   $list=array();
   $correct=explode(',', $ans[0]->CorrectAnswer);
    $b1=explode(',', $data[6]);
    $b2=end($b1);
    $b3=explode('-', $b2);

    $i=1;    $s=0;    $su=0;    $sub=0;    $ans=0;

    $subject_list=explode(',', $data[6]);

    $subject_name=array_filter($data[0]);

    $temp="";
    if(count($marked['ansdata'])==0)
      return "No Record Found";
    
    for ($key=0; $key<=end($b3)-1; $key++) 
    { 
      $subjectwise=explode('-',$subject_list[$su]);

        $subject=$subject_name[$sub];

      if($key==end($subjectwise))
      {
        $su++;        $sub++;
      }
      $list['Exam_Id']=$sl;
      $list['Exam_Name']=$test_code;
      $list['Subject'][$subject][$i]= new \stdClass();
      $list['Subject'][$subject][$i]->{'question_no'}=$i;
      // $list[$subject][$i]->{'subject_name'}=$subject;
      $list['Subject'][$subject][$i]->{'correct_answer'}=$correct[$ans];
      $list['Subject'][$subject][$i]->{'marked_answer'}=$marked['ansdata'][$ans];
       $list['Number_of_Subjects']=count($subject_name);
      $i++;
      $ans++;
    }
    return 
                     ['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],"data"=>$list];
  }
  public static function AdvanceAnswer($data,$ans,$marked){
    $sl=$ans[0]->sl;
    $test_code=$ans[0]->test_code;
    $list=array();

    $correct=explode(',', $ans[0]->CorrectAnswer);

    $i=1;    $s=0;    $su=0;    $sub=1;    $ans=0;

    $subject_list=explode(',', $data[6]);
    $subject_name=array_filter($data[0]);
    $section_list=array_filter($data[1]);
    $temp="";
    if(count($marked['ansdata'])==0)
      return "No Record Found";
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
      if($s>3)
        $s=1;
      $list['Exam_Id']=$sl;
      $list['Exam_Name']=$test_code;
      $list['Subject'][$subject.'_Section'.$s][$i]= new \stdClass();
      $list['Subject'][$subject.'_Section'.$s][$i]->{'question_no'}=$key;
      $list['Subject'][$subject.'_Section'.$s][$i]->{'question_type'}=$value;
      // $list[$i]->{'section'}='Section'.$s;
      // $list[$i]->{'subject_name'}=$subject;
      $list['Subject'][$subject.'_Section'.$s][$i]->{'correct_answer'}=$correct[$ans];
       $list['Subject'][$subject.'_Section'.$s][$i]->{'marked_answer'}=$marked['ansdata'][$ans];
       $list['Number_of_Subjects']=count($subject_name);
      $i++;
      $ans++;
      }
      return 
                     ['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],"data"=>$list];
  }
  public static function AnswerObtain($data,$ans,$type)
  {
    $answer1=array();
      $ad=0;
      $ob=array();
     $abcd = array('A'=>1, 'B'=>2,'C'=>3 ,'D'=>4 ,'E'=>5 ,'F'=>6 ,'G'=>7 ,'H'=>8 ,'I'=>9,'U'=>0 );
     $nonadv=array('A'=>1,'B'=>2,'C'=>4,'D'=>8,'U'=>0);
     $integer=array('U'=>-1,'M'=>-2,'1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,'0'=>0);
     $pqrst = array('P'=>1, 'Q'=>2, 'R'=>3, 'S'=>4, 'T'=>5, 'U'=>6, 'V'=>7, 'W'=>8, 'X'=>9,'U'=>0); 
    if($ans[0]->omr_scanning_type=="advanced")
    {
    $path='/var/www/html/sri_chaitanya/College/3_view_created_exam/uploads/'.$ans[0]->sl.'/final/'.Auth::user()->CAMPUS_ID.'.iit';
    $astring=static::advanced($path,$ans[0]->sl);

     $answer=explode(',', $astring['Line']);
      $a=1;
      $answer1=array_slice($answer, 2);

    }
    else
    {
    $path='/var/www/html/sri_chaitanya/College/3_view_created_exam/uploads/'.$ans[0]->sl.'/final/'.Auth::user()->CAMPUS_ID.'.dat';
    $astring=static::nonadvanced($path,$ans[0]->sl);
     if(count($astring))
     $answer1=explode('   ', $astring['Line']);
      $a=1;
      $ad=1;
    }
 
  for($i=0;$i<=count($answer1)-2;$i++) 
  {
     $temp='';
     $arr_num=str_split ($answer1[$i]);
    foreach($arr_num as $data)
    {
      if($ad==1)
      {
      $temp.=array_search($data,$nonadv);
      }
      else
      {
        if($type[$a]=="mb")      
      $temp.=array_search($data,$pqrst);
        elseif($type[$a]=="i")
      $temp.=array_search($data,$integer);    
        else
      $temp.=array_search($data,$abcd);
      }
    }
    $answer1[$i]=$temp;
    $ob[]=$answer1[$i];
    $a++;
  }
    return [
          "ansdata"=>$ob,
            ];
  }


// ADVANCED
public static function advanced($filename,$sl){

$lines = file($filename);

$count=0;

$line_count=0;


foreach ($lines as $line_num => $line)
  { 
   $line=trim($line);    


      $current_single_iit_line=$line;
      //correct ias=key file ... stored from ui.. first index leave blank
      
      $current_single_iit_line_array=explode(",",$current_single_iit_line);
    
      $current_usn_with_flag_if_exist=$current_single_iit_line_array[1];
      $current_usn_with_flag_if_exist_array=explode("-",$current_usn_with_flag_if_exist);

      $current_usn=$current_usn_with_flag_if_exist_array[0];



         if(isset($current_usn_with_flag_if_exist_array[1]))
          {
              $current_usn_flag=$current_usn_with_flag_if_exist_array[1];   // FLAG   =>  D,   A  or blank
          }
          else
          {
              $current_usn_flag="blank";  
          }

          if(substr(Auth::id(),2)==$current_usn){
    if($current_usn_flag=="blank"){
    return [
      "Flag"=>$current_usn_flag,
      "USN"=>$current_usn,
      "Line"=>$line,
            ];
          }
    elseif($current_usn_flag=="A"){
      $approve=DB::table('101_mismatch_approval_request')->where('STUD_ID',Auth::id())->where('test_sl',$sl)->where('status',1)->get();
      if(count($approve))
        return [
            "Flag"=>$current_usn_flag,
            "USN"=>$current_usn,
            "Line"=>$line,
                  ];
                  else
                    continue;
    }
    else{
      continue;
    }
        }

      
  }
}


  //NON ADVANCED--------------------------
public static function nonadvanced($filename,$sl){

  $lines = file($filename);

$line_count=0;


$count=sizeof($lines); 

$it=$count/4;

$count=1;

for($in=0;$in<$it;$in=$in+4)
{
   $usnline=trim($lines[$in]);
   $seriesline=trim($lines[$in+1]);
   $qnoline=trim($lines[$in+2]);
   $ansline=trim($lines[$in+3]);
 //DELETE
   $usnlinearray=explode("=",$usnline);   //.  No.=9277048-D
   
   //echo json_encode($usnlinearray);
   $current_usn_with_if_flag=$usnlinearray[1]; // 9277048-D
   $usn_with_flag_array=explode("-",$current_usn_with_if_flag);


   $current_usn=$usn_with_flag_array[0];



         if(isset($usn_with_flag_array[1]))
          {
              $current_usn_flag=$usn_with_flag_array[1];   // FLAG   =>  D,   A  or blank
          }
          else
          {
              $current_usn_flag="blank";  
          }



   $current_usn_flag=trim($current_usn_flag);
   //echo "curf=".$current_usn_flag;echo "<br>";//exit;
   $only_usn=$usn_with_flag_array[0];
   $current_usn=$only_usn;
// return 
  if(substr(Auth::id(),2)==trim($current_usn)){
    if($current_usn_flag=="blank"){
    return [
    "Flag"=>$current_usn_flag,
    "USN"=>$current_usn,
    "Line"=>$ansline,
          ];
        }
     elseif($current_usn_flag=="A"){
  $approve=DB::table('101_mismatch_approval_request')->where('STUD_ID',Auth::id())->where('test_sl',$sl)->where('status',1)->get();
  if(count($approve)!=0){
    return [
        "Flag"=>$current_usn_flag,
        "USN"=>$current_usn,
        "Line"=>$ansline,
              ];
            }
            else{
              continue;
            }
       }
    else{
      continue;
    }
      }

   }

   return array();
  }

}
