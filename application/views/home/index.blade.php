@layout('layouts/header')
		@section('main')
		<div role="main" class="main">
			<div class="home">
				<p>My home page</p>
				<h1>Popular on Instagram</h1>  
    <?php
    // set up autoloader
function app_autoloader($class) {
  include './' . $class . '.php';
}
spl_autoload_register('app_autoloader');

// start session
session_start();

// set authentication details
$auth_config = array(
  'client_id'         => '37e5c3c1bd37453aa6f183a357fb413c',
  'client_secret'     => 'c133b37101f94603925325dacbda1bc1',
  'redirect_uri'      => 'http://folk:8888',
  'scope'             => array( 'likes', 'comments', 'relationships' )
);

if (!isset( $_SESSION['instagram_access_token'] ) ) {
$auth = new Instagram\Auth( $auth_config );
if (isset($_GET['code'])) {
      $_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] );
      exit;
  } else {
    $auth->authorize();
  }
  exit;
}


    // initialize client
    try {
      $instagram = new Instagram\Instagram;
      
      $instagram->setAccessToken($_SESSION['instagram_access_token']);
      // get and display popular images
      $popular_media = $instagram->getPopularMedia();
      $current_user = $instagram->getCurrentUser();
      $tag = $instagram->getData();
/*
      $media = $popular_media->getData();
      $data = $popular_media->getData();
*/
      
      echo '<h3>'; echo $current_user; echo '</h3>';
	 echo '<img src="'; echo $current_user->getProfilePicture(); echo '"'; echo '/>';

        echo '<ul>';
        foreach ($popular_media as $item) {
          echo '<li style="display: inline-block; padding: 25px">
            <a href="' . $item->link . '"><img src="' . 
            $item->images->thumbnail->url . 
            '" /></a> <br/>';
          echo 'By: <em>' . $item->user->username . 
            '</em> <br/>';
          echo 'Date: ' . date ('d M Y h:i:s', $item->created_time) . '<br/>';
          echo $item->comments->count . ' comment(s). ' . 
            $item->likes->count . ' likes. ';
          echo '<form id="like" action="" method="post">';
	 if( $current_user->likes( $item ) ): 
	echo '<input type="submit" name="action" value="Unlike">';
	 else:
	echo '<input type="submit" name="action" value="Like">';
	 endif; 
echo '</form>';
            echo '</li>';
        }
        echo '</ul>';
        

    } catch (Exception $e) {
      echo 'ERROR: ' . $e->getMessage() . print_r($e);
      exit;
    }
    
    if ( isset( $_POST['action'] ) ) {
        switch( strtolower( $_POST['action'] ) ) {
            case 'like':
                $current_user->addLike( $item );
                break;
            case 'unlike':
                $current_user->deleteLike( $item );
                break;
        }
    }

    ?>
    

			</div>
		</div>
		@endsection
</body>
</html>
