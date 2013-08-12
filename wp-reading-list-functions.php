<?
/*FILE: wp-reading-list-functions.php
 *DESCRIPTION: Core plugin functions
 *ABBREVs: wprl => wp reading list 
 */
 
 defined( 'ABSPATH' ) OR exit;
 
 /*ACTIVATION*/

 /*
 *Load the custom taxonomies for 'books' and 'authors'
*/
 require 'wprl-core/wp-reading-list-taxonomies.php';
add_action( 'init', 'wprl_custom_tax', 0);
 
/*ADMIN*/

 if (is_admin()){
	require 'wprl-admin/wp-reading-list-admin.php';//The admin menu option panel for wprl
}

//TODO: load options/settings here
//if no theme support for thumbnails, set default view to grid http://codex.wordpress.org/add_theme_support


/*APPEARANCE*/

/*
*Add plugin templates for displaying custom post type 'books' and 'books' archive
*/
function wprl_custom_templates($template) {
	if (is_singular('books')){
		$template =  dirname( __FILE__ ) . '/wprl-theme/single-books.php';
		return $template;
	}
	
    if (is_post_type_archive('books')) {
		$template =  dirname( __FILE__ ) . '/wprl-theme/archive-books.php';
		return $template;
    }
}
add_filter('single_template', 'wprl_custom_templates') ;
add_filter('archive_template', 'wprl_custom_templates');


/*
*Enqueue plugin stylesheet and allow for child theme to override
*/
 if ( ! function_exists( 'wprl_styles' )) { 

	function wprl_styles() {
		wp_enqueue_style( 'reading-list-style', plugins_url('/wprl-theme/style.css', __FILE__));
	}
}
add_action( 'wp_enqueue_scripts', 'wprl_styles' );

/*
*Create custom image size for book covers
*/
function wprl_cover() {
	add_image_size( 'book-cover', 300, 400 ); //maintain 3:4 aspect ratio
}
add_action( 'after_setup_theme', 'wprl_cover' );

/*
*End of File
*/