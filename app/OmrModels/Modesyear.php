<?php

namespace App\OmrModels;
use DB;
use App\BaseModels\Student;
use Illuminate\Database\Eloquent\Model;
include_once($_SERVER['DOCUMENT_ROOT'].'/sri_chaitanya/Exam_Admin/3_view_created_exam/z_ias_format.php');

class Modesyear extends Model
{
  protected $table='0_test_modes_years';
  public $timestamps=false;
  
    public static function exam_info($data){
    	$exam=Exam::where('sl',$data->exam_id)->get();
    	if($exam[0]->omr_scanning_type=="advanced"){
	$response_array=ias_model_year_paper($exam[0]->model_year,$exam[0]->paper);
	// return $response_array;
		}
		else{
	$response_array[6]=$exam[0]->to_from_range;
	$response_array[5]=$exam[0]->mark_file_long_string;
		// return $response_array;
		}
	$mark_file_long_string=$response_array[5];
	$to_from_range=$response_array[6];
	$all_sub_marks_array=static::get_marks_string($to_from_range,$mark_file_long_string);
       return $all_sub_marks_array;
    }

public static function get_marks_string($to_from_range,$mark_file_long_string) //CRB not required
{
	$to_from_range_array=explode(",",$to_from_range);
	$mark_file_array=explode(",",$mark_file_long_string);
	// return $mark_file_array;
	$to_from_range_array=explode(",",$to_from_range);
	$no_of_sub=sizeof($to_from_range_array);

	//extend marks string
	$loop_count=sizeof(explode(",",$mark_file_long_string))/4;
	$all_sub_marks_array=array();
	$from=0;
	$to=1;
	$mark=2;

	for($i=1;$i<=$loop_count;$i++)
	{ $one=$mark_file_array[$from];
	  $two=$mark_file_array[$to];
	  $this_mark=$mark_file_array[$mark];
	    for($m=$one;$m<=$two;$m++)
	    {
	       $all_sub_marks_array[]=$this_mark;

	    }
	$from=$from+4;
	$to=$to+4;
	$mark=$mark+4;
	}
	return $all_sub_marks_array;
}
}
