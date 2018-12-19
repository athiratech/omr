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

use App\OmrModels\Employee;
use App\Http\Resources\Employee as UserResource;

	Route::post('userLogin', 'AuthController@tokenAuthAttempt');
	Route::post('resultLogin', 'OmrControllers\ResultController@login');
	Route::post('uploadResults','AuthController@upload');
	Route::group([ 'middleware' => 'auth:token' ], function () {		
		Route::post('total_percentage','OmrControllers\ResultController@total_percentage');
		Route::post('examlist','OmrControllers\ResultController@examlist');
		Route::post('test_type_list','OmrControllers\ResultController@test_type_list');
		Route::get('groups','OmrControllers\BaseController@groups');
		Route::get('class_years/{group_id}','OmrControllers\BaseController@class_year_wrt_group');
		Route::get('streams/{group_id}/{class_id}','OmrControllers\BaseController@stream_wrt_group_class_year');
		Route::get('programs/{stream_id}/{class_id}','OmrControllers\BaseController@programs_wrt_stream_class_year');
		Route::post('getExamData', 'AuthController@tokenAuthCheck'); 
		Route::post('uploadTemplate','AuthController@templateData');
		Route::post('deleteTemplate','AuthController@templateDelete');
		Route::post('getTemplates','AuthController@gettemplateData');
		Route::post('getTemplateData','AuthController@templatedataDownload');
		Route::post('getUpdatedplaystoreurl','AuthController@getUpdatedplaystoreurl');
	});

