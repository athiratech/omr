<?php
namespace App\Http\Controllers\OmrControllers;
use DB;
use Auth;
use Validator;
use Illuminate\Http\Request;
use App\BaseModels\Group as groups;
use App\BaseModels\StudyClass as class_year;
use App\Http\Resources\Group as GroupResource;
use App\BaseModels\CourseTrack as course_track;
use App\BaseModels\Stream;
use App\BaseModels\Program;
use App\Http\Controllers\Controller;

use App\Http\Resources\GroupCollection;
use App\Http\Resources\StudyClassCollection;
use App\Http\Resources\StreamCollection;
use App\Http\Resources\ProgramCollection;


class BaseController extends Controller
{

    public function groups(Request $request)
    {
        $group=DB::table('IP_Exam_Section as s')->join('t_college_section as tc','s.SECTION_ID','=','tc.section_id')->join('t_course_track as t','t.COURSE_TRACK_ID','=','tc.COURSE_TRACK_ID')->where('s.EMPLOYEE_ID',Auth::user()->payroll_id)->pluck('t.GROUP_ID');
        $query=groups::distinct('GROUP_ID')->orderBy('GROUP_ID');
        if(count($group)!=0)
        $query->whereIn('GROUP_ID',$group);
        $query=$query->get();
        $data=new GroupCollection($query);
        return [
                  
                     'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            "data"=>$data];

    }
    public function class_year_wrt_group(Request $request, $id)
    {
         $class=DB::table('IP_Exam_Section as s')->join('t_college_section as tc','s.SECTION_ID','=','tc.section_id')->join('t_course_track as t','t.COURSE_TRACK_ID','=','tc.COURSE_TRACK_ID')->where('s.EMPLOYEE_ID',Auth::user()->payroll_id)->pluck('t.CLASS_ID');
        $query=class_year::whereIn('CLASS_ID',course_track::where('GROUP_ID',$id)->pluck('CLASS_ID'));
        if(count($class)!=0)
            $query->whereIn('CLASS_ID',$class);
        $query=$query->get();
        $data=new StudyClassCollection($query);  
         return [
                  
                     'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            "data"=>$data];
    
    
    }
    public function stream_wrt_group_class_year(Request $request)
    { 
      
         $stream=DB::table('IP_Exam_Section as s')->join('t_college_section as tc','s.SECTION_ID','=','tc.section_id')->join('t_course_track as t','t.COURSE_TRACK_ID','=','tc.COURSE_TRACK_ID')->where('s.EMPLOYEE_ID',Auth::user()->payroll_id)->pluck('t.STREAM_ID');  
        //Get group and class year to filter required streams
        $group_id= $request->group_id;
        $class_id= $request->class_id;
        $query=Stream::whereIn('STREAM_ID',course_track::distinct('STREAM_ID')
                            ->where('STREAM', '<>','NULL')
                            ->where('GROUP_ID',$group_id)
                            ->where('CLASS_ID',$class_id)->get());
        if(count($stream)!=0)
            $query->whereIn('STREAM_ID',$stream);
        $query=$query->get();
        $data=new StreamCollection($query);
         return [
                  
                     'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            "data"=>$data];

         
    }

    public function programs_wrt_stream_class_year(Request $request)
    {
         $program=DB::table('IP_Exam_Section as s')->join('t_college_section as tc','s.SECTION_ID','=','tc.section_id')->join('t_course_track as t','t.COURSE_TRACK_ID','=','tc.COURSE_TRACK_ID')->where('s.EMPLOYEE_ID',Auth::user()->payroll_id)->pluck('tc.PROGRAM_ID');  

        //Get stream and class id for required programs
        $stream_id= $request->stream_id;
        $class_id= $request->class_id;
        $query=Program::where('STREAM_ID', '=',$stream_id)
            ->where('CLASS_ID',$class_id);
        if(count($program))
        $query->whereIn('PROGRAM_ID',$program);
        $query=$query->get();
        $data=new ProgramCollection($query); 
        return [
                  
                     'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            "data"=>$data];



    }
}
