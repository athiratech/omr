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

    public static function teacher_percentage($data){
        $output1=array();
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

            foreach ($output as $key => $value) 
            {
           $correctans=Exam::where('sl',$value->test_sl)->select('key_answer_file_long_string as CorrectAnswer','model_year','paper','omr_scanning_type','to_from_range','subject_string_final','sl','test_code')->get();

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

             // $output1[]=DB::table($value->marks_upload_final_table_name.' as a')
             //                ->join('t_student as st','st.ADM_NO','=','a.STUD_ID')
             //                  ->where('test_code_sl_id',$value->test_sl)
             //                  ->whereIn('st.SECTION_ID',$section)
             //                  ->select(strtoupper($subject_name),'a.STUD_ID')
             //                  ->select("MATHEMATICS")
             //                  ->get();
            // $output1[]=$value->test_mode_name;
            $res=DB::select("select (".$list1."/".$list.")*100 as percentage from `101_MPC_MARKS` as `a` inner join `t_student` as `st` on `st`.`ADM_NO` = `a`.`STUD_ID` where `test_code_sl_id` = '".$value->test_sl."' and `st`.`SECTION_ID` in (".implode(',',$section1).")");
            // $output1[]=DB::select("select (".$list1."/".$list.")*100 as percentage,a.STUD_ID,".strtoupper($subject_name)." from `101_MPC_MARKS` as `a` inner join `t_student` as `st` on `st`.`ADM_NO` = `a`.`STUD_ID` where `test_code_sl_id` = '".$value->test_sl."' and `st`.`SECTION_ID` in ('".implode(',',$section1)."')");
                              // select `MATHEMATICS` from `101_MPC_MARKS` as `a` inner join `t_student` as `st` on `st`.`ADM_NO` = `a`.`STUD_ID` where `test_code_sl_id` = 2 and `st`.`SECTION_ID` in (78322, 22103, 22120, 22104, 22113, 37316))
            // $result[]=static::exam_average($output1[$key]);
            // if(isset($result[$value->test_mode_name]))
            //     $result[$value->test_mode_name]=array_merge($result[$value->test_mode_name],$res);

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

        return $result;       
    }

}
