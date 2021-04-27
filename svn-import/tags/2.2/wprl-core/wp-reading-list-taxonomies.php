<?php

/*FILE: wp-reading-list-taxonomies.php

 * DESCRIPTION: Create a custom taxonomy for 'authors' and a custom post type for 'works'

 */

 

/* Create custom taxonomy for authors */

function wprl_custom_tax() {

	$labels = array(

		'name' => 'Author/s', 

		'singular_name' => 'Author', 

		'search_items' => 'Search Authors',

		'all_items' => 'All Authors',

		'edit_item' => 'Edit Author', 

		'update_item' => 'Update Author', 

		'add_new_item' => 'Add New Author',

		'new_item_name' => 'New Author Name',

		'separate_items_with_commas' => 'Separate authors with commas',

		'choose_from_most_used' => 'Choose from the most used authors',

		'menu_name' => 'Authors', 

	); 	

		

	register_taxonomy('work-author', array('works'), array(

		'hierarchical' => false,

		'labels' => $labels,

		'show_ui' => true,

		'show_admin_column' => true,

		'query_var' => true,

		'publicly_queryable' => true,

		'rewrite' => array('slug' => 'reading-list/author', 'with_front' => false),

	));

		$labels = array(

		'name' => 'Work Type/s', 

		'singular_name' => 'Type', 

		'search_items' => 'Search Types',

		'all_items' => 'All Types', 

		'edit_item' => 'Edit Type', 

		'update_item' => 'Update Type', 

		'add_new_item' => 'Add New Type',

		'new_item_name' => 'New Work Type', 

		'separate_items_with_commas' => 'Separate types with commas', 

		'choose_from_most_used' => 'Choose from the most used types', 

		'menu_name' => 'Work Types', 

	); 	

		

	register_taxonomy('work-type', array( 'works'), array(

		'hierarchical' => false,

		'labels' => $labels,

		'show_ui' => true,

		'show_admin_column' => true,

		'publicly_queryable' => true,

		'query_var' => true,

		'rewrite' => array('slug' => 'reading-list/type', 'with_front' => false),

	));

}



/* Load the custom meta boxes for 'works' */

require 'wp-reading-list-meta.php';

add_action('load-post.php', 'wprl_post_meta_boxes_setup');

add_action('load-post-new.php', 'wprl_post_meta_boxes_setup');



/* Create custom post type for reading list 'items' */

function register_wprl_cpt() {

	$labels = array(

		'name' => 'Works', 

		'singular_name' => 'Work', 

		'menu_name' => 'Works',

		'all_items' => 'All Works', 

		'add_new_item' => 'Add New Work',

		'edit_item' => 'Edit Work', 

		'new_item' => 'New Work', 

		'view_item' => 'View Work', 

		'search_items' => 'Search Works', 

		'not_found' => 'No Works Found', 

		'not_found_in_trash' => 'No Works in Trash', 

		'update_item' => 'Update Work'

	);

	

	$args = array (

		'label' => 'works',

		'labels' => $labels,

		'description' => 'Holds Reading List information',

		'public' => true,

		'exclude_from_search' => false,

		'publicly_queryable' => true,

		'show_ui' => true,

		'show_in_nav_menus' => true,

		'show_in_menu' => true,

		'show_in_admin_bar' => true,

		'hierarchical' => false,

		'_builtin' => false,

		'query_var' => 'reading-list',

		'taxonomies' => array('work-type', 'work-author'),

		'menu_position' => 20,

		'supports' => array('title', 'thumbnail', 'editor' , 'revisions'),

		'has_archive' => true,

		'rewrite' => array('slug' => 'reading-list', 'with_front' => false)

	);

	register_post_type('works', $args);

}

add_action('init', 'register_wprl_cpt');

/* Customize admin messages related to the wprl custom post type */

function wprl_custom_messages( $messages ) {

	 global $post, $post_ID;



	 $messages['works'] = array(

			0 => '', /* Unused. Messages start at index 1. */

			1 => sprintf( __('Work updated. <a href="%s">View Work</a>', 'wp_reading_list'), esc_url( get_permalink($post_ID) ) ),

			2 => __('Custom field updated.', 'wp_reading_list'),

			3 => __('Custom field deleted.', 'wp_reading_list'),

			4 => __('Work updated.', 'wp_reading_list'),

			5 => isset($_GET['revision']) ? sprintf( __('Work restored to revision from %s', 'wp_reading_list'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,

			6 => sprintf( __('Work published. <a href="%s">View Work</a>', 'wp_reading_list'), esc_url( get_permalink($post_ID) ) ),

			7 => __('Work saved.', 'wp_reading_list'),

			8 => sprintf( __('Work submitted. <a target="_blank" href="%s">Preview Work</a>', 'wp_reading_list'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),

			9 => sprintf( __('Scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Work</a>', 'wp_reading_list'),

			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),

			10 => sprintf( __('Draft updated. <a target="_blank" href="%s">Preview Work</a>', 'wp_reading_list'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),

	  );

	return $messages;

}

add_filter( 'post_updated_messages', 'wprl_custom_messages' );



/* Custom help tab for wprl */

function codex_custom_help_tab() {

	global $post_ID;

	$screen = get_current_screen();



	if( isset($_GET['post_type']) ) $post_type = $_GET['post_type'];

	else $post_type = get_post_type( $post_ID );



	if( $post_type == 'works' ){

		$screen->add_help_tab( array(

	        'id'	=> 'wprl_help_overview',

	        'title'	=> __('WPRL Overview'),

	        'content'	=> '<p>' . __('<b>WP Reading List</b> (or, <b>WPRL</b>) is a plugin designed to help organize and display books, magazines, articles, and or anything else that you have read lately.  This plugin allows users to display what they have read, attach text like a review or notes to it, and provide a link to where visitors can find the piece.').'<br/><br/>'.__('Please select any of the other tabs to read more about the various administration functions available in this plugin.') . '</p>',

	    ) );    

	$screen->add_help_tab(array(

	        'id'	=> 'wprl_help_author',

	        'title'	=> __('Author/s'),

	        'content'	=> '<p>' . __('

This metabox allows you to add "authors" to your Reading List items.  You can add any number of authors, just like regular post tags; just separate them with commas.  These authors can then be shown in your layout and managed from the "Authors" tab under the "Works" tab in the admin menu.').'

<br/>

'.__('Examples: "William Shakespeare", "John" "Kate" "Will", "J.K. Rowling"'

) . '</p>',

	    ) );

	    	$screen->add_help_tab(array(

	        'id'	=> 'wprl_help_url',

	        'title'	=> __('Work URL'),

	        'content'	=> '<p>' . __('

This metabox allows you to add custom urls to link to external sources by wrapping the link around the posts&apos;s cover image.  Use this box to direct users to where the original Reading List item can be found or use it as a link for affiliate programs like <a href="https://affiliate-program.amazon.com/" target="_blank">Amazon Associates</a>.  Be sure to verify the link is correct and make sure you have the "Show Cover Image Links" setting turned on in the general "WP Reading List Settings" page.  Also, make sure you have a cover image to link from!').'

</br>

'.__('Example: "http://www.amazon.com/The-Riverside-Shakespeare-2nd-Edition/dp/0395754909/ref=sr_1_1?ie=UTF8&qid=1377294257&sr=8-1&keywords=shakespeare+riverside"

') . '</p>',

	    ) );

	    	$screen->add_help_tab(array(

	        'id'	=> 'wprl_help_pages',

	        'title'	=> __('Number of Pages'),

	        'content'	=> '<p>' . __('

This metabox allows you to specify how many pages are in the Reading List item.  This plugin supports either individual numbers or page ranges, i.e. "210-450".  Make sure you do not spell out the page number.').'

<br/>'.__('Examples: "1", "999"').'

<br/>'.__('Range: "1-10000".') . '</p>',

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