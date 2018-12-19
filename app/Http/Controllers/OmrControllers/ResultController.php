<?php

namespace App\Http\Controllers\OmrControllers;

use App\OmrModels\Result;
use App\OmrModels\Exam;
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
}
