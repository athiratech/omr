<?php

namespace App\Http\Controllers;

use App\Result;
use App\Exam;
use Illuminate\Http\Request;

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
    public function examlist(Request $request){
        $res=Exam::examlist($request);
        return $res;
    }
}
