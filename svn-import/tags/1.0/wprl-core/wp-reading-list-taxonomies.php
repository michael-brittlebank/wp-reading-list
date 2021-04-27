<?
/*FILE: wp-reading-list-taxonomies.php
 * DESCRIPTION: Create a custom taxonomy for 'authors' and a custom post type for 'books'
 */
 
/*
*Create custom taxonomy for authors
*/
function wprl_custom_tax() {
	$labels = array(
		'name' => __('Author/s', 'wp-readinglist'),
		'singular_name' => __('Author', 'wp-readinglist'),
		'search_items' => __('Search Authors', 'wp-readinglist'),
		'all_items' => __('All Authors', 'wp-readinglist'),
		'edit_item' => __('Edit Author', 'wp-readinglist'), 
		'update_item' => __('Update Author', 'wp-readinglist'),
		'add_new_item' => __('Add New Author', 'wp-readinglist'),
		'new_item_name' => __('New Author Name', 'wp-readinglist'),
		'separate_items_with_commas' => __('Separate authors with commas', 'wp-readinglist'),
		'choose_from_most_used' => __('Choose from the most used authors', 'wp-readinglist'),
		'menu_name' => __('Authors', 'wp-readinglist'),
	); 	
		
	register_taxonomy('book-author', array( 'books'), array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'book-author'),
	));
}

/*
*Load the custom meta boxes for 'books'
*/
require 'wp-reading-list-meta.php';
add_action('load-post.php', 'wprl_post_meta_boxes_setup');
add_action('load-post-new.php', 'wprl_post_meta_boxes_setup');

/*
*Create custom post type for 'books'
*/
function wprl_custom_post() {
	$labels = array(
		'name' => __('Books', 'wp-readinglist'),
		'singular_name' => __('Book', 'wp-readinglist'),
		'menu_name' => __('Books', 'wp-readinglist'),
		'all_items' => __('All Books', 'wp-readinglist'),
		'add_new_item' => __('Add New Book', 'wp-readinglist'),
		'edit_item' => __('Edit Book', 'wp-readinglist'),
		'new_item' => __('New Book', 'wp-readinglist'),
		'view_item' => __('View Book', 'wp-readinglist'),
		'search_items' => __('Search Books', 'wp-readinglist'),
		'not_found' => __('No Books Found', 'wp-readinglist'),
		'not_found_in_trash' => __('No Books in Trash', 'wp-readinglist'),
		'update_item' => __('Update Book', 'wp-readinglist')
	);
	
	$args = array (
		'labels' => $labels,
		'description' => 'Holds Reading List information',
		'public' => true,
		'exclude_from_search' => false,
		'menu_position' => 20,
		'supports' => array('title', 'thumbnail', 'editor' , 'revisions'),
		'has_archive' => true,
		'rewrite' => array('slug' => 'books')
	);
	register_post_type('books', $args);
}
add_action('init', 'wprl_custom_post');

/*
*Customize admin messages related to the wprl custom post type
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
*Custom help tab for wprl
*/
function codex_custom_help_tab() {
	global $post_ID;
	$screen = get_current_screen();

	if( isset($_GET['post_type']) ) $post_type = $_GET['post_type'];
	else $post_type = get_post_type( $post_ID );

	if( $post_type == 'books' ){
		$screen->add_help_tab( array(
	        'id'	=> 'wprl_help_overview',
	        'title'	=> __('WPRL Overview'),
	        'content'	=> '<p>' . __('<b>WP Reading List</b> (or, <b>WPRL</b>) is a plugin designed to help organize and display books, magazines, articles, and or anything else that you have read lately.  This plugin allows users to display what they have read, attach text like a review or notes to it, and provide a link to where visitors can find the piece.<br/><br/>Please select any of the other tabs to read more about the various administration functions available in this plugin.') . '</p>',
	    ) );    
	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_author',
	        'title'	=> __('Author/s'),
	        'content'	=> '<p>' . __('
This metabox allows you to add "authors" to your Reading List items.  You can add any number of authors, just like regular post tags; just separate them with commas.  These authors can then be shown in your layout and managed from the "Authors" tab under the "Books" tab in the admin menu.
<br/>
Examples: "William Shakespeare", "John" "Kate" "Will", "J. K. Rowling"
') . '</p>',
	    ) );
	    	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_url',
	        'title'	=> __('Book URL'),
	        'content'	=> '<p>' . __('
This metabox allows you to add custom urls to link to external sources by wrapping the link around the posts&apos;s cover image.  Use this box to direct users to where the original Reading List item can be found or use it as a link for affiliate programs like <a href="https://affiliate-program.amazon.com/" target="_blank">Amazon Associates</a>.  Be sure to verify the link is correct and make sure you have the "Show Cover Image Links" setting turned on in the general "WP Reading List Settings" page.  Also, make sure you have a cover image to link from!
</br>
Example: "http://www.amazon.com/The-Riverside-Shakespeare-2nd-Edition/dp/0395754909/ref=sr_1_1?ie=UTF8&qid=1377294257&sr=8-1&keywords=shakespeare+riverside"
') . '</p>',
	    ) );
	    	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_pages',
	        'title'	=> __('Number of Pages'),
	        'content'	=> '<p>' . __('
This metabox allows you to specify how many pages are in the Reading List item.  Unfortunately at this time we cannot support page ranges, i.e. "210-450".  Make sure you do not spell out the page number.
<br/>Examples: "1", "999"
<br/>Range: 1-10000.
') . '</p>',
	    ) );
	    	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_cover_image',
	        'title'	=> __('Cover Image'),
	        'content'	=> '<p>' . __('
This metabox allows you to set a featured image or "cover image" for your Reading List item.  This can then be shown in a Reading List layout.
') . '</p>',
	    ) );
	}
}
add_action('admin_head', 'codex_custom_help_tab');

/*
*End of File
*/