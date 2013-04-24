@layout('layouts/header')
		@section('main')
		<div role="main" class="main">
			<div class="home">
				<p>Media page</p>
				<h1>Instagram media</h1>
				
				<?php

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
      header( 'Location: ' . REDIRECT_AFTER_AUTH );
      exit;
  } else {
    $auth->authorize();
  }
  exit;
}


$media_ids = array(
    '339955848751665483_11007611'
);



$instagram = new Instagram\Instagram;
$instagram->setAccessToken( $_SESSION['instagram_access_token'] );

$media_id = isset( $_GET['media'] ) ? $_GET['media'] : $media_ids[0];
$current_user = $instagram->getCurrentUser();

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

$media = $instagram->getMedia( $media_id );
$comments = $media->getComments();

$tags_closure = function($m){
    return sprintf( '<a href="?example=tag.php&tag=%s">%s</a>', $m[1], $m[0] );
};

$mentions_closure = function($m){
    return sprintf( '<a href="?example=user.php&user=%s">%s</a>', $m[1], $m[0] );
};
?>      

			</div>

<div id="container">
<a href="<?php echo $media->getLink() ?>"><img src="<?php echo $media->getStandardRes()->url ?>"></a>
<?php if( $media->getCaption() ): ?>
<p id="caption"><em><?php echo \Instagram\Helper::parseTagsAndMentions( $media->getCaption(), $tags_closure, $mentions_closure ) ?></em></p>
<?php endif; ?>
<form id="like" action="" method="post">
	<?php if( $current_user->likes( $media ) ): ?>
	<input type="submit" name="action" value="Unlike">
	<?php else: ?>
	<input type="submit" name="action" value="Like">
	<?php endif; ?>
</form>
<dl>
	<dt>User</dt>
	<dd><a href="?example=user.php&user=<?php echo $media->getUser() ?>"><?php echo $media->getUser() ?></a></dd>
	<dt>Date</dt>
	<dd><?php echo $media->getCreatedTime( 'M jS Y @ g:ia' ) ?></dd>
	<dt>Likes (<?php echo $media->getLikesCount() ?>)<?php if( !isset( $_GET['all_likes'] ) ): ?><br><a href="?example=media.php&media=<?php echo $media->getId() ?>&all_likes=true">View all</a><?php else: ?><br>Viewing all <a href="?example=media.php&media=<?php echo $media->getId() ?>">X</a><?php endif; ?></dt>
	<dd><ul class="media_list"><?php foreach( $media->getLikes( isset( $_GET['all_likes'] ) ? true : false ) as $like ): ?><li><a href="?example=user.php&user=<?php echo $like ?>"><img src="<?php echo $like->getProfilePicture() ?>"></a></li><?php endforeach; ?></ul></dd>
	<dt>Tags</dt>
	<dd><?php echo $media->getTags()->implode( function( $t ){ return sprintf( '<a href="?example=tag.php&tag=%1$s">#%1$s</a>', $t ); } ) ?></dd>
	<dt>Filter</dt>
	<dd><?php echo $media->getFilter() ?></dd>
	<dt>Location</dt>
	<dd>
	<?php if( $media->hasNamedLocation() ): ?>
		<a href="?example=location.php&location=<?php echo $media->getLocation()->getId() ?>"><?php echo $media->getLocation() ?></a>
	<?php elseif( $media->hasLocation() ): ?>
		<a href="?example=search.php&search_type=media&lat=<?php echo $media->getLocation()->getLat() ?>&lng=<?php echo $media->getLocation()->getLng() ?>&distance=100">Search nearby media</a
	<?php endif; ?>
	</dd>
</dl>

<a name="comments"></a>
<h3>Comments</h3>
<?php if( count( $comments ) ): ?>
<?php foreach( $comments as $comment ): ?>
<p><strong><a href="?example=user.php&user=<?php echo $comment->getUser() ?>"><?php echo $comment->getUser() ?></a>: </strong><?php echo \Instagram\Helper::parseTagsAndMentions( $comment->getText(), $tags_closure, $mentions_closure ) ?><?php if( \Instagram\Helper::commentIsDeletable( $comment, $media, $current_user ) ): ?>
<form action="#comments" method="post">
<input type="submit" value="X">
<input type="hidden" name="example" value="media.php">
<input type="hidden" name="media" value="<?php echo $media->getId() ?>">
<input type="hidden" name="action" value="delete_comment">
<input type="hidden" name="comment_id" value="<?php echo $comment->getId() ?>">
</form>
<?php endif; ?></p>
<?php endforeach ?>
<?php else: ?>
<p><em>No comments</em></p>
<?php endif; ?>
<form action="#comments" method="post" id="comment_form">
<input type="hidden" name="action" value="add_comment">
<textarea id="comment_text" name="comment_text"></textarea>
<input type="submit" name="comment_submit" value="Comment">
</form>
</div>


		</div>
		@endsection
</body>
</html>
