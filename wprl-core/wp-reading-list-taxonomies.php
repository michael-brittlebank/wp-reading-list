<?
/*FILE: wp-reading-list-taxonomies.php
 * DESCRIPTION: Create a custom taxonomy for 'authors' and a custom post type for 'books'
 */
 
/*
*Create custom taxonomy for authors
*/
function wprl_custom_tax() {
	$labels = array(
		'name' => __( 'Authors', 'wp-readinglist' ),
		'singular_name' => __( 'Author', 'wp-readinglist' ),
		'search_items'  => __( 'Search Authors', 'wp-readinglist' ),
		'all_items'  => __( 'All Authors', 'wp-readinglist' ),
		'edit_item'	=> __( 'Edit Author', 'wp-readinglist' ), 
		'update_item'	=> __( 'Update Author', 'wp-readinglist' ),
		'add_new_item' 	=> __( 'Add New Author', 'wp-readinglist' ),
		'new_item_name' 	=> __( 'New Author Name', 'wp-readinglist' ),
		'separate_items_with_commas' 	=> __( 'Separate authors with commas', 'wp-readinglist' ),
		'choose_from_most_used' 	=> __( 'Choose from the most used authors', 'wp-readinglist' ),
		'menu_name' 	=> __( 'Authors', 'wp-readinglist' ),
	); 	
		
	register_taxonomy( 'book-author', array( 'books' ), array(
		'hierarchical' 	=> false,
		'labels' 		=> $labels,
		'show_ui' 	=> true,
		'show_admin_column'	 => true,
		'query_var' 	=> true,
		'rewrite' 	=> array( 'slug' => 'book-author' ),
	));
}

 /*
 *Load the custom meta boxes for 'books'
*/
 require 'wp-reading-list-meta.php';
add_action( 'load-post.php', 'wprl_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'wprl_post_meta_boxes_setup' );


/*
*Create custom post type for 'books'
*/
function wprl_custom_post() {
	$labels = array(
		'name' 	=> __( 'Books', 'wp-readinglist' ),
		'singular_name' 	=> __( 'Book', 'wp-readinglist' ),
		'menu_name' 	=> __( 'Books', 'wp-readinglist' ),
		'all_items'	=> __( 'All Books', 'wp-readinglist' ),
		'add_new_item' 	=> __( 'Add New Book', 'wp-readinglist' ),
		'edit_item'	=> __( 'Edit Book', 'wp-readinglist' ),
		'new_item' 	=> __( 'New Book', 'wp-readinglist' ),
		'view_item'		=> __( 'View Book', 'wp-readinglist' ),
		'search_items'	=> __( 'Search Books', 'wp-readinglist' ),
		'not_found'		=> __( 'No Books Found', 'wp-readinglist' ),
		'not_found_in_trash'		=> __( 'No Books in Trash', 'wp-readinglist' ),
		'update_item' 	=> __( 'Update Book', 'wp-readinglist' )
	);
	
	$args = array (
		'labels' 	=> $labels,
		'description'	=> 'Holds books and book information',
		'public' 	=> true,
		'exclude_from_search'	=> false,
		'menu_position' 	=> 20,
		'supports' 	=> array( 'title', 'thumbnail', 'editor' , 'revisions'),
		'has_archive' 	=> true,
		'rewrite'	=> array( 'slug' => 'books' )
	);
	register_post_type( 'books', $args );
}
add_action( 'init', 'wprl_custom_post' );

/*
*Customize admin messages related to the wprl custom post type
*
*http://codex.wordpress.org/Function_Reference/register_post_type
*/
function wprl_custom_messages( $messages ) {
	 global $post, $post_ID;

	 $messages['books'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __('Book updated. <a href="%s">View book</a>', 'wp-readinglist'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.', 'wp-readinglist'),
			3 => __('Custom field deleted.', 'wp-readinglist'),
			4 => __('Book updated.', 'wp-readinglist'),
			5 => isset($_GET['revision']) ? sprintf( __('Book restored to revision from %s', 'wp-readinglist'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('Book published. <a href="%s">View book</a>', 'wp-readinglist'), esc_url( get_permalink($post_ID) ) ),
			7 => __('Book saved.', 'wp-readinglist'),
			8 => sprintf( __('Book submitted. <a target="_blank" href="%s">Preview book</a>', 'wp-readinglist'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('Scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview book</a>', 'wp-readinglist'),
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('Draft updated. <a target="_blank" href="%s">Preview book</a>', 'wp-readinglist'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	  );
	return $messages;
}
add_filter( 'post_updated_messages', 'wprl_custom_messages' );

/*
*Customize contextual help for wprl 'books'
*
*http://codex.wordpress.org/Function_Reference/register_post_type
*/
function wprl_custom_help_text( $contextual_help, $screen_id, $screen ) { //TODO
	if ( 'books' == $screen->id ||  'edit-books' == $screen->id  ) {
		$contextual_help =
		'<p>' . __('Things to remember when adding or editing a book:', 'wp-readinglist') . '</p>' .
		'<ul>' .
		'<li>' . __('Set a featured image to be the book cover.', 'wp-readinglist') . '</li>' .
		'<li>' . __('Be sure to specify the author of the book in the Author meta box.', 'wp-readinglist') . '</li>' .
		'<li>' . __('Add a link to your book to guide readers to where they can find a copy or use it for self-referral, such as in Amazon&apos;s Associates Program.', 'wp-readinglist') . '</li>' .
		'</ul>' .
		'<p><strong>' . __('For more information:', 'wp-readinglist') . '</strong></p>' .
		'<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>', 'wp-readinglist') . '</p>' .
		'<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'wp-readinglist') . '</p>' ;
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'wprl_custom_help_text', 10, 3 );

/*
*Custom help tab for wprl
*
*http://codex.wordpress.org/Function_Reference/register_post_type
*/
function codex_custom_help_tab() {
	global $post_ID;
	$screen = get_current_screen();

	if( isset($_GET['post_type']) ) $post_type = $_GET['post_type'];
	else $post_type = get_post_type( $post_ID );

	if( $post_type == 'books' ){
		$screen->add_help_tab( array(
			'id'  => 'wprl_help_tab', //unique id for the tab
			'title'  => 'WP Reading List  Help', //unique visible title for the tab
			'content' => '<h3>WP Reading List  Help</h3><p>I shall help you</p>',  //TODO
		));
	}
}
add_action('admin_head', 'codex_custom_help_tab');

/*
*End of File
*/