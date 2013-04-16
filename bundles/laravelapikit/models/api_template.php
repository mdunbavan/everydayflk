<?php

 class api_template extends APIBASE{

	public static $api_key = '';
	public static $api_url = 'yourapiurl.com';
	
	public function __construct($url=NULL,$api_key=NULL)
	{
		parent::new_request(($url?$url:self::$api_url));
	}
	
}
