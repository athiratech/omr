<?php

namespace App\Http\Controllers\OmrControllers;

use App\OmrModels\Result;
use App\OmrModels\Exam;
use App\OmrModels\Type;
use App\OmrModels\Modesyear;
use App\OmrModels\Subject;
use  File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function login(Request $request)
    {
    $res=Result::login($request);
      return $res;      
    }
    public function total_percentage(Request $request){
        $res=Exam::type($request);
        return $res;
    }
    public function test_type_list(Request $request){
        $res=Exam::test_type_list($request);
        return $res;
    }
    public function examlist(Request $request){
        $res=Exam::examlist($request);
        return $res;
    }
    public function AnswerDetails(Request $request){
        $res=Exam::AnswerDetails($request);
        return $res;
    }
    public function exam_info(Request $request){
        $res=Modesyear::exam_info($request);
        return $res;
    }
    public function teacher_exam_info(Request $request){
        $res=Type::teacher_exam_info($request);
        return $res;
    }
    public function teacher_percentage(Request $request){
        $change="p";
        $res=Subject::teacher_percentage($request,$change);
        return $res;
    }
    public function teacher_examlist(Request $request){
          $change="e";
        $res=Subject::teacher_percentage($request,$change);
        return $res;
    }
    public function teacher_studentlist(Request $request){
          $change="s";
        $res=Subject::teacher_percentage($request,$change);
        return $res;
    }
}
