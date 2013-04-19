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
		$instagram = new Instagram\Instagram;
		$instagram->setAccessToken( $_SESSION['instagram_access_token'] );
		$current_user = $instagram->getCurrentUser();
		new Instagram\Instagram(
			$auth_config = array(
    			'client_id'         => '',
    			'client_secret'     => '',
    			'redirect_uri'      => '',
    			'scope'             => array( 'likes', 'comments', 'relationships' )
			)

			$instagram = new Instagram\Instagram( $auth_config );
			$instagram->authorize();
		);
	}

}