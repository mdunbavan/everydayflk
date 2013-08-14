<h1>Unlike page</h1>
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
    

    $liked_media = $current_user->getLikedMedia();
	if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) {
            
        print_r($_POST);
        
        $id = $_POST['id'];
    
            switch( strtolower( $_POST['action'] ) ) {
            case 'unlike': 
            	$current_user->deleteLike( $id );
            break;
            }
       }
     }
 
	//Function to check if the request is an AJAX request
	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
 
	function unlike_function(){
		$return = $_POST;
		$return["json"] = json_encode($return);
		echo json_encode($return);
	}
