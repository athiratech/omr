<?php

namespace App\BaseModels;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use App\Token;
use App\Ipmpc;
use Auth;

class Student extends Authenticatable
{
    //
    
    use Notifiable;
    protected $table = 't_student';
    protected $primaryKey = 'ADM_NO';
    private static $test_types=[];

     public function program()
    {
        return $this->hasOne('App\BaseModels\Program','PROGRAM_ID', 'PROGRAM_ID');
    }
     public function parent()
    {
        return $this->hasOne('App\BaseModels\Parents','ADM_NO', 'ADM_NO');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

     public function tokens() {
        return $this->hasMany(Token::class, 'user_id', 'ADM_NO');
    }
    public function stream()
    {
        return $this->hasOne('App\BaseModels\Stream','STREAM_ID','STREAM_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function class_year()
    {
        return $this->hasOne('App\BaseModels\StudyClass','CLASS_ID','CLASS_ID');
    }

    public function campus()
    {
        return $this->hasOne('App\BaseModels\Campus','CAMPUS_ID','CAMPUS_ID');
    }

    public function section()
    {
        return $this->hasOne('App\BaseModels\Section','SECTION_ID','SECTION_ID');
    }

    public static function profile($stud_id){
        return static::where('ADM_NO','=',$stud_id)->with('program','stream','class_year','campus','section','parent')->get();

    }


    public static function written_tests($data){

        $test_types=DB::table('0_test_types')->where('test_type_id',$data->test_type_id)->get();
     //    foreach($test_types as $value){
            
          $query[$test_types[0]->test_type_name] = DB::select("select ipd.Exam_name,ipd.Exam_id,
                         IF(ipd.path!='', 'True', 'False') as Is_Result_Uploaded from IP_Exam_Details ipd left join IP_Exam_Conducted_For ecf on ipd.exam_id=ecf.Exam_id inner join (select t.CAMPUS_ID,ct.GROUP_ID,pn.PROGRAM_ID,t.class_id,ts.STREAM_ID from t_student t left join t_course_track ct on t.COURSE_TRACK_ID=ct.COURSE_TRACK_ID left join t_study_class sc on sc.class_id=t.class_id left join t_program_name pn on t.PROGRAM_ID=pn.PROGRAM_ID left join t_stream ts on ts.STREAM_ID=t.stream_id WHERE t.adm_no='".Auth::id()."') ds on ecf.classyear_id=ds.class_id and ecf.stream_id=ds.stream_id and ecf.program_id=ds.program_id and ecf.exam_id=ipd.exam_id and ds.group_id = ecf.group_id and ipd.Test_type_id='".$data->test_type_id."'"
                    );   

        // }
          $object = new \stdClass(); 
          $object->EXAM_ID = $query[$test_types[0]->test_type_name][0]->Exam_id;
          $object->test_type_id = $data->test_type_id;
          $query[$test_types[0]->test_type_name][0]->Percentages=Ipmpc::markDetails($object)["OverAll_Averages"];

           
          // echo $sum;


          $query[$test_types[0]->test_type_name][0]->total=Ipmpc::markDetails($object)["Add"];
          // $query[$test_types[0]->test_type_name][0]->Result=Ipmpc::markDetails($object)["Result"];
 
       return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            'Details'=>$query,
                            // 'MarkDetails'=>Ipmpc::markDetails($object)["Result"],
                            // 'OverAll_Averages'=>Ipmpc::markDetails($object)["OverAll_Averages"],
                    ];

    }


    public static function written_tests_date($data){
        
            $dateValue = strtotime($data->test_date);

            $yr = date("m-Y", $dateValue); 
                    $test_types=DB::table('0_test_types')->where('test_type_id',$data->test_type_id)->get();
                      $query[$test_types[0]->test_type_name] = DB::select("select ipd.Exam_name,ipd.exam_id,
                         IF(ipd.path!='', 'True', 'False') as Is_Result_Uploaded from IP_Exam_Details ipd left join IP_Exam_Conducted_For ecf on ipd.exam_id=ecf.Exam_id inner join (select t.CAMPUS_ID,ct.GROUP_ID,pn.PROGRAM_ID,t.class_id,ts.STREAM_ID from t_student t left join t_course_track ct on t.COURSE_TRACK_ID=ct.COURSE_TRACK_ID left join t_study_class sc on sc.class_id=t.class_id left join t_program_name pn on t.PROGRAM_ID=pn.PROGRAM_ID left join t_stream ts on ts.STREAM_ID=t.stream_id WHERE t.adm_no='".Auth::id()."') ds on ecf.classyear_id=ds.class_id and ecf.stream_id=ds.stream_id and ecf.program_id=ds.program_id and ecf.exam_id=ipd.exam_id and ds.group_id = ecf.group_id and ipd.Test_type_id='".$data->test_type_id."' and ipd.Date_exam LIKE '%".$yr."'");   
 
     $object = new \stdClass(); 
          $object->EXAM_ID = $query[$test_types[0]->test_type_name][0]->exam_id;
          $object->test_type_id = $data->test_type_id;
   
          $query[$test_types[0]->test_type_name][0]->Percentages=Ipmpc::markDetails($object)["OverAll_Averages"];

           
          // echo $sum;


          $query[$test_types[0]->test_type_name][0]->total=Ipmpc::markDetails($object)["Add"];
          // $query[$test_types[0]->test_type_name][0]->Result=Ipmpc::markDetails($object)["Result"];
 
       return [
                        'Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                            'Details'=>$query,
                            // 'MarkDetails'=>Ipmpc::markDetails($object)["Result"],
                            // 'OverAll_Averages'=>Ipmpc::markDetails($object)["OverAll_Averages"],
                    ];


    }




}
