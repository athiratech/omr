<?php

namespace App;

use App\Employee;
use Carbon\Carbon;
use App\Campus;
use App\Token;
use App\Exam;
use App\Modesyear;
use App\Mode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Resources\ExamCollection;
use App\Http\Resources\TemplateCollection;
use Illuminate\Support\Facades\Hash;
use File;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table='t_campus';
    protected $primaryKey='CAMPUS_ID';

    public function campusupload($Exam_Id,$Campus_Id,$files){
        if(!$Exam_Id){
            return [
                'Login' => [
                            'response_message'=>"Exam_Id required",
                            'response_code'=>"0"],
        ];
        }
        if(!$Campus_Id){
            return [
                'Login' => [
                            'response_message'=>"Campus_Id required",
                            'response_code'=>"0"],
        ];
        }
        $CAMPUS_NAME=Campus::select('CAMPUS_ID','CAMPUS_NAME')->where('CAMPUS_ID','=',$Campus_Id)->get();

         if ($request->hasFile('files')) 
          {
            ini_set('memory_limit','256M');
            $file = $files;
            $size = $files->getClientSize();
            $check=$file->getClientOriginalExtension();
            if($check=='dat' || $check=='iit')
            {
            $input=$CAMPUS_NAME[0]['CAMPUS_NAME'].'_'.$Exam_Id.'.'.$file->getClientOriginalExtension();
            $input1='temp_'.$CAMPUS_NAME[0]['CAMPUS_ID'].'.'.$file->getClientOriginalExtension();
            $path='/var/www/html/sri_chaitanya/College/3_view_created_exam/uploads/'.$Exam_Id;
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            File::isDirectory($path.'/first') or File::makeDirectory($path.'/first', 0777, true, true);
            $files->move($path.'/first', $input);
            $success = File::copy($path.'/first/'.$input,$path.'/'.$input);
            $success = File::move($path.'/'.$input,$path.'/'.$input1);
            $isupload=Exam::where('sl',$Exam_Id)
                ->update(['is_college_id_mobile_uploaded' => 
                DB::raw("CONCAT(is_college_id_mobile_uploaded,',',".$CAMPUS_NAME[0]['CAMPUS_ID'].")")
            ], ['timestamps' => false]
            );

                return [
                    'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            'Image_Uploaded'=> '/sri_chaitanya/College/3_view_created_exam/uploads/first/'.$input,
                            'size'=>$size
                            ],
                                
                                
                            ];

                        }
                        else{
                            return [
                'Login' => [
                            'response_message'=>".dat or .iit files are acceptable",
                            'response_code'=>"0"],
        ];
                        }
            }
            else{
                return [
                'Login' => [
                            'response_message'=>"files required",
                            'response_code'=>"0"],
        ];
            }
    }
}
