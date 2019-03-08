<?php

namespace App\OmrModels;

use Illuminate\Database\Eloquent\Model;

class Notifymessage extends Model
{
    //
    protected $table='notify_message';
    protected $fillable=['title','url','data'];
}
