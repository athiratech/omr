<?php

namespace App\OmrModels;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\NotifyCollection;

class Fcmtoken extends Model
{
    protected $table='fcm_tokens';
    protected $fillable=['token','USERID','user_type'];

    public static function notifications($data)
    {
    	$arr1=array();
    	$arr=Sendnotifications::where(
    'USERID',$data->USERID)->get();
    	// foreach ($arr as $key => $value) {
    	$arr1=new NotifyCollection(Notifymessage::whereIn('id',explode(',',$arr[0]->notification_ids))->get());
    	// }
    	return  ['Login' => [
                            'response_message'=>"success",
                            'response_code'=>"1",
                            ],
                 "Data"=>$arr1
                ];;
    }
}
