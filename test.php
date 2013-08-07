<?php 
if( $data->getCaption() ):
echo '<p id="caption"><em>'; echo \Instagram\Helper::parseTagsAndMentions( $media->getCaption() ); echo '</em></p>';
endif;
echo '<form id="like" action="" method="post">';
	if( $current_user->likes( $data ) ):
	echo '<input type="submit" name="action" value="Unlike">';
	else:
	echo '<input type="submit" name="action" value="Like">';
	endif;
echo '</form>';

	//$comments = $media->getComments();
	if ( isset( $_POST['action'] ) ) {
        switch( strtolower( $_POST['action'] ) ) {
            case 'like':
                $current_user->addLike( $data );
                break;
            case 'unlike':
                $current_user->deleteLike( $data );
                break;
        }
    }


echo '<form id="like" action="" method="post">';
	if( $current_user->likes( $item ) ):
	echo '<input type="submit" name="action" value="Unlike">';
	else:
	echo '<input type="submit" name="action" value="Like">';
	endif;
echo '</form>';

<?php 

/*   $collection = array($data->images->standard_resolution->url,$data->link,$data->getId(),$data->likes->count); */
    /*
$images[] = $data->images->standard_resolution->url;
    $images[] = $data->link;
    $images[] = $data->getId();
    $images[] = $data->likes->count;
*/
	/*
$data_url[] = $data->images->standard_resolution->url;
	$data_link[] = $data->link;
	$data_id[] = $data->getId();
	$data_likes[] = $data->likes->count;
	$images[] = array($data_url);
*/
/*     $images[] = array($data_url[] = $data->images->standard_resolution->url,$data_link[] = $data->link, $data_id[] = $data->getId(), $data_likes[] = $data->likes->count); */

?>