<?php
namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\BaseModels\Group as groups;
use App\BaseModels\StudyClass as class_year;
use App\Http\Resources\Group as GroupResource;
use App\BaseModels\CourseTrack as course_track;
use App\BaseModels\Stream;
use App\BaseModels\Program;


use App\Http\Resources\GroupCollection;
use App\Http\Resources\StudyClassCollection;
use App\Http\Resources\StreamCollection;
use App\Http\Resources\ProgramCollection;


class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groups()
    {
        //
        return new GroupCollection(groups::distinct('GROUP_ID')->orderBy('GROUP_ID')->get());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function class_year_wrt_group(Request $request, $id)
    {
        //
    
        return new StudyClassCollection(class_year::whereIn('CLASS_ID',course_track::where('GROUP_ID',$id)->pluck('CLASS_ID'))->get());

        
    
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stream_wrt_group_class_year(Request $request)
    { 
        
        //Get group and class year to filter required streams
        $group_id= $request->group_id;
        $class_id= $request->class_id;
        
        // $fields = [
            
        //     'group_id' => $group_id,
        //     'class_id' => $class_id,
        // ];  
        // /* Validate group and class_id*/
        // $validator = Validator::make($fields, [
        //      'group_id' => 'required',
        //      'class_id' => 'required'
        // ]);

        // if ($validator->fails()){

        //     return [
        //         'message' => 'validation_failed',
        //         'errors' => $validator->errors()
        //     ];
        
        // }

        return new StreamCollection(Stream::whereIn('STREAM_ID',course_track::distinct('STREAM_ID')
                            ->where('STREAM', '<>','NULL')
                            ->where('GROUP_ID',$group_id)
                            ->where('CLASS_ID',$class_id)->get())->get());
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function programs_wrt_stream_class_year(Request $request)
    {
        //
        $stream_id= $request->stream_id;
        $class_id= $request->class_id;
        return new ProgramCollection(Program::where('STREAM_ID', '=',$stream_id)
            ->where('CLASS_ID',$class_id)->get());

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
