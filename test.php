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