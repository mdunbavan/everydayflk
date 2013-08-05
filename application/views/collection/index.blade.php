@layout('layouts/header')
<br/>
		@section('main')
		<div role="main" class="main">
		<div class="images"></div>
<h1>Hello world!</h1>
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
      // get and display popular images
      $current_user = $instagram->getCurrentUser();
      
$media = $current_user->getMedia();

foreach( $media as $photo ) {
echo '<li>
<a href="' . $photo->link . '"><img src="' . 
            $photo->images->thumbnail->url . 
            '" /></a></li>';
echo '<form id="like" action="" method="post">';
	 if( $current_user->likes( $photo ) ): 
	echo '<input type="submit" name="action" value="Unlike">';
	 else:
	echo '<input type="submit" name="action" value="Like">';
	 endif; 
echo '</form>';

}
$media_count = count( $media );
$first_photo = $media[0];
//print_r();

if ( isset( $_POST['action'] ) ) {
        	switch( strtolower( $_POST['action'] ) ) {
            case 'like':
                $current_user->addLike( $photo );
                break;
            case 'unlike':
                $current_user->deleteLike( $photo );
                break;
        	}
    	}
?>



			</div>
		</div>
		@endsection
</body>
</html>