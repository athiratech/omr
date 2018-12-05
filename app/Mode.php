<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    protected $table='0_test_modes';
    protected $primaryKey='test_mode_id';
    
    public $timestamps = false;

    public static function deletetemplate($omr_scanning_type,$model_years,$test_mode_id){
    	if($omr_scanning_type=='Advanced'){
		$mode=Modesyear::where('model_years',$model_years)
	  		->update(['template_data' => null,'template_path' => null]);
	  	}

	  	else{
	    $modedata=Mode::where('test_mode_id',$test_mode_id)
	      ->update(['template_data'=>null,'template_data'=>null]);
	  	}

		return [
			'Login' => [
							'response_message'=>"success",
							'response_code'=>"1",
							],

			];
    }
}
