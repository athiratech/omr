<?php

namespace App\OmrModels;
 
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
 use App\OmrModels\Token;
class Tparent extends Authenticatable
{
    use Notifiable;
     protected $table='scaitsqb.t_student_bio';
     // protected $guard = 't_student_bio';
     protected $primaryKey='ADM_NO';
    public $timestamps=false;
     public function roles()
    {
        return $this->belongsToMany('App\OmrModels\role');
    }

   public function tokens() {
        return $this->hasMany(Token::class, 'user_id', 'ADM_NO');
    }
     

}
