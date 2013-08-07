<?php

class Ajax_Controller extends Base_Controller {

	public function action_index()
	{
		return View::make('instagram.ajax');
		
	}

}