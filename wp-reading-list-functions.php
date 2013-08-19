<?
/*FILE: wp-reading-list-functions.php
*DESCRIPTION: Core plugin functions
*ABBREVs: wprl => wp reading list 
*/
//do contextual help for books edit/create new page
//http://codex.wordpress.org/Function_Reference/add_theme_support

defined( 'ABSPATH' ) OR exit;

//Load the custom taxonomies for 'books' and 'authors'
require 'wprl-core/wp-reading-list-taxonomies.php';
add_action('init', 'wprl_custom_tax', 0);
//add_action('after_setup_theme','wprl_options_init',9);

//Set wprl default option settings
function wprl_default_options() {
	$options = array(
          	'layout' => 'list',
          	'cover_width_grid' => '250',
          	'cover_height_grid' => '333',
          	'title' => 'Notes',
          	'grid_width' => '2',
          	'grid_rows' => '5',
          	'list_size' => '25',
          	'multiple_title' => 'Reading List',
          	'books_in_feed' => false,
          	'show_post_date' => false,
          	'delete' => false,
          	'show_page_nums' => false,
          	'show_author' => true,
		'show_url' => true,
    	);
    	return $options;
}

//Initialize wprl options
global $wprl_options;
$wprl_options = get_option('wprl_plugin_options');
if (false == $wprl_options) {
	$wprl_options = wprl_default_options();
     	}
update_option('wprl_plugin_options', $wprl_options);

//Check to see if user is in admin/backend
if (is_admin()){
	require 'wprl-admin/wp-reading-list-admin.php';//The admin menu option panel for wprl
}

//Add plugin templates for displaying books and books archive
function wprl_custom_templates($template) {
	$wprl_options = get_option('wprl_plugin_options');
	if (is_singular('books')){
		$template =  dirname( __FILE__ ) . '/wprl-theme/single-book.php';
		return $template;
	}
	elseif (is_post_type_archive('books') && $wprl_options['layout']=='grid') {
		$template =  dirname( __FILE__ ) . '/wprl-theme/grid-archive-books.php';
		return $template;
    	}
    	elseif (is_post_type_archive('books') && $wprl_options['layout']=='list') {
		$template =  dirname( __FILE__ ) . '/wprl-theme/list-archive-books.php';
		return $template;
    	}
    	elseif (!is_admin() && is_tax('book-author'))
    	{
    		$template =  dirname( __FILE__ ) . '/wprl-theme/taxonomy-book-author.php';
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

function wprl_layout_num($query){
	$wprl_options = get_option('wprl_plugin_options');
	if (is_post_type_archive('books') && !is_admin() && $query->is_main_query() && $wprl_options['layout']=='grid')
	{
		$numposts = $wprl_options['grid_width'] * $wprl_options['grid_rows'];
		$query->set('posts_per_page', $numposts);
		return $query;
	}
	elseif (is_post_type_archive('books') && !is_admin() && $query->is_main_query() && $wprl_options['layout']=='list')
	{
		$query->set('post_type', 'books');
		$query->set('posts_per_page', $wprl_options['list_size']);
		return $query;
	}
}
add_action('pre_get_posts', 'wprl_layout_num', 1);

//Enqueue plugin stylesheet and allow for child theme to override
if (!function_exists('wprl_styles')) 
{
	function wprl_styles() {
		$wprl_options = get_option('wprl_plugin_options');
		if ($wprl_options['layout']=='grid')
		{
		wp_enqueue_style( 'reading-list-grid-style', plugins_url('/wprl-theme/grid-style.css', __FILE__));
		}
		elseif ($wprl_options['layout']=='list')
		{
		wp_enqueue_style('reading-list-list-style', plugins_url('/wprl-theme/list-style.css', __FILE__));
		}
	}
}
add_action('wp_enqueue_scripts', 'wprl_styles' );

//Remove taxonomy function
function remove_taxonomy($taxonomy) {
	global $wp_taxonomies;
	$terms = get_terms($taxonomy); 
	foreach ($terms as $term) {
		wp_delete_term($term->term_id, $taxonomy );
	}
	unset($wp_taxonomies[$taxonomy]);
}

//Delete books and authors function, called after 'save settings' or when deleting the plugin
function delete_books(){
	global $wpdb;
	$query = "
		DELETE FROM wp_posts 
		WHERE post_type = 'books' 
	";
	$wpdb->query($query);
	remove_taxonomy('book-author');
	$GLOBALS['wp_rewrite']->flush_rules();
}

function force_post_title() {
  	_e("<script type='text/javascript'>\n");
  	_e("
  		jQuery('#publish').click(function(){
        	var testervar = jQuery('[id^=\"titlediv\"]')
        	.find('#title');
        	if (testervar.val().length < 1)
        	{
            		setTimeout(\"jQuery('.spinner').css('visibility', 'hidden');\", 100);
            		alert('Please enter a book title.');
            		setTimeout(\"jQuery('#publish').removeClass('button-primary-disabled');\", 100);
            		return false;
        	}
    		});
  	");
   	_e("</script>\n");
}

/*
*End of File
*/