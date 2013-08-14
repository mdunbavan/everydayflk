<?php

class Actions_Controller extends Base_Controller {

	public function action_index()
	{
		return View::make('actions.like');
	}
	public function action_unlike()
	{
		return View::make('actions.unlike');
	}

}