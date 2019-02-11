<?php

namespace App\OmrModels;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Auth;
use App\Http\Requests\LoginValidation;
use Carbon\Carbon;
use App\Employee;
use App\OmrModels\Parent_details;
use App\BaseModels\Student;
use App\BaseModels\Program;
use App\BaseModels\StudyClass;
use App\BaseModels\Campus;
use App\OmrModels\Tparent;
use App\Token;
use App\OmrModels\User;
use Illuminate\Http\Request;
use App\OmrModels\Exam;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\ExamCollection;
use DB;
use File;
use Illuminate\Database\Eloquent\Model;

class Result extends Authenticatable
{
   use Notifiable;
   public static function login($data){
         $msg="This is old token";
         $campus="";
         //Login with three driver for different login
        if($data->user_type=="employee")
        {
        Auth::attempt([ 'PAYROLL_ID' => $data->get('USERNAME'), 'password' => $data->get('PASSWORD') ]);
        }
        if($data->user_type=="student")
        {
        Auth::guard('t_student')->attempt([ 'ADM_NO' => $data->get('USERNAME'), 'password' => $data->get('PASSWORD') ]);
        }
        if($data->user_type=="parent")
        {
        Auth::guard('tparent')->attempt([ 'ADM_NO' => $data->get('USERNAME'), 'password' => $data->get('PASSWORD') ]);
        }
      if(Auth::id() || Auth::guard('t_student')->id()|| Auth::guard('tparent')->id()){
         $c=array();
            if(Auth::id()){
                $client = Employee::
                                join('t_campus as tc','employees.CAMPUS_ID','=','tc.CAMPUS_ID')
                                ->join('t_employee as te','te.PAYROLL_ID','=','employees.payroll_id')
                              ->find(Auth::id());
                $uc=$client->tokens()->delete();
                $campus=$client->CAMPUS_NAME;
                $details=[
                    'USER_NAME'=>ucfirst(strtolower($client->USER_NAME)),
                    'CAMPUS_NAME'=>ucfirst(strtolower($campus)),
                    'SURNAME'=>ucfirst(strtolower($client->SURNAME)),
                    'NAME'=>ucfirst(strtolower($client->NAME)),
                    'USER'=>'EMPLOYEE',
                    'DEPARTMENT'=>Auth::user()->SUBJECT,
                    'DESIGNATION'=>Auth::user()->DESIGNATION,
                    'CAMPUS_ID'=>Auth::user()->CAMPUS_ID
                          ];
            
            $token=Token::whereUser_id(Auth::id())->pluck('access_token');
            $subject=DB::table('IP_Exam_Section as a')
                      ->join('0_subjects as b','a.SUBJECT_ID','b.SUBJECT_ID')
                      ->where('a.EMPLOYEE_ID',Auth::user()->payroll_id)
                      ->select('b.subject_id','b.subject_name')
                      ->distinct()
                      ->get();
           if($uc){
             $msg='Token expired and New Token generated';
           }
            if (!$token->count()) {
                $str=str_random(10);
                $token=Token::create([
                    'user_id'=>Auth::id(),
                    'expiry_time'=>'1',
                    'access_token' => Hash::make($str),
                ]);
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Token'=>$token->access_token,
                            ],
                            'Details'=>$details,
                            'Subject'=>$subject,
                    ];
         
            }
        }
                  elseif(Auth::guard('t_student')->id()){
           $campus=Campus::where('CAMPUS_ID',Auth::guard('t_student')->user()->CAMPUS_ID)->pluck('CAMPUS_NAME');
                $details=[
                    'NAME'=>ucfirst(strtolower(Auth::guard('t_student')->user()->NAME)),
                    'USER_NAME'=>ucfirst(strtolower(Auth::guard('t_student')->user()->USER_NAME)),
                    'SURNAME'=>ucfirst(strtolower(Auth::guard('t_student')->user()->SURNAME)),
                    'USER'=>'STUDENT',
                    'CAMPUS_NAME'=>ucfirst(strtolower($campus[0])),
                    'GROUP'=>Auth::guard('t_student')->user()->GROUP_NAME,
                    // 'SUBJECT'=>Auth::guard('t_student')->user()->SUBJECT,
                    'PROGRAM_NAME'=>Program::where('PROGRAM_ID',Auth::guard('t_student')->user()->PROGRAM_ID)->pluck('PROGRAM_NAME')[0],
                    'CLASS_NAME'=>StudyClass::where('CLASS_ID',Auth::guard('t_student')->user()->CLASS_ID)->pluck('CLASS_NAME')[0],
                    'CAMPUS_ID'=>Auth::guard('t_student')->user()->CAMPUS_ID,
                    'ACADEMIC_YEAR'=>Auth::guard('t_student')->user()->ACADEMIC_YEAR,
                    'YEAR'=>Auth::guard('t_student')->user()->CLASS_ID
                          ];
                $uc=Token::whereUser_id(Auth::guard('t_student')->id())->delete();

                   $token=Token::whereUser_id(Auth::guard('t_student')->id())->pluck('access_token');
         
            if (!$token->count()) {
                $str=str_random(10);
                $token=Token::create([
                    'user_id'=>Auth::guard('t_student')->id(),
                    'expiry_time'=>'1',
                    'access_token' => Hash::make($str),
                ]);
             
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Token'=>$token->access_token,
                            ],
                            'Details'=>$details,
                    ];
         
            }
           }
           else{
            $student=DB::select('SELECT * FROM `t_parent_details` WHERE ADM_NO Like "%'.Auth::guard('tparent')->id().'" LIMIT 1');
            $campus=Campus::where('CAMPUS_ID',Auth::guard('tparent')->user()->CAMPUS_ID)->pluck('CAMPUS_NAME');
            if(count($student)==0)
               return [
                        'Login' => [
                            'response_message'=>"error username or password wrong",
                            'response_code'=>"0"
                           ],
                    ];
             $details=[
                    'NAME'=>ucfirst(strtolower($student[0]->PARENT_NAME)),
                    'USER'=>'PARENT',
                    'CAMPUS_NAME'=>ucfirst(strtolower($campus[0])),
                    'STUDENT'=>ucfirst(strtolower(Auth::guard('tparent')->user()->NAME)),
                    'CAMPUS_ID'=>Auth::guard('tparent')->user()->CAMPUS_ID,
                    'YEAR'=>Auth::guard('tparent')->user()->CLASS_ID
                          ]; 
                $uc=Token::whereUser_id(Auth::guard('tparent')->id())->delete();

                   $token=Token::whereUser_id(Auth::guard('tparent')->id())->pluck('access_token');
               
            if (!$token->count()) {
                $str=str_random(10);
                $token=Token::create([
                    'user_id'=>Auth::guard('tparent')->id(),
                    'expiry_time'=>'1',
                    'access_token' => Hash::make($str),
                ]);
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Token'=>$token->access_token,
                            ],
                            'Details'=>$details,
                          
                    ];
         
            }
           }
           if(Auth::id()){
            $subject=DB::table('IP_Exam_Section as a')
                      ->join('0_subjects as b','a.SUBJECT_ID','b.SUBJECT_ID')
                      ->where('a.EMPLOYEE_ID',Auth::user()->payroll_id)
                      ->select('b.subject_id','b.subject_name')
                      ->distinct()                      
                      ->get();  
                    return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                        'Token'=>$token[0],
                            ],
                        'Details'=>$details,
                        'Subject'=>$subject,
                    ];
                  }
                    else{
                         return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                        'Token'=>$token[0],
                            ],
                        'Details'=>$details, 
                    ];
                  }
        }
        else{
                return [
                        'Login' => [
                            'response_message'=>"error username or password wrong",
                            'response_code'=>"0"
                           ],
                    ];
        }

   }
}
