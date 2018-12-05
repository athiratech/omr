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

class Token extends Model
{
    protected $fillable=['user_id','expiry_time','access_token'];

    	public function user () {
			return $this->belongsTo(Employee::class, 'user_id', 'id');
		}
		public static function examdata($data){

		$msg="This is old token";
		if(Auth::id()){
			  $role=DB::table('roles')
                  ->join('user_roles','roles.roll_id','=','user_roles.ROLL_ID')
                  ->join('employees','employees.payroll_id','=','user_roles.payroll_id')
                  ->where('employees.id','=',Auth::id())
                  ->select('roles.role')
                  ->get();
			for($i=0;$i<=sizeof($role)-1;$i++){
				$rolearray[]=$role[$i]->role;
			}
			$token=Token::whereUser_id(Auth::id())->get();
			if($role[0]->role!='EXAM_ADMIN'){
			  $exam= new ExamCollection(Exam::select('*')
                              ->whereIn('state_id',function($query){
                                $query->select('state_id')
                                ->from('t_campus as c','t_employee as e')
                                ->whereRaw('campus_id ='.Auth::user()->CAMPUS_ID);
                                })->paginate());
			}
			else{
				 $exam= new ExamCollection(Exam::select('*')
                              ->whereIn('state_id',function($query){
                                $query->select('state_id')
                                ->from('t_campus as c','t_employee as e')
                                ;
                                })->paginate());
			}
			$campus=Campus::select('CAMPUS_NAME','CAMPUS_ID')->where('CAMPUS_ID','=',Auth::user()->CAMPUS_ID)->get();
			$client = Employee::find(Auth::id());
		        $uc=$client->tokens()->where('created_at', '<', Carbon::now()->subDay())->delete();
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
							'response_message'=>$data,
							'response_code'=>"1",
							],
						'Exam'=>$exam,
					];
			 
			}
				return [
						'Login' => [
							'response_message'=>$data,
							'response_code'=>"1",
							],
						'Exam'=>$exam,
					];
			}
		}
}
