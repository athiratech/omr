<?php

namespace App\Http\Controllers\OmrControllers;

use App\OmrModels\Result;
use App\OmrModels\Exam;
use App\OmrModels\Type;
use App\OmrModels\Modesyear;
use App\OmrModels\Subject;
use App\Http\Requests\LoginResult;
use App\Http\Requests\Totalpercentage;
use App\Http\Requests\Examlist;

use  File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function login(LoginResult $request)
    {
    $res=Result::login($request);
      return $res;      
    }
    public function total_percentage(Request $request){
        if($request->user_type=='student' || $request->user_type=='parent' ){
        $res=Exam::type($request);
        }
        else{
            $change="p";
        $res=Subject::teacher_percentage($request,$change);
        }

        return $res;
    }
    public function test_type_list(Request $request){
        $res=Exam::test_type_list($request);
        return $res;
    }
    public function examlist(Request $request){
        if($request->user_type=='student'||$request->user_type=='parent')
        {
        $res=Exam::examlist($request);
        }
        else{
             $change="e";
        $res=Subject::teacher_percentage($request,$change);
            }
        return $res;
    }
    public function AnswerDetails(Request $request){
        $res=Exam::AnswerDetails($request);
        return $res;
    }
    public function exam_info(Request $request){
        if($request->user_type=="student" || $request->user_type=="parent")
        $res=Modesyear::exam_info($request,0);
        else
        $res=Type::teacher_exam_info($request);

        return $res;
    }
    public function teacher_studentlist(Request $request){
          $change="s";
        $res=Subject::teacher_percentage($request,$change);
        return $res;
    }
    public function sectionlist(Request $request){
        $res=Subject::sectionlist($request);
        return $res;
    }
}
