<?php

namespace App\OmrModels;
use Auth;
use DB;

use Illuminate\Database\Eloquent\Model;
include_once($_SERVER['DOCUMENT_ROOT'].'/sri_chaitanya/Exam_Admin/3_view_created_exam/z_ias_format.php');

class Subject extends Model
{
  protected $table='0_subjects';
  public $timestamps=false;

    public static function teacher_percentage($data,$change){
        $studentlist=array();
        $studentlist1=array();
        $output1=array();
        $output=array();
        $examlist=array();
        $output2=array();
        $group_id=$data->group_id;
        $class_id=$data->class_id;
        $stream_id=$data->stream_id;
        $program_id=$data->program_id;
        $subject_id=$data->subject_id;
        $employee_id=Auth::user()->payroll_id;
        $exam_id=$data->exam_id;
        $test_type=$data->test_type;
        $mode=$data->mode_id;
        if(isset($data->date))
        $date=$data->date;
        else
          $date=date("Y-m");

        $subject_name=DB::table('0_subjects')->where('subject_id',$subject_id)->pluck('subject_name')[0];

        $section=DB::table('IP_Exam_Section')
                ->where('EMPLOYEE_ID',Auth::user()->payroll_id)
                ->where('SUBJECT_ID',$subject_id)
                ->pluck('SECTION_ID');

   if(isset($exam_id))
           $output=DB::table('1_exam_gcsp_id as eg')
                    ->join('1_exam_admin_create_exam as e','e.sl','=','eg.test_sl')
                    ->join('0_test_modes as tm','tm.test_mode_id','=','e.mode')
                    ->join('t_campus as tc','tc.STATE_ID','=','e.state_id')
                    ->join('employees as em','em.CAMPUS_ID','=','tc.CAMPUS_ID')
                    ->where('eg.GROUP_ID',$group_id)
                    ->where('eg.STREAM_ID',$stream_id)
                    ->where('eg.CLASS_ID',$class_id)
                    ->where('eg.PROGRAM_ID',$program_id)
                    ->where('e.result_generated1_no0',1)
                    ->where('em.CAMPUS_ID',Auth::user()->CAMPUS_ID)
                    ->whereRaw('FIND_IN_SET(?,tm.test_mode_subjects)', [$subject_id])
                    ->where('eg.test_sl',$exam_id)
                    ->select('eg.test_sl','tm.marks_upload_final_table_name','e.max_marks','e.model_year','e.paper','e.omr_scanning_type','tm.test_mode_name','tm.test_mode_id')->get();
          else
        $output=DB::table('1_exam_gcsp_id as eg')
                    ->join('1_exam_admin_create_exam as e','e.sl','=','eg.test_sl')
                    ->join('0_test_modes as tm','tm.test_mode_id','=','e.mode')
                    ->join('t_campus as tc','tc.STATE_ID','=','e.state_id')
                    ->join('employees as em','em.CAMPUS_ID','=','tc.CAMPUS_ID')
                    ->where('eg.GROUP_ID',$group_id)
                    ->where('eg.STREAM_ID',$stream_id)
                    ->where('eg.CLASS_ID',$class_id)
                    ->where('eg.PROGRAM_ID',$program_id)
                    ->where('e.result_generated1_no0',1)
                    ->where('em.CAMPUS_ID',Auth::user()->CAMPUS_ID)
                    ->whereRaw('FIND_IN_SET(?,tm.test_mode_subjects)', [$subject_id])
                    ->select('eg.test_sl','tm.marks_upload_final_table_name','e.max_marks','e.model_year','e.paper','e.omr_scanning_type','tm.test_mode_name','tm.test_mode_id','tc.CAMPUS_ID')->get();
 // return \Request::segment(2);
                  $page=$data->page;

                 if($change=="p"){
                  if(isset($data->exam_id))
                  return static::examstudent($output,$subject_name,$section,$data->exam_id,$data->section_id,$test_type,$mode,$date,$page)['Result'];  
                else
                   return static::examstudent($output,$subject_name,$section,"0",$data->section_id,$test_type,$mode,$date,$page)['Result'];  
                }
                 elseif($change=="e"){
                  $test=array();
                  $block_no=array();
                  $exam=static::examstudent($output,$subject_name,$section,$data->exam_id,$data->section_id,$test_type,$mode,$date,$page)['ExamList'];  
                  // return $exam;
                  // return [

                  //    'Login' => [
                  //           'response_message'=>"success",
                  //           'response_code'=>"1",
                  //           ],
                  //   "Data"=>$exam,
                  //       ];

                        $block_no=DB::table('Result_Application_BlockCount')->where('API','examlist')->pluck('Block_Count');
                  $max=$block_no[0]*$page;
                  $min=$max-$block_no[0];
                  for ($key=$min; $key <$max; $key++) 
                  {
                    if(isset($exam[$key])){
                    $value=$exam[$key];
                    if(isset($examlist['test_code']))
                    {                  
                      $test[]=$value->test_code;
                      $page=$data->page;
                      if(count($examlist['test_code'])!=$page)
                      {
                        if($mode==$value->test_mode_id && $test_type==$value->test_type_id)
                        {
                            $examlist[$key]['test_code']=$value->test_code;
                            $data1=new \stdClass(); 
                            $data1->exam_id=$value->sl;
                            $examlist[$key]['Total_percentage']=22;
                            // $examlist[$key]['Exam_Info']=Type::teacher_exam_info($data1);
                            //date("d-m-Y", strtotime($originalDate));
                            $examlist[$key]['test_sl']=$value->sl;
                            $examlist[$key]['start_date']=date("d-m-Y",strtotime($value->start_date));
                            $examlist[$key]['test_type_name']=$value->test_type_name;
                            $examlist[$key]['test_mode_name']=$value->test_mode_name;
                          }
                        }
                    }
                    else{
                         if($mode==$value->test_mode_id && $test_type==$value->test_type_id)
                          {
                            $examlist[$key]['test_code']=$value->test_code;
                            $data1=new \stdClass(); 
                            $data1->exam_id=$value->sl;
                            $examlist[$key]['Total_percentage']=21;
                            // $examlist[$key]['Exam_Info']=Type::teacher_exam_info($data1);
                            
                            $examlist[$key]['test_sl']=$value->sl;
                            $examlist[$key]['start_date']=date("d-m-Y",strtotime($value->start_date));
                            $examlist[$key]['test_type_name']=$value->test_type_name;
                            $examlist[$key]['test_mode_name']=$value->test_mode_name;
                          }
                        }
                      }
                  }
                  return [

                     'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            "Exam_date"=>$date,
                    "Totalpage"=>ceil((count($exam))/($block_no[0]+1)),
                    "Block_Count"=>$block_no[0],
                    "Exam"=>$examlist,
                        ];
                  }               
                   elseif($change=="s"){ 
                  $student=static::examstudent($output,$subject_name,$section,$data->exam_id,$data->section_id,$test_type,$mode,$date,$page)['StudentList'];
                  if($student==0)
                     return [
                        'Login' => [
                            'response_message'=>"Exam_Id Required",
                            'response_code'=>"0"
                           ],
                    ]; 
                    if(count($student)==0)
                     return [
                        'Login' => [
                            'response_message'=>"Student Record Not found for this Exam_Id",
                            'response_code'=>"0"
                           ],
                    ];
                    if(!isset($student[0]))
                       return [
                        'Login' => [
                            'response_message'=>"Student Record Not found for this Subject_id",
                            'response_code'=>"0"
                           ],
                    ];
                  $block_no=DB::table('Result_Application_BlockCount')->where('API','teacher_studentlist')->pluck('Block_Count');
                  $page=$data->page;
                  $max=$block_no[0]*$page;
                  $min=$max-$block_no[0];
                  $totalpage=count($student[0]['obtained'])/$block_no[0];
                  for ($j=0; $j<count($student); $j++) {
                  for ($i=$min; $i <$max; $i++) {
                    if(isset($student[$j]['obtained'][$i]->test_code)){

                      $studentlist1['max_marks']=$student[$j]['max_marks'];
                      $studentlist[$i]['start_date']=$student[$j]['obtained'][$i]->start_date;
                      $studentlist1['test_code']=$student[$j]['obtained'][$i]->test_code;
                      $studentlist1['section_name']=$student[$j]['obtained'][$i]->section_name;
                      $studentlist[$i]['STUD_ID']=$student[$j]['obtained'][$i]->STUD_ID;
                      $studentlist[$i]['STUD_NAME']=$student[$j]['obtained'][$i]->SURNAME.' '.$student[$j]['obtained'][$i]->NAME;
                      $studentlist[$i]['PROGRAM_RANK']=$student[$j]['obtained'][$i]->PROGRAM_RANK;
                      $studentlist[$i]['STREAM_RANK']=$student[$j]['obtained'][$i]->STREAM_RANK;
                      $studentlist[$i]['SEC_RANK']=$student[$j]['obtained'][$i]->SEC_RANK;
                      $studentlist[$i]['CAMP_RANK']=$student[$j]['obtained'][$i]->CAMP_RANK;
                      $studentlist[$i]['CITY_RANK']=$student[$j]['obtained'][$i]->CITY_RANK;
                      $studentlist[$i]['DISTRICT_RANK']=$student[$j]['obtained'][$i]->DISTRICT_RANK;
                      $studentlist[$i]['STATE_RANK']=$student[$j]['obtained'][$i]->STATE_RANK;
                      $studentlist[$i]['ALL_INDIA_RANK']=$student[$j]['obtained'][$i]->ALL_INDIA_RANK;
                      $studentlist[$i]['TOTAL']=$student[$j]['obtained'][$i]->{strtoupper($subject_name)}.'/'.$student[$j]['max_marks'];
                      // $studentlist[$i][strtoupper($subject_name)]=$student[$j]['obtained'][$i]->{strtoupper($subject_name)};
                      

                    $data1=new \stdClass(); 
                    $data1->exam_id=$data->exam_id;
                    $data1->STUD_ID=$student[$j]['obtained'][$i]->STUD_ID;
                      // $studentlist[$i]['Exam_Info']=Modesyear::exam_info($data1,1);
                    }}
                  }
                  if(empty($studentlist1))
                    return [

                     'Login' => [
                            'response_message'=>"exam_id required",
                            'response_code'=>"0",
                            ],
                          ];
                  return [

                     'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                    "Totalpage"=>ceil($totalpage),
                    "Block_Count"=>$block_no[0],
                    // "Max_Marks"=>$studentlist1['max_marks'],
                    // "Start_Date"=>$studentlist1['start_date'],
                    // "Test_Code"=>$studentlist1['test_code'],
                    // "Section_Name"=>$studentlist1['section_name'],
                    "Data"=>array_values($studentlist)
                  ];
                }

    }
    public static function examstudent($output,$subject_name,$section,$exam_id,$section_id,$test_type,$mode,$date,$page)
    {
        $examlist=array();
        $studentlist=array();
            $result=array();
            foreach ($output as $key => $value) 
            {
           $correctans=Exam::join('0_test_types as ty','1_exam_admin_create_exam.test_type','=','ty.test_type_id')
                        ->join('0_test_modes as tm','tm.test_mode_id','1_exam_admin_create_exam.mode')
                         ->select('1_exam_admin_create_exam.model_year','1_exam_admin_create_exam.paper','1_exam_admin_create_exam.omr_scanning_type','1_exam_admin_create_exam.to_from_range','1_exam_admin_create_exam.subject_string_final','1_exam_admin_create_exam.sl','1_exam_admin_create_exam.test_code','tm.test_mode_id','ty.test_type_id','tm.test_mode_name','ty.test_type_name','1_exam_admin_create_exam.start_date')
                        ;
                        if(isset($page))
                         $correctans->where('sl',$value->test_sl);

            if($test_type!="")
            $correctans->where('ty.test_type_id',$test_type);

            if($mode!="")
            $correctans->where('1_exam_admin_create_exam.mode',$mode);
            if(isset($date))
            $correctans->where('1_exam_admin_create_exam.start_date','like',$date.'%');

               $correctans=$correctans->get();
          if(empty($correctans[0]))
            return ['Result'=>['Login' => [
                            'response_message'=>"No record found for this information",
                            'response_code'=>"0",
                            ]],'ExamList'=>$examlist
                            ,'StudentList'=>['Login' => [
                            'response_message'=>"No record found for this information",
                            'response_code'=>"0",
                            ]],
                          ];
               
               // if(isset($correctans))
           $examlist[]=$correctans[0];
         // else
         //  $examlist[]="";

           if($correctans[0]->omr_scanning_type=='advanced')
           {
             $filedata=ias_model_year_paper($correctans[0]->model_year,$correctans[0]->paper);    
           }
            else
            {
              $filedata[0]=$correctans[0]->subject_string_final;
              foreach (explode(',',$filedata[0]) as $keyu => $valueu) 
              {
                $arr[]=DB::table('0_subjects')->where('subject_id',$valueu)->pluck('subject_name')[0];
              }
            }

            $b[]=explode(",",$value->max_marks);
             
            if(is_array($filedata[0])){
              $table="101_MPC_MARKS";
            $a[]=array_values(array_filter($filedata[0]));
            $max[]=array_combine((array)$a[$key],$b[$key]);
            $list=$max[$key][strtoupper($subject_name)];

              }
            else{
              $table="102_BIPC_MARKS";

              foreach ($arr as $keyh => $valueh) {
                $a[]=$arr[$keyh];
                if(isset($arr[$keyh]) && isset($b[0][$keyh]))
                $max[$arr[$keyh]]=$b[0][$keyh];
              }
               if(!isset($max[$subject_name]))
                  return ['Result'=>['Login' => [
                            'response_message'=>"No record found for this information",
                            'response_code'=>"0",
                            ]],'ExamList'=>$examlist
                            ,'StudentList'=>['Login' => [
                            'response_message'=>"No record found for this information",
                            'response_code'=>"0",
                            ]],
                          ];
            $list=$max[$subject_name];

            }
            $list1=strtoupper($subject_name);

            foreach ($section as $value1) {
             $section1[] = $value1;
                }
                if(empty($section1))
                  return ['Result'=>['Login' => [
                            'response_message'=>"No record found for this information",
                            'response_code'=>"0",
                            ]],'ExamList'=>$examlist
                            ,'StudentList'=>['Login' => [
                            'response_message'=>"No record found for this information",
                            'response_code'=>"0",
                            ]],
                          ];
              if($exam_id !="0")
            $res=DB::select("select (".$list1."/".$list.")*100 as percentage,a.STUD_ID,test_code_sl_id,st.SECTION_ID,".$list1.",ts.section_name,test_code,start_date,PROGRAM_RANK,STREAM_RANK,SEC_RANK,CAMP_RANK,CITY_RANK,DISTRICT_RANK,STATE_RANK,ALL_INDIA_RANK,st.NAME,st.SURNAME from ".$table."  as `a` inner join `t_student` as `st` on `st`.`ADM_NO` = `a`.`STUD_ID` inner join t_college_section as ts on ts.SECTION_ID=st.SECTION_ID inner join 1_exam_admin_create_exam as ex on ex.sl=test_code_sl_id where `test_code_sl_id` = '".$exam_id."' and `st`.`SECTION_ID`='".$section_id."'"); 
          else
          $res=DB::select("select (".$list1."/".$list.")*100 as percentage,a.STUD_ID,test_code_sl_id,st.SECTION_ID,".$list1.",ts.section_name,test_code,start_date,PROGRAM_RANK,STREAM_RANK,SEC_RANK,CAMP_RANK,CITY_RANK,DISTRICT_RANK,STATE_RANK,ALL_INDIA_RANK,st.NAME,st.SURNAME from ".$table." as `a` inner join `t_student` as `st` on `st`.`ADM_NO` = `a`.`STUD_ID` inner join t_college_section as ts on ts.SECTION_ID=st.SECTION_ID inner join 1_exam_admin_create_exam as ex on ex.sl=test_code_sl_id where `test_code_sl_id` = '".$value->test_sl."' and `st`.`SECTION_ID` in (".implode(',',$section1).")");

           $studentlist[$key]['obtained']=$res;
           $studentlist[$key]['max_marks']=$list;


            $addition=0;
            foreach ($res as $key2 => $value2) {
                $addition+=$value2->percentage;
            }
            if(count($res))
                if(isset($result[$value->test_mode_name])){
                     $result[$value->test_mode_name]=($result[$value->test_mode_name]+($addition/count($res)))/2;
                     $results[$value->test_mode_name]=$value->test_mode_id;
                   }
                 else{
                     $result[$value->test_mode_name]=$addition/count($res);
                     $results[$value->test_mode_name]=$value->test_mode_id;
                   }
            }     
            $a=0; 
            $final=array();     
            foreach ($result as $keyl => $valuel) {
             $final[$a]['Mode_name']=$keyl; 
             $final[$a]['Mode_id']=$results[$keyl]; 
             $final[$a]['Percentage']=number_format((float) $valuel, '2', '.', ''); 
             $a++;
            }
        return [
          "Result"=>['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
            "data"=>$final],
          "ExamList"=>array_values($examlist),
          "StudentList"=>$studentlist,
        ];       

    }
    public static function sectionlist($data)
    {
      $result=DB::table('IP_Exam_Section as is')
                    ->join('t_college_section as cs','is.SECTION_ID','=','cs.SECTION_ID')
                    ->where('is.EMPLOYEE_ID',Auth::user()->payroll_id)
                    ->select('is.SECTION_ID','cs.section_name')
                    ->get();
      return ['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
        'data'=>$result];

    }
    
}
