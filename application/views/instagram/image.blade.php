@layout('layouts/header')
<br/>
		@section('main')
		<div role="main" class="main">
			<div class="images">
			<p>the instagram feed will go here</p>
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
$config = array(
  'client_id'         => '37e5c3c1bd37453aa6f183a357fb413c',
  'client_secret'     => 'c133b37101f94603925325dacbda1bc1',
  'redirect_uri'      => 'http://folk:8888'
);

// perform authentication
if (!isset( $_SESSION['instagram_access_token'] ) ) {
  $auth = new Instagram\Auth($config);
  if (isset($_GET['code'])) {
      $_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] );
      header( 'Location: ' . REDIRECT_AFTER_AUTH );
      exit;
  } else {
    $auth->authorize();
  }
  exit;
}
try {
    if ( isset( $_POST['action'] ) ) {
        switch( strtolower( $_POST['action'] ) ) {
            case 'add_comment':
                $current_user->addMediaComment( $media_id, $_POST['comment_text'] );
                break;
            case 'delete_comment':
                $current_user->deleteMediaComment( $media_id, $_POST['comment_id'] );
                break;
            case 'like':
                $current_user->addLike( $media_id );
                break;
            case 'unlike':
                $current_user->deleteLike( $media_id );
                break;
        }
    }
}
catch( \Instagram\Core\ApiException $e ) {
    $error = $e->getMessage();
}

    // initialize client
    try {
      $instagram = new Instagram\Instagram;
      
      $instagram->setAccessToken($_SESSION['instagram_access_token']);
      // get and display popular images
      $tag = $instagram->getTag( 'folkdetails' );
      $media = $tag->getMedia(isset($_GET['max_tag_id'] ) ? array( 'max_tag_id' => $_GET['max_tag_id'] ) : null);
      $data = $media->getData();
      
      $media = $instagram->getMedia($data);
$comments = $media->getComments();

$tags_closure = function($m){
    return sprintf( '<a href="?example=tag.php&tag=%s">%s</a>', $m[1], $m[0] );
};

$mentions_closure = function($m){
    return sprintf( '<a href="?example=user.php&user=%s">%s</a>', $m[1], $m[0] );
};
      
      if ($media->count() > 0) {
        echo '<ul>';
        foreach ($data as $item) {
          echo '<li style="display: inline-block; padding: 25px">
            <a href="' . $item->link . '"><img src="' . 
            $item->images->thumbnail->url . 
            '" /></a> <br/>';
          echo 'By: <em>' . $item->user->username . 
            '</em> <br/>';
          echo 'Date: ' . date ('d M Y h:i:s', $item->created_time) . '<br/>';
          echo $item->comments->count . ' comment(s). ' . 
            $item->likes->count . ' likes. </li>';
            if( $data->getCaption() ):
echo '<p id="caption"><em>'; echo \Instagram\Helper::parseTagsAndMentions( $media->getCaption(), $tags_closure, $mentions_closure ); echo '</em></p>';
endif;
echo '<form id="like" action="" method="post">';
	if( $current_user->likes( $data ) ):
	echo '<input type="submit" name="action" value="Unlike">';
	else:
	echo '<input type="submit" name="action" value="Like">';
	endif;
echo '</form>';
        }
        echo '</ul>';
        echo $tag->getMediaCount();
      }
    } catch (Exception $e) {
      echo 'ERROR: ' . $e->getMessage() . print_r($e);
      exit;
    }
    ?>
    <h4>Recent Media <?php if( $media->getNextMaxTagId() ): ?><a href="?example=tag.php&tag=<?php echo $tag ?>&max_tag_id=<?php echo $media->getNextMaxTagId() ?>" class="next_page">Next page</a></li><?php endif; ?></h4>
    			
			</div>
		</div>
		@endsection
</body>
</html>
