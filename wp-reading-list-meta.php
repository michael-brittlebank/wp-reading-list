<?
/*FILE: wp-reading-list-meta.php
* DESCRIPTION: Custom plugin meta boxes for posts/'books'
*/

/* 
*Set up meta box functions
*/
function wprl_post_meta_boxes_setup() {

	//Add meta boxes on the 'add_meta_boxes' hook.
	add_action( 'add_meta_boxes', 'wprl_add_post_meta_boxes' );
	
	//Save post meta on the 'save_post' hook.
	add_action( 'save_post', 'wprl_pages_save_meta', 10, 2 );
}

/* 
*Custom meta boxes for post/'book' admin screen. 
*/
function wprl_add_post_meta_boxes() {

	add_meta_box(
		'wprl-pages', // Unique ID
		esc_html__( 'Link URL', 'wp-readinglist' ), // Title
		'wprl_pages_meta_link',	 // Callback function
		'books', // Add metabox to our custom post type
		'side',	 // Context
		'default' // Priority
	);
}

/*
*Display link meta box
*/
function wprl_pages_meta_link( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'wprl_pages_nonce' ); ?>

	<p class="wprl-link-p-admin"><label for="wprl-link"><?php _e( "Add a link to the book", 'wp-readinglist' ); ?></label></p>
	<p><input class="wprl-link-input" type="text" name="wprl-link" id="wprl-link-admin" value="<?php echo esc_attr(get_post_meta( $object->ID, 'wprl_link', true)); ?>" size="30" /></p>
<?php }

/* 
*Save meta box data as post_meta
*/
function wprl_pages_save_meta( $post_id, $post ) {

	//Verify the nonce before proceeding
	if ( !isset( $_POST['wprl_pages_nonce'] ) || !wp_verify_nonce( $_POST['wprl_pages_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}
	
	//Get the post type object
	$post_type = get_post_type_object( $post->post_type );

	//Check if the current user has permission to edit the post
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
		return $post_id;
	}
	
	//Get the posted data and sanitize it for use as an HTML class
	$new_meta_value = ( isset( $_POST['wprl-link'] ) ?  $_POST['wprl-link']  : '' );

	//Get the meta key
	$meta_key = 'wprl_link';

	//Get the meta value of the custom field key
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	//If a new meta value was added and there was no previous value, add it
	if ( $new_meta_value && '' == $meta_value ){
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	}
	
	//If the new meta value does not match the old value, update it
	elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	}
	
	//If there is no new meta value but an old value exists, delete it
	elseif ( '' == $new_meta_value && $meta_value ) {
		delete_post_meta( $post_id, $meta_key, $meta_value );
	}
} 