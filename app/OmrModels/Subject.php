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

        $subject_name=DB::table('0_subjects')->where('subject_id',$subject_id)->get()[0]->subject_name;

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
                    ->select('eg.test_sl','tm.marks_upload_final_table_name','e.max_marks','e.model_year','e.paper','e.omr_scanning_type','tm.test_mode_name')->get();
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
                    ->select('eg.test_sl','tm.marks_upload_final_table_name','e.max_marks','e.model_year','e.paper','e.omr_scanning_type','tm.test_mode_name')->get();

                 if($change=="p"){
                  return static::examstudent($output,$subject_name,$section,$data->exam_id)['Result'];  
                }
                 elseif($change=="e"){
                  $test=array();
                  $block_no=array();
                  $exam=static::examstudent($output,$subject_name,$section,$data->exam_id)['ExamList'];   
                  foreach ($exam as $key => $value) {
                    
                    if(isset($examlist[$value->test_mode_name][$value->test_type_name]['test_code'])){
                      $block_no=DB::table('Result_Application_BlockCount')->where('API','teacher_examlist')->pluck('Block_Count');
                      $test[]=$value->test_code;
                      $page=$data->page;
                      if(count($examlist[$value->test_mode_name][$value->test_type_name]['test_code'])!=$page)
                      {
                      $examlist[$value->test_mode_name][$value->test_type_name]['test_code'][]=$value->test_code;
                    $data1=new \stdClass(); 
                    $data1->exam_id=$value->sl;
                    $examlist[$value->test_mode_name][$value->test_type_name]['Exam_Info'][]=Type::teacher_exam_info($data1);
                    $examlist[$value->test_mode_name][$value->test_type_name]['test_sl'][]=$value->sl;
                    $examlist[$value->test_mode_name][$value->test_type_name]['start_date'][]=$value->start_date;
                        }
                    }
                    else{
                    $examlist[$value->test_mode_name][$value->test_type_name]['test_code'][]=$value->test_code;
                    $data1=new \stdClass(); 
                    $data1->exam_id=$value->sl;
                    $examlist[$value->test_mode_name][$value->test_type_name]['Exam_Info'][]=Type::teacher_exam_info($data1);
                    $examlist[$value->test_mode_name][$value->test_type_name]['test_sl'][]=$value->sl;
                    $examlist[$value->test_mode_name][$value->test_type_name]['start_date'][]=$value->start_date;
                        }
                  }
                  return [
                    "Totalpage"=>((count($test)+1)/$block_no[0]),
                    "Block_Count"=>$block_no[0],
                    "Exam"=>$examlist,
                        ];
                  }               
                   elseif($change=="s"){ 
                  $student=static::examstudent($output,$subject_name,$section,$data->exam_id)['StudentList'];
                  if($student==0)
                     return [
                        'Login' => [
                            'response_message'=>"Exam_Id Required",
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
                  // for ($i=0; $i <count($student[$j]['obtained']); $i++) {
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['STUD_ID'][]=$student[$j]['obtained'][$i]->STUD_ID;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['STUD_NAME'][]=$student[$j]['obtained'][$i]->SURNAME.' '.$student[$j]['obtained'][$i]->NAME;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['STATE_RANK'][]=$student[$j]['obtained'][$i]->STATE_RANK;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['DISTRICT_RANK'][]=$student[$j]['obtained'][$i]->DISTRICT_RANK;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['CITY_RANK'][]=$student[$j]['obtained'][$i]->CITY_RANK;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['CAMP_RANK'][]=$student[$j]['obtained'][$i]->CAMP_RANK;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['SEC_RANK'][]=$student[$j]['obtained'][$i]->SEC_RANK;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['STREAM_RANK'][]=$student[$j]['obtained'][$i]->STREAM_RANK;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name][strtoupper($subject_name)][]=$student[$j]['obtained'][$i]->{strtoupper($subject_name)};
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['max_marks']=$student[$j]['max_marks'];
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['start_date']=$student[$j]['obtained'][$i]->start_date;

                    $data1=new \stdClass(); 
                    $data1->exam_id=$data->exam_id;
                    $data1->STUD_ID=$student[$j]['obtained'][$i]->STUD_ID;
                      $studentlist[$student[$j]['obtained'][$i]->test_code][$student[$j]['obtained'][$i]->section_name]['Exam_Info'][]=Modesyear::exam_info($data1,1);
                    }}
                  }
                  return [
                    "Totalpage"=>ceil($totalpage),
                    "Block_Count"=>$block_no[0],
                    "List"=>$studentlist];
                }

    }
    public static function examstudent($output,$subject_name,$section,$exam_id){

        $examlist=array();
        $studentlist=array();
            $result=array();
            foreach ($output as $key => $value) 
            {
           $correctans=DB::table('1_exam_admin_create_exam as e')
                        ->join('0_test_types as ty','e.test_type','=','ty.test_type_id')
                        ->join('0_test_modes as tm','tm.test_mode_id','e.mode')
                         ->where('sl',$value->test_sl)
                         ->select('e.model_year','e.paper','e.omr_scanning_type','e.to_from_range','e.subject_string_final','e.sl','e.test_code','tm.test_mode_id','ty.test_type_id','tm.test_mode_name','ty.test_type_name','e.start_date')
                         ->get();

           $examlist[]=$correctans[0];

           if($correctans[0]->omr_scanning_type=='advanced')
           {
             $filedata=ias_model_year_paper($correctans[0]->model_year,$correctans[0]->paper);    
            }
            else
            {
              $filedata[0]=$correctans[0]->to_from_range;
            }
            if(is_array($filedata[0]))
            $a[]=array_values(array_filter($filedata[0]));
            $b[]=explode(",",$value->max_marks);
            $max[]=array_combine($a[$key],$b[$key]);
            $list=$max[$key][strtoupper($subject_name)];
            $list1=strtoupper($subject_name);

            foreach ($section as $value1) {
             $section1[] = $value1;
                }
                if(!isset($exam_id))
                  return [
                        'StudentList' =>"0"
                    ];
              if(isset($exam_id))
            $res=DB::select("select (".$list1."/".$list.")*100 as percentage,a.STUD_ID,test_code_sl_id,st.SECTION_ID,".$list1.",ts.section_name,test_code,start_date,STATE_RANK,DISTRICT_RANK,CITY_RANK,CAMP_RANK,SEC_RANK,STREAM_RANK,st.NAME,st.SURNAME from `101_MPC_MARKS` as `a` inner join `t_student` as `st` on `st`.`ADM_NO` = `a`.`STUD_ID` inner join t_college_section as ts on ts.SECTION_ID=st.SECTION_ID inner join 1_exam_admin_create_exam as ex on ex.sl=test_code_sl_id where `test_code_sl_id` = '".$exam_id."' and `st`.`SECTION_ID` in (".implode(',',$section1).")"); 
          else
          $res=DB::select("select (".$list1."/".$list.")*100 as percentage,a.STUD_ID,test_code_sl_id,st.SECTION_ID,".$list1.",ts.section_name,test_code,start_date,STATE_RANK,DISTRICT_RANK,CITY_RANK,CAMP_RANK,SEC_RANK,STREAM_RANK,st.NAME,st.SURNAME from `101_MPC_MARKS` as `a` inner join `t_student` as `st` on `st`.`ADM_NO` = `a`.`STUD_ID` inner join t_college_section as ts on ts.SECTION_ID=st.SECTION_ID inner join 1_exam_admin_create_exam as ex on ex.sl=test_code_sl_id where `test_code_sl_id` = '".$value->test_sl."' and `st`.`SECTION_ID` in (".implode(',',$section1).")");

           $studentlist[$key]['obtained']=$res;
           $studentlist[$key]['max_marks']=$list;


            $addition=0;
            foreach ($res as $key2 => $value2) {
                $addition+=$value2->percentage;
            }
            if(count($res))
                if(isset($result[$value->test_mode_name]))
                     $result[$value->test_mode_name]=($result[$value->test_mode_name]+($addition/count($res)))/2;
                 else
                     $result[$value->test_mode_name]=$addition/count($res);
            }           

        return [
          "Result"=>$result,
          "ExamList"=>$examlist,
          "StudentList"=>$studentlist
        ];       

    }
    public static function sectionlist($data)
    {
      $result=DB::table('IP_Exam_Section as is')
                    ->join('t_college_section as cs','is.SECTION_ID','=','cs.SECTION_ID')
                    ->where('is.EMPLOYEE_ID',Auth::user()->payroll_id)
                    ->select('is.SECTION_ID','cs.section_name')
                    ->get();
      return $result;

    }
    
}
