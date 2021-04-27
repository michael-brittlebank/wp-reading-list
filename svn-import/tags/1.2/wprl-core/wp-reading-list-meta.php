<?php
/*FILE: wp-reading-list-meta.php
 * DESCRIPTION: Custom plugin meta boxes for posts/'works'
 */

/* Set up meta box functions */
function wprl_post_meta_boxes_setup() {

	/*Add meta boxes on the 'add_meta_boxes' hook. */
	add_action( 'add_meta_boxes', 'wprl_add_post_meta_boxes' );
	
	/*Save post meta on the 'save_post' hook. */
	add_action( 'save_post', 'wprl_pages_save_meta', 10, 2 );
}

/* Custom meta boxes for post/'work' admin screen.  */
function wprl_add_post_meta_boxes() {

	add_meta_box(
		'wprl-link', /* Unique ID */
		esc_html__( 'work URL', 'wp-readinglist' ), /* Title */
		'wprl_pages_meta_link',	 /* Callback function */
		'works', /* Add metabox to our custom post type */
		'side',	 /* Context */
		'default' /* Priority */
	);
	add_meta_box(
		'wprl-pages', /* Unique ID */
		esc_html__( 'Number of Pages', 'wp-readinglist' ), /* Title */
		'wprl_pages_meta_pages',	 /* Callback function */
		'works', /* Add metabox to our custom post type */
		'side',	 /* Context */
		'default' /* Priority */
	);
}

/* Display link meta box */
function wprl_pages_meta_link( $object, $box ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), 'wprl_pages_nonce' ); ?>
	<p class="wprl-link-p-admin"><label for="wprl-link"><?php _e( "Add a link to the work", 'wp-readinglist' ); ?></label></p>
	<p><input class="wprl-link-input" type="text" name="wprl-link" id="wprl-link-admin" value="<?php echo esc_attr(get_post_meta( $object->ID, 'wprl_link', true)); ?>" size="30" /></p>
<?php }

/* Display pages meta box */
function wprl_pages_meta_pages( $object, $box ) { ?>
	<?php wp_nonce_field( basename( __FILE__ ), 'wprl_pages_nonce' ); ?>
	<p><input class="wprl-pages-input" type="text" name="wprl-pages" id="wprl-pages-admin" value="<?php echo esc_attr(get_post_meta( $object->ID, 'wprl_pages', true)); ?>" size="30" onchange="pageCheck()"/></p>
<?php }

/* Save meta box data as post_meta */
function wprl_pages_save_meta( $post_id, $post ) {
	if ( !isset( $_POST['wprl_pages_nonce'] ) || !wp_verify_nonce( $_POST['wprl_pages_nonce'], basename( __FILE__ ) ) ) 
	{
		return $post_id;
	}
	$post_type = get_post_type_object( $post->post_type );
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	{
		return $post_id;
	}
	$new_link_value = esc_url_raw( isset( $_POST['wprl-link'] ) ?  $_POST['wprl-link']  : '' );
	$new_pages_value = sanitize_text_field((isset( $_POST['wprl-pages'] ) ?  $_POST['wprl-pages']  : ''));
	$link_key = 'wprl_link';
	$pages_key = 'wprl_pages';
	$link_value = get_post_meta( $post_id, $link_key, true );
	$pages_value = get_post_meta( $post_id, $pages_key, true );
	if ( $new_link_value && '' == $link_value )
	{
		add_post_meta( $post_id, $link_key, $new_link_value, true );
	}
	elseif ( $new_link_value && $new_link_value != $link_value ) 
	{
		update_post_meta( $post_id, $link_key, $new_link_value );
	}
	elseif ( '' == $new_link_value && $link_value ) 
	{
		delete_post_meta( $post_id, $link_key, $link_value );
	}
	if ( $new_pages_value && '' == $pages_value )
	{
		add_post_meta( $post_id, $pages_key, $new_pages_value, true );
	}
	elseif ( $new_pages_value && $new_pages_value != $pages_value ) 
	{
		update_post_meta( $post_id, $pages_key, $new_pages_value );
	}
	elseif ( '' == $new_pages_value && $pages_value ) 
	{
		delete_post_meta( $post_id, $pages_key, $pages_value );
	}
} 

/*
*End of File
*/