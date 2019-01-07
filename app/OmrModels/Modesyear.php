<?php

namespace App\OmrModels;
use DB;
use Auth;
use App\BaseModels\Student;
use Illuminate\Database\Eloquent\Model;
include_once($_SERVER['DOCUMENT_ROOT'].'/sri_chaitanya/Exam_Admin/3_view_created_exam/z_ias_format.php');

class Modesyear extends Model
{
  protected $table='0_test_modes_years';
  public $timestamps=false;
  
    public static function exam_info($data){
    	$exam=Exam::where('sl',$data->exam_id)->select('key_answer_file_long_string as CorrectAnswer','model_year','paper','omr_scanning_type','to_from_range','subject_string_final','sl','test_code','mode','mark_file_long_string','max_marks')->get();
    	$table=Mode::where('test_mode_id',$exam[0]->mode)->pluck('marks_upload_final_table_name');
    	$result=DB::table($table[0])->where('STUD_ID',Auth::id())->where('test_code_sl_id',$data->exam_id)->get();
    	if(count($result)==0){
    		return [
                        'Login' => [
                            'response_message'=>"Student Record Not Found",
                            'response_code'=>"0"
                           ],
                    ];
    	}
    	if($exam[0]->omr_scanning_type=="advanced"){
	$response_array=ias_model_year_paper($exam[0]->model_year,$exam[0]->paper);
		}
		else{
	$sub=DB::table('0_subjects')->wherein('subject_id',explode(',',$exam[0]->subject_string_final))->pluck('subject_name');
	$response_array[0]=$sub;
	$response_array[1]=array();
	$response_array[6]=$exam[0]->to_from_range;
	$response_array[5]=$exam[0]->mark_file_long_string;
		}
	$mark_file_long_string=$response_array[5];
	$subject=$response_array[0];
	$section=array_filter($response_array[1]);
	$to_from_range=$response_array[6];
	 $type="";
   $correctans=$exam;
   $correct=$correctans[0]['CorrectAnswer'];
	$all_sub_marks_array=static::get_marks_string($to_from_range,$mark_file_long_string,$correct);

      $cal=[
       	"b"=>str_split($result[0]->Result_String),
       	"m"=>$all_sub_marks_array,
       	"r"=>explode(',',$to_from_range),
       	"s"=>$subject,
       	"se"=>$section,
       ];
       $analysis=static::strongweak($cal,$result,$exam[0]->max_marks);
       return static::markcount($cal,$analysis,$result);
    }

	public static function get_marks_string($to_from_range,$mark_file_long_string,$correct) //CRB not required
	{
		$correct=explode(",",$correct);
		foreach($correct as $key=>$value)
		{
		   $otherarray[$key+1] = $value;
		}
		$to_from_range_array=explode(",",$to_from_range);
		$mark_file_array=explode(",",$mark_file_long_string);
		$to_from_range_array=explode(",",$to_from_range);
		$no_of_sub=sizeof($to_from_range_array);
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
		    	if($otherarray[$m]=='X')
		       $all_sub_marks_array[]=0;
		   		else
		       $all_sub_marks_array[]=$this_mark;

		    }
		$from=$from+4;
		$to=$to+4;
		$mark=$mark+4;
		}
		return $all_sub_marks_array;
	}
	public static function markcount($cal,$analysis,$result){
		$extra=array();
		if(is_array($cal['s'])){
		$cal['s']=array_filter($cal['s']);		
		}
		foreach ($cal['s'] as $key => $value) {
			$value=strtoupper($value);
		$extra[$value]=$result[0]->{$value};
		}
		$extra['TOTAL']=$result[0]->TOTAL;

			if(isset($cal['s'][0]))
				$a=0;
			else
				$a=1;

			$b=0;$count=1;$sect=1;$secti="Section1";
			foreach ($cal['r'] as $key => $value) {
				$ra=explode('-',$value);
				$range[]=end($ra);
			}
				$ad=array();$ap=array();$au=array();$ag=array();$aa=array();$ab=array();	
				$subjects=$cal['s'][$a];
				if(!empty($cal['se']))
				$section=$cal['se'][$sect];
				else
				$section="";
				$xt=0;$gt=0;$pt=0;$ut=0;$rt=0;$wt=0;
				$t=array_sum($cal['m']);
		foreach ($cal['b'] as $key => $value) {
			if(!empty($cal['se']))
					if($section!=$cal['se'][$sect])
					{
						if($count==3)
							$count=1;
					$count++;
					$section=$cal['se'][$sect];
					$secti="Section".$count;
					}
				if($range[$b]==$key){
					$b++;
					$a++;
					$subjects=$cal['s'][$a];
				}
			if($value=="X"){
				$ad[$subjects][$secti][$key]=$cal['m'][$key];
			}
			elseif($value=="G"){
				$ag[$subjects][$secti][$key]=$cal['m'][$key];
			}
			elseif($value=="U"){
				$au[$subjects][$secti][$key]=$cal['m'][$key];
			}
			elseif($value=="P"){	
				$ap[$subjects][$secti][$key]=$cal['m'][$key];				
			}
			elseif($value=="R"){
				$aa[$subjects][$secti][$key]=$cal['m'][$key];		
			}
			else{
				$ab[$subjects][$secti][$key]=$cal['m'][$key];			
			}
			$sect++;

		}
		return [
			"Section_Count"=>$count,
			"Subjects"=>$cal['s'],
			"Right"=>$aa,
			"Wrong"=>$ab,
			"Unattempted"=>$au,
			"Partial"=>$ap,
			"Grace"=>$ag,
			"Deleted"=>$ad,
			"Subject_Total"=>$extra,
			"Exam_Total_Mark"=>$t,
			"Analysis"=>$analysis,
		];
	}
	public static function strongweak($cal,$ans,$max){
		/*.......................Subject Wise List............................*/
		if(is_array($cal['s']))
		{
			$cal['s']=array_filter($cal['s']);
			$cal['s']=array_values($cal['s']);
		}
		$a=0;
		$strong="";
		$weak="";
		$sectionstrong=array();
		$sectionweak=array();
		$max_marks=explode(',',$max);
		$perc=array();
		foreach ($cal['s'] as $key => $value) {
			$perc[$value]=($ans[0]->{strtoupper($value)}/$max_marks[$a])*100;
			if($perc[$value]>=75)
				$strong.=','.$value;
			if($perc[$value]<=60)
				$weak.=$value.',';
			$a++;
		}
		/*.......................Section Wise List............................*/
		foreach ($cal['r'] as $key => $value) {
			$ra=explode('-',$value);
			$range1[]=$ra[0];
			$range[]=end($ra);
		}
		if($cal['se'])
		for ($i=0; $i <count($range); $i++) { 	
			for ($j=$range1[$i]; $j <=$range[$i]; $j++) { 
	       		 $ran[$i][$j]=$cal['se'][$j];						
			}	
		}
		$secmax=array();
		$secmin=array();
		$k=0;
		$sec=array();
		$l=0;
		if(isset($ran))
		foreach ($ran as $key1 => $value1) {	
			$loop=array_values($ran[$key1]);
			$ce=array_unique($ran[$key1]);
			$ex=array_values($ce);
			
			foreach ($value1 as $key2 => $value2) {
				$sec[$value2][]=$cal['m'][$key2-1];
				if($cal['b'][$key2-1]!="D" && $cal['b'][$key2-1]!="U" && $cal['b'][$key2-1]!="W" ){
				$sec[$value2.'o'][]=$cal['m'][$key2-1];
				}
			}
		$de=array();
		if(!empty($sec))
		foreach ($ex as $key => $value) {
			if(isset($sec[$value]))
			$de[$value]=array_sum($sec[$value]);
			if(isset($sec[$value.'o']))
			$de[$value.'o']=array_sum($sec[$value.'o']);
		}
		if(!empty($de))
		foreach ($ex as $key => $value) {
			if (array_key_exists($value.'o',$de))
				$de[$value.'p']=($de[$value.'o']/$de[$value])*100;	
				else	
				$de[$value.'p']=30;	

			if(isset($de[$value.'p'])){
			if($de[$value.'p']>=75)
				if(isset($sectionstrong[$key1]))
				$sectionstrong[$key1].=$ex[$key].',';
				else {
				$sectionstrong[$key1]=$ex[$key].',';
				}
			elseif($de[$value.'p']<=60)
				if(isset($sectionweak[$key1]))
				$sectionweak[$key1].=$ex[$key].',';		
				else
				$sectionweak[$key1]=$ex[$key].',';		
			else{}
				}

		}
		unset($sec);
		$sec=array();
	}
	foreach ($cal['s'] as $key => $value) {
		if(isset($sectionweak[$key]))
		$sectionweak[$value]=$sectionweak[$key];
		unset($sectionweak[$key]);
		if(isset($sectionstrong[$key]))
		$sectionstrong[$value]=$sectionstrong[$key];
		unset($sectionstrong[$key]);
	}
		return [
			"weak_subject"=>$weak,
			"weak_section"=>$sectionweak,
			"strong_subject"=>$strong,
			"strong_section"=>$sectionstrong,
				];
	}
}
