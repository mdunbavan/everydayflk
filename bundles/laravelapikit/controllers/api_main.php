<?php

class Api_Main_BundleController_Controller extends Base_Controller
{

	public function action_index(){
	
		// $var_name = Config::get('bundle_name::options.option1');
		$api_model = new apimodel();
		return View::make('api::index')->with('data', $api_model);

	}

}