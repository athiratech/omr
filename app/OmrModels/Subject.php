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
        $output2=array();
        $group_id=$data->group_id;
        $class_id=$data->class_id;
        $stream_id=$data->stream_id;
        $program_id=$data->program_id;
        $subject_id=$data->subject_id;
        $employee_id=Auth::user()->payroll_id;

        $subject_name=DB::table('0_subjects')->where('subject_id',$subject_id)->get()[0]->subject_name;

        $section=DB::table('IP_Exam_Section')
                ->where('EMPLOYEE_ID',Auth::user()->payroll_id)
                ->where('SUBJECT_ID',$subject_id)
                ->pluck('SECTION_ID');



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
                  $exam=static::examstudent($output,$subject_name,$section,$data->exam_id)['ExamList'];   
                  foreach ($exam as $key => $value) {
                    $examlist[$value->test_mode_name][$value->test_type_name]['test_code'][]=$value->test_code;
                    $examlist[$value->test_mode_name][$value->test_type_name]['test_sl'][]=$value->sl;
                    $examlist[$value->test_mode_name][$value->test_type_name]['start_date'][]=$value->start_date;
                  }
                  return $examlist;
                  }               
                   elseif($change=="s"){ 
                  $student=static::examstudent($output,$subject_name,$section,$data->exam_id)['StudentList'];  
                  foreach ($student as $key1 => $value1) {
                    foreach ($value1['obtained'] as $key => $value) {
                      $studentlist[$value->test_code][$value->section_name]['STUD_ID'][]=$value->STUD_ID;
                      $studentlist[$value->test_code][$value->section_name]['STUD_NAME'][]=$value->SURNAME.' '.$value->NAME;
                      $studentlist[$value->test_code][$value->section_name]['STATE_RANK'][]=$value->STATE_RANK;
                      $studentlist[$value->test_code][$value->section_name]['DISTRICT_RANK'][]=$value->DISTRICT_RANK;
                      $studentlist[$value->test_code][$value->section_name]['CITY_RANK'][]=$value->CITY_RANK;
                      $studentlist[$value->test_code][$value->section_name]['CAMP_RANK'][]=$value->CAMP_RANK;
                      $studentlist[$value->test_code][$value->section_name]['SEC_RANK'][]=$value->SEC_RANK;
                      $studentlist[$value->test_code][$value->section_name]['STREAM_RANK'][]=$value->STREAM_RANK;
                      $studentlist[$value->test_code][$value->section_name][strtoupper($subject_name)][]=$value->{strtoupper($subject_name)};
                      $studentlist[$value->test_code][$value->section_name]['max_marks']=$value1['max_marks'];
                      $studentlist[$value->test_code][$value->section_name]['start_date']=$value->start_date;
                    }
                  }
                  return $studentlist;
                }

    }
    public static function examstudent($output,$subject_name,$section,$exam_id){
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
    
}
