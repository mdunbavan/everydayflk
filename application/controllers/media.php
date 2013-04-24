<?php

class Media_Controller extends Base_Controller {

	public function action_index()
	{
		//return View::make('instagram');
		//return 'Image section';
		return View::make('media.index');
		
	}

}