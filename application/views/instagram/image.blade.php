@layout('layouts/header')
<br/>
		@section('main')
		<div role="main" class="main">
			<div class="images">
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

// controller processing stuff - preparing and handling stuff from view.. 

// is there an error?
$error = '';

// debug form submission

// if the form has been submitted...
if ( ! empty( $_POST )) { 
    
    print_r($_POST);
    
}

try {

    $instagram = new Instagram\Instagram;

    $instagram->setAccessToken($_SESSION['instagram_access_token']);
    $token = $_SESSION['instagram_access_token'];
    //$clientID = $_SESSION['client_id'];
    
    $current_user = $instagram->getCurrentUser();
    $tag = $instagram->getTag('folkclothing');
    $media = $tag->getMedia(isset($_GET['max_tag_id']) ? array( 'max_tag_id' => $_GET['max_tag_id'] ) : null);
    

    $liked_media = $current_user->getLikedMedia();
    /* echo 'https://api.instagram.com/v1/media/'. $item->getId() .'/likes?access_token='.$token.''; */

    if ( isset( $_POST['action'] ) ) {
    
    echo '<br/>FORM IS SUBMITTED, INSPECT WHAT WAS SENT';        
        print_r($_POST);
        
        $id = $_POST['id'];
    
                switch( strtolower( $_POST['action'] ) ) {
            case 'like':
                $current_user->addLike( $id );
                break;
            case 'unlike':
                $current_user->deleteLike( $id );
                break;
                }
       }

} catch ( Exception $e ) {
    // yes there is an error
    $error = $e->getMessage();

}

// view rendering stuff 

// display the error
if ( $error  != '' ) 
{
    echo "<h2>Error: ".$error."</h2>";
} 


echo '<section id="images">';

foreach ( $media as $item ) {

	echo '<article class="instagram-image">';
    // define the form and set the action to POST to send the data to this script
	echo '<form id="'. $token .'" class="forms" action="'; echo URL::current(); echo '" method="post">';

        $id = $item->getId();

        echo '<a title="' . $item->getCaption() .'" class="fancybox" href="' . $item->link . '"><img alt="' . $item->getCaption() .'" src="' . $item->images->standard_resolution->url . '" /></a>';
        echo '<div class="formSubmit-feedback"></div>';
        //echo '<img src="/public/img/377.gif" alt="loader"/>';
        if ( $current_user->likes($item) ){
            echo '<button onClick="post_form("'.$id.'","unlike");" class="ajax instabtn unlike icon-heart" type="submit" name="action" value="Unlike"></button>';
        } else {
            echo '<button onClick="post_form("'.$id.'","like");" class="ajax instabtn like icon-heart" type="submit" name="action" value="Like"></button>';
        }
        echo '<input class="id" type="hidden" name="id" value="'; echo $id; echo '">';
		
		echo '<p>'; echo $item->likes->count; echo '</p>';
        //echo '<p>'.$item->getId().'</p>';
        //echo '<p>By: <em>' . $item->user->username . '</em> </p>';
        //echo '<p>Date: ' . date('d M Y h:i:s', $item->created_time) . '</p>';
        //echo '<p>$item->comments->count . ' comment(s). ' . $item->likes->count . ' likes. ';
        
	echo '</form>';
	echo '</article>';
}
echo '</section>';
//echo $tag->getMediaCount();
//print_r($media_id);</br>
    
	echo "<button id=\"more\" data-url=\"{}\" data-maxid=\"{$media->getNextMaxTagId()}\" data-tag=\"{$tag}\">Load more ...</button>";

    ?>
    <h4>Recent Media <?php if( $media->getNextMaxTagId() ): ?><a href="?tag=<?php echo $tag ?>&max_tag_id=<?php echo $media->getNextMaxTagId() ?>" class="next_page">Next page</a></li><?php endif; ?></h4>
    			
			</div>
		</div>
		@endsection
</body>
</html>
