<?php

namespace App\OmrModels;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $fillable=['name'];

      public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
