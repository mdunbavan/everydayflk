<?php

class Image_Controller extends Base_Controller {

	public function action_index()
	{
		//return View::make('instagram');
		//return 'Image section';
		return View::make('instagram.image');
		
	}
	public function action_feed()
	{
		return View::make('instagram.feed');
	}

}