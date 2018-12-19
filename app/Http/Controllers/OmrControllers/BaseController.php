<?php
namespace App\Http\Controllers\OmrControllers;

use Validator;
use Illuminate\Http\Request;
use App\BaseModels\Group as groups;
use App\BaseModels\StudyClass as class_year;
use App\Http\Resources\Group as GroupResource;
use App\BaseModels\CourseTrack as course_track;
use App\BaseModels\Stream;
use App\BaseModels\Program;
use App\Http\Controllers\Controller;

use App\Http\Resources\GroupCollection;
use App\Http\Resources\StudyClassCollection;
use App\Http\Resources\StreamCollection;
use App\Http\Resources\ProgramCollection;


class BaseController extends Controller
{

    public function groups()
    {
        return new GroupCollection(groups::distinct('GROUP_ID')->orderBy('GROUP_ID')->get());

    }
    public function class_year_wrt_group(Request $request, $id)
    {
    
        return new StudyClassCollection(class_year::whereIn('CLASS_ID',course_track::where('GROUP_ID',$id)->pluck('CLASS_ID'))->get());      
    
    }
    public function stream_wrt_group_class_year(Request $request)
    { 
        
        //Get group and class year to filter required streams
        $group_id= $request->group_id;
        $class_id= $request->class_id;

        return new StreamCollection(Stream::whereIn('STREAM_ID',course_track::distinct('STREAM_ID')
                            ->where('STREAM', '<>','NULL')
                            ->where('GROUP_ID',$group_id)
                            ->where('CLASS_ID',$class_id)->get())->get());
         
    }

    public function programs_wrt_stream_class_year(Request $request)
    {
        //Get stream and class id for required programs
        $stream_id= $request->stream_id;
        $class_id= $request->class_id;
        return new ProgramCollection(Program::where('STREAM_ID', '=',$stream_id)
            ->where('CLASS_ID',$class_id)->get());

    }
}
