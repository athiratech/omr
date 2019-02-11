<?php

namespace App\OmrModels;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    protected $table='IP_Exam_Section';
    // protected $prima
    public function filter(){
    	return $this->hasManyThrough(
            '\App\BaseModels\Section',
            '\App\BaseModels\CourseTrack',
            'COURSE_TRACK_ID', // Foreign key on users table...
            'COURSE_TRACK_ID', // Foreign key on posts table...
            'id', // Local key on countries table...
            'COURSE_TRACK_ID' // Local key on users table...
        );
    }
}
