<?php

namespace App\OmrModels;

use Illuminate\Database\Eloquent\Model;

class Sendnotifications extends Model
{
    //
    protected $table='send_notifications';
    protected $fillable=['USERID','notification_ids'];

}
