<?php

namespace App\BaseModels;
use Illuminate\Http\Request;
use App\BaseModels\Student;
use App\BaseModels\Parents;
use App\Employee;
use App\Http\Resources\Profile as ProfileResource;
use App\Http\Resources\Parents as ParentResource;
use App\Http\Resources\Employee as EmployeeResource;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    //
    protected $table = 't_parent_details';
    protected $primaryKey = 'ROW_ID';
     public function campus()
    {
        return $this->hasOne('App\BaseModels\Student','ADM_NO', 'ADM_NO');
    }

     public static function profile($parent_id){

        return static::where('ADM_NO','=',$parent_id)->with('campus')->get();

    }
    public static function profile_details($data){
        
        if($data->user_type=="student"){
        $result=new ProfileResource(Student::profile($data->USERID));
         return [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Details'=>$result,
                ];
            }
        if($data->user_type=="parent"){
        $result=new ProfileResource(Student::profile($data->USERID));
         return [
                    'Login' => [
                        'response_message'=>"success",
                        'response_code'=>"1",
                        ],
                        'Details'=>$result,
                ];
            }
        if($data->user_type=="employee"){
         $result=new EmployeeResource(\App\Employee::profile($data->USERID));

          return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            'Details'=>$result,
                    ];
    }
}
}