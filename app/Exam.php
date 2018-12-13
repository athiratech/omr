<?php

namespace App;
use Auth;
use DB;
use App\Campus;
use Illuminate\Database\Eloquent\Model;
include_once('z_ias_format.php');
class Exam extends Model
{
  protected $table='1_exam_admin_create_exam';
  protected $primaryKey='sl';
  public $timestamps=false;
  public static function total($data){
  	$mode=array();
  	$calculation="";
  	$marklist=array();	
  	// return base_path();
  	// return Auth::id();
  	$stud=Campus::whereRaw('CAMPUS_ID ='.Auth::user()->CAMPUS_ID)->select('STATE_ID')
  					->get();

  	$exam=static::whereRaw('FIND_IN_SET(?,state_id)', $stud[0]->STATE_ID)
  				->whereRaw('result_generated1_no0 =1')  	  					
  				->select('mode','rank_generated_type','max_marks','sl','test_code','model_year','paper','omr_scanning_type','subject_string_final')
  				;
  	if(isset($data->test_type_id))
  		$exam->where('test_type',$data->test_type_id);
  	else
  		$exam->where('test_type','1');

  	if(isset($data->mode_id))
  		$exam->where('mode',$data->mode_id);
  	if(isset($data->date))
  		$exam->where('start_date','like',$data->date.'%');
  	$exam=$exam->get();

  	foreach ($exam as $key => $value) 
  	{

  		$subject_marks=Mode::whereRaw('test_mode_id ='.$value->mode)
  								->get();

  		$marklist[$key]=DB::table($subject_marks[0]->marks_upload_final_table_name)
  					->whereRaw('STUD_ID ="'.Auth::id().'"')
  					->whereRaw('test_code_sl_id ="'.$value->sl.'"')
            ->select('test_code_sl_id','STUD_ID','TOTAL','STREAM_RANK','PROGRAM_RANK','SEC_RANK','CAMP_RANK','CITY_RANK','DISTRICT_RANK','STATE_RANK','ALL_INDIA_RANK')
  					->get();
  		foreach ($marklist[$key] as $key1 => $value1) {
  			$value1->{'max_marks'}=array_sum(explode(',',$value->max_marks));
  			$value1->{'rank_generated_type'}=explode(',',$value->rank_generated_type);
  			$value1->{'omr_scanning_type'}=$value->omr_scanning_type;
  			if($value->omr_scanning_type=="non_advanced")
  			$value1->{'subject_string_final'}=explode(',',$value->subject_string_final);
  			else
  			$value1->{'subject_string_final'}=array_splice(ias_model_year_paper($value->model_year,$value->paper)[0],1,50);


  			$value1->{'mode_name'}=$subject_marks[0]->test_mode_name;
  		}
  	}

  	for ($i=0; $i <count($marklist) ; $i++) { 

  		if(isset($marklist[$i][0])){
			$calculation=static::calculation1($marklist[$i]);  		
  			if(array_key_exists($marklist[$i][0]->mode_name, $mode)){
  				$sum=$mode[$marklist[$i][0]->mode_name]+$calculation;
  				$mode[$marklist[$i][0]->mode_name]=$sum/2;
  			}
	  		else{
	  		$mode[$marklist[$i][0]->mode_name]=$calculation;  
	  		}  			
  		}  		
  	}
  	return [
  			"Mode"=>$mode,
  			"Marklist"=>$marklist,
  			];
  	
  }
  public static function calculation($data){

  	foreach ($data as $key => $value) {
  		for($i=0;$i<=count($value->max_marks)-1;$i++)
  		{
  			if($value->omr_scanning_type=="advanced"){
  				$subject_name=Subject::where('subject_name','LIKE',$value->subject_string_final[$i]."%")
  							->get();
  						}
  			else{
  				$subject_name=Subject::where('subject_id',$value->subject_string_final[$i])
  							->get();
  			}
  			$percentage[$i]=($value->{strtoupper($subject_name[0]->subject_name)}/$value->max_marks[$i])*100;
  		}
  		$sum = array_sum($percentage)/count($percentage);
  		return $sum;
  	}
  }
  public static function calculation1($data){

  	foreach ($data as $key => $value) {
  		// $sum=array_sum($value->max_marks);
  		return ($value->TOTAL/$value->max_marks)*100;
  	}

  }
  public static function type($data){
  	$out=static::total($data)['Mode'];
  	return $out;
  }
  public static function examlist($data){
    $out=static::total($data)['Marklist'];
    return $out;
  }
  public static function test_type_list($data){
  	$out=DB::table('0_test_types')->select('test_type_id','test_type_name')->get();
  	return $out;
  }
}
