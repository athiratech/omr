<?php

namespace App;
 
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
 use App\Token;
class User extends Authenticatable
{
    use Notifiable;
     protected $table='users';

   //   protected $fillable = [
   //      'name', 'email', 'payroll_id','password','description',
   //  ];
   //  protected $hidden = [
   //      'password', 'remember_token',
   //  ];
   //   public function roles()
   //  {
   //      return $this->belongsToMany('App\role');
   //  }

   // public function tokens () {
   //      return $this->hasMany(Token::class, 'user_id', 'id');
   //  }
     

}
