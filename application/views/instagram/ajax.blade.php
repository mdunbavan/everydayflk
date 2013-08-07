<?php

// set up autoloader
function app_autoloader($class) {
  include './' . $class . '.php';
}
spl_autoload_register('app_autoloader');

// start session
session_start();

if (!isset( $_SESSION['instagram_access_token'] ) ) {
$auth = new Instagram\Auth( $auth_config );
if (isset($_GET['code'])) {
      $_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] );
      header( 'Location: ' . REDIRECT_AFTER_AUTH );
      exit;
  } else {
    $auth->authorize();
  }
  exit;
}


  $instagram = new Instagram\Instagram;

  $instagram->setAccessToken($_SESSION['instagram_access_token']);
  $token = $_SESSION['instagram_access_token'];
    //$clientID = $_SESSION['client_id'];
    
  $current_user = $instagram->getCurrentUser();
  $tag = $instagram->getTag('folkclothing');
  
  $media = $tag->getMedia(isset($_GET['max_tag_id']) ? array( 'max_tag_id' => $_GET['max_tag_id'] ) : null);
  
  /* $media = $tag->getMedia($params); */
  /* $next_page = $media->getNext(); */
 
/*
 
  // Receive new data
  $imageMedia = $instagram->pagination($media);
*/
 
  // Collect everything for json output
  $images = array();
  $data_link = array();
  $data_id = array();
  $data_likes = array();
  foreach ($media as $data) {
    $images[] = array(
    	"data_url"=>$data->images->standard_resolution->url,
    	"data_link"=>$data->link,
    	"data_text"=>$data->getCaption(),
    	"data_id"=>$data->getId(),
    	"data_likes"=>$data->likes->count
    
    );
  }
  echo json_encode(array(
    'next_id' => $media->getNextMaxTagId(),
    'images'  => $images
  ));