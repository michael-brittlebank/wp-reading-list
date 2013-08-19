<?
/*FILE: wp-reading-list-functions.php
*DESCRIPTION: Core plugin functions
*ABBREVs: wprl => wp reading list 
*/
//check if user theme has featured image support and then modify query
//if no theme support for thumbnails, set default view to grid http://codex.wordpress.org/add_theme_support

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

//plugin settings in admin
function add_books_to_homepage($query) {
	if (!is_admin() && $query->is_main_query())
	{
      		$query->set('post_type', array('post', 'books'));
	}
	return $query;
}
$wprl_options = get_option('wprl_plugin_options');
if ($wprl_options['books_in_feed'])
{
	add_action('pre_get_posts', 'add_books_to_homepage');
}
elseif (has_action('pre_get_posts', 'add_books_to_homepage'))
{
	remove_action('pre_get_posts', 'add_books_to_homepage');
}


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
	add_image_size('book-cover', 300, 400); //maintain 3:4 aspect ratio
}
add_action( 'after_setup_theme', 'wprl_cover' );

//Delete books function, called after 'save settings' or when deleting the plugin
function delete_books(){
	global $wpdb;
	$query = "
		DELETE FROM wp_posts 
		WHERE post_type = 'books' 
	";
	$wpdb->query($query);
}

/*
*End of File
*/