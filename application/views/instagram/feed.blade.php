@layout('layouts/header')
<br/>
		@section('main')
		<div role="main" class="main">
			<div class="images">
			<p>Feed page</p>
			<?php 
			// set up autoloader
function app_autoloader($class) {
  include './' . $class . '.php';
}
spl_autoload_register('app_autoloader');

// start session
session_start();

// set authentication details
/*
$config = array(
  'client_id'         => '37e5c3c1bd37453aa6f183a357fb413c',
  'client_secret'     => 'c133b37101f94603925325dacbda1bc1',
  'redirect_uri'      => 'http://folk:8888'
);
*/
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
      header( 'Location: ' . REDIRECT_AFTER_AUTH );
      exit;
  } else {
    $auth->authorize();
  }
  exit;
}

			?>
			<?php
    if (!isset($_POST['submit'])) {
    ?>
    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
      Search for user:
      <input type="text" name="u" value="markdunbavan" /> 
      <input type="submit" name="submit" value="Search" />      
    </form>
    <?php
    } else {
    ?>
    <?php     
        // set up client
        $instagram = new Instagram\Instagram;
        $instagram->setAccessToken($_SESSION['instagram_access_token']);
        $current_user = $instagram->getCurrentUser();
        // search for matching user
        $user = $instagram->getUserByUsername($_POST['u']);
        $media = $user->getMedia();
        $data = $media->getData();
        
        try {
    if ( isset( $_POST['action'] ) ) {
        switch( strtolower( $_POST['action'] ) ) {
            case 'like':
                $current_user->addLike( $media->getData );
                break;
            case 'unlike':
                $current_user->deleteLike( $media->getData );
                break;
        }
    }
}
catch( \Instagram\Core\ApiException $e ) {
    $error = $e->getMessage();
}
        
        if ($media->count() > 0) {
          echo '<ul>';
          foreach ($media->getData() as $item) {
            echo '<li style="display: inline-block; padding: 25px">
              <a href="' . $item->link . '">
            <img src="' . $item->images->thumbnail->url . 
              '" /></a> <br/>';
            echo 'By: <em>' . $item->user->username . 
              '</em> <br/>';
            echo 'Date: ' . date ('d M Y h:i:s', $item->created_time) . 
              '<br/>';
            echo $item->comments->count . ' comment(s). ' . 
              $item->likes->count . ' likes.';
          echo  
            '<form id="like" action="" method="post">';
	 if( $current_user->likes( $item ) ): 
	echo '<input type="submit" name="action" value="Unlike">';
	 else:
	echo '<input type="submit" name="action" value="Like">';
	 endif; 
echo '</form>';
            echo '</li>';
          }
          echo '</ul>';
        }
      
    }
  ?>	
			</div>
		</div>
		@endsection
	
</body>
</html>