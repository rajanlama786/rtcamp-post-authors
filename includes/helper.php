<?php
/**
 *  Add Metabox 
 */ 

//Register Meta box
add_action( 'add_meta_boxes', function() {
	add_meta_box( 
		'rpa-id', 
		__('Contributors','rtcamp-post-authors'), 
		'rpa_field_cb', 
		'post',
		'side' 
	);
});

//Meta callback function
function rpa_field_cb( $post ) {
	
	$rpa_contributors_arr= get_post_meta( $post->ID, 'rpa-contributors', true );

	if( empty( $rpa_contributors_arr )){
		$rpa_contributors_arr = [];
	}

	$users = get_users();
	$count = 0;
	if( count($users) > 0 ){
		foreach( $users as $user ){ ?>
			<input type="checkbox" id="user-<?php echo $user->ID; ?>" name="rpa-contributors[]" value="<?php echo $user->ID; ?>" <?php echo checked( in_array(  $user->ID , $rpa_contributors_arr), 1); ?> />
			<label for="user-<?php echo $user->ID; ?>"> <?php echo esc_attr( $user->user_login ); ?></label><br/>
		<?php
		}
	}

}

//save meta value with save post hook
add_action( 'save_post', function( $post_id ) {
	if ( isset( $_POST['rpa-contributors'] ) ) {
		update_post_meta( $post_id, 'rpa-contributors', $_POST['rpa-contributors'] );
	}
} );

// show meta value after post content
add_filter( 'the_content', 'rpa_contributors_list' );

function rpa_contributors_list( $content ) {
	global $post;
	$contributors= get_post_meta( $post->ID, 'rpa-contributors', true );
	$rpa_title ="";
	$contrib ="";

	if( !empty( $contributors ) && count( $contributors ) > 0 ){
		$rpa_title = sprintf( '<h3>%s</h3>',__('Contributors :', 'rtcamp-post-authors')); ;

		$contrib = ""; 

		foreach( $contributors as $contributor ){
			$user_obj = get_user_by('id', $contributor);
			$contrib .=  sprintf('<a class="author-info" href="%s"><img class="author-thumb" src="%2s"><span>%3s</span></a>', esc_url( get_author_posts_url( get_the_author_meta( $contributor ) ) ),esc_url( get_avatar_url( $contributor ) ), esc_attr( $user_obj->user_login ) );
		}
		return $content . $rpa_title . $contrib;
	}
	return $content;
} 

// Show contributor names with their Gravatars.
// Contributor-names must be clickable and will link to their respective “author” page.