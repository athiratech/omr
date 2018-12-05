<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();delete
// });
use App\Employee;
use App\Http\Resources\Employee as UserResource;

Route::get('/user', function () {
    return new UserResource(Employee::find(1));
});
// Route::group([ 'prefix' => 'token' ], function () {
	Route::post('userLogin', 'AuthController@tokenAuthAttempt');
	Route::post('resultLogin', 'ResultController@login');
	Route::post('uploadResults','AuthController@upload');
	Route::group([ 'middleware' => 'auth:token' ], function () {
		
		Route::get('groups','BaseController@groups');
		Route::get('class_years/{group_id}','BaseController@class_year_wrt_group');
		Route::get('streams/{group_id}/{class_id}','BaseController@stream_wrt_group_class_year');
		Route::get('programs/{stream_id}/{class_id}','BaseController@programs_wrt_stream_class_year');
		Route::get('sections/{program_id}/{stream_id}/{class_id}','BaseController@sections_programs_wrt_stream_class_year');
		Route::post('getExamData', 'AuthController@tokenAuthCheck'); 
		Route::post('uploadTemplate','AuthController@templateData');
		Route::post('deleteTemplate','AuthController@templateDelete');
		Route::post('getTemplates','AuthController@gettemplateData');
		Route::post('getTemplateData','AuthController@templatedataDownload');
		Route::post('getUpdatedplaystoreurl','AuthController@getUpdatedplaystoreurl');
	});
// });

