<?php
/*FILE: wp-reading-list-functions.php
*DESCRIPTION: Core plugin functions
*/

defined( 'ABSPATH' ) OR exit;

/*Load the custom taxonomies for 'works' and 'authors' */
if (!current_theme_supports('post-thumbnails'))
{
	add_theme_support('post-thumbnails');
}
require 'wprl-core/wp-reading-list-taxonomies.php';
add_action('init', 'wprl_custom_tax', 0);

/*Set wprl default option settings */
function wprl_default_options() {
	$options = array(
          	'layout' => 'grid',
          	'title' => 'Notes',
          	'multiple_title' => 'Reading List',
		'cover_image' => plugins_url('wp-reading-list/wprl-theme/default.png'),
		'order' => 'date',
		'direction' => 'DESC',
		'cover_width_grid' => '250',
          	'cover_height_grid' => '333',
          	'grid_width' => '3',
          	'grid_rows' => '4',
          	'list_size' => '25',
		'css_margin_left' => '15',
		'padding' => '4',
          	'works_in_feed' => false,
          	'show_post_date' => false,
          	'delete' => false,
          	'show_page_nums' => false,
          	'show_author' => true,
          	'post_author' => false,
		'show_url' => true,
		'show_work' => true,
		'list_image' => true,
		'author_link' => true,
		'version' => '1.2',
    	);
    	return $options;
}

/*Initialize wprl options */
global $wprl_options;
$wprl_options = get_option('wprl_plugin_options');
if (false == $wprl_options || $wprl_options['version'] != '1.2') 
{
	$wprl_options = wprl_default_options();
}
update_option('wprl_plugin_options', $wprl_options);

/*Check to see if user is in admin/backend */
if (is_admin()){
	require 'wprl-admin/wp-reading-list-admin.php';
}

/*Add plugin templates for displaying works and works archive */
function wprl_custom_templates($template) {
	$wprl_options = get_option('wprl_plugin_options');
	if (is_singular('works')){
		$template =  dirname( __FILE__ ) . '/wprl-theme/single-work.php';
		return $template;
	}
	elseif (is_post_type_archive('works') && $wprl_options['layout']=='grid') {
		$template =  dirname( __FILE__ ) . '/wprl-theme/grid-archive-works.php';
		return $template;
    	}
    	elseif (is_post_type_archive('works') && $wprl_options['layout']=='list') {
		$template =  dirname( __FILE__ ) . '/wprl-theme/list-archive-works.php';
		return $template;
    	}
    	elseif (!is_admin() && is_tax('work-author'))
    	{
    		$template =  dirname( __FILE__ ) . '/wprl-theme/taxonomy-work-author.php';
		return $template;
    	}
}
add_filter('single_template', 'wprl_custom_templates') ;
add_filter('archive_template', 'wprl_custom_templates');

/* queue different files depending on the layout chosen and the location */
function wprl_layout_query($query){
	$wprl_options = get_option('wprl_plugin_options');
	if (!is_admin() && $query->is_main_query() && $wprl_options['works_in_feed'] && !is_post_type_archive('works'))
	{
      		$query->set('post_type', array('post', 'works'));
	}
	else if (is_post_type_archive('works') && !is_admin() && $query->is_main_query())
	{
		$query->set('post_type', 'works');
		if ($wprl_options['order'] == 'rand')
		{
			$query->set('orderby', 'rand');
		}
	     	else
	     	{
	     		$orderby = $wprl_options['order'];
	     		if ($orderby == 'author')
			{
		         	$orderby .= ' title';
			}
	     		$query->set('orderby', $orderby);
	     		$query->set('order', $wprl_options['direction']);
		}
		if ($wprl_options['layout']=='grid')
		{
			$numposts = $wprl_options['grid_width'] * $wprl_options['grid_rows'];
			$query->set('posts_per_page', $numposts);
			return $query;
		}
		elseif ($wprl_options['layout']=='list')
		{
			$query->set('posts_per_page', $wprl_options['list_size']);
			return $query;
		}
	}
}

add_action('pre_get_posts', 'wprl_layout_query');

/*Enqueue plugin stylesheet and allow for child theme to override */
if (!function_exists('wprl_styles')) 
{
	function wprl_styles() {
		if (is_post_type_archive('works') && !is_admin())
		{
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
		elseif (is_single() && 'works' == get_post_type())
		{
			wp_enqueue_style('reading-list-single-style', plugins_url('/wprl-theme/single-style.css', __FILE__));
		}
		elseif (!is_admin() && is_tax('work-author'))
		{
			wp_enqueue_style('reading-list-single-style', plugins_url('/wprl-theme/taxonomy-style.css', __FILE__));
		}
	}
}

add_action('wp_enqueue_scripts', 'wprl_styles' );

/*Remove taxonomy function */
function remove_taxonomy($taxonomy) {
	global $wp_taxonomies;
	$terms = get_terms($taxonomy); 
	foreach ($terms as $term) {
		wp_delete_term($term->term_id, $taxonomy );
	}
	unset($wp_taxonomies[$taxonomy]);
}

/*Delete works and authors function, called after 'save settings' or when deleting the plugin */
function delete_works(){
	global $wpdb;
	$query = "
		DELETE FROM wp_posts 
		WHERE post_type = 'works' 
	";
	$wpdb->query($query);
	remove_taxonomy('work-author');
	$GLOBALS['wp_rewrite']->flush_rules();
}

/* Force users to include a title on reading list items */
function force_post_title() {
	if (is_admin() && 'works' == get_post_type())
        {
	  	_e("<script type='text/javascript'>\n");
	  	_e("
	  		jQuery('#publish').click(function(){
	        	var testervar = jQuery('[id^=\"titlediv\"]')
	        	.find('#title');
	        	if (testervar.val().length < 1)
	        	{
	            		setTimeout(\"jQuery('.spinner').css('visibility', 'hidden');\", 100);
	            		alert('Please enter a work title.');
	            		setTimeout(\"jQuery('#publish').removeClass('button-primary-disabled');\", 100);
	            		return false;
	        	}
	    		});
	  	");
	   	_e("</script>\n");
	}
}

/*get featured image for works listing in admin columns */
function wprl_get_cover_image($post_ID) {
	$post_thumbnail_id = get_post_thumbnail_id($post_ID);
	if ($post_thumbnail_id) {
		$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');
		return $post_thumbnail_img[0];
	}
}
/*add new column to admin listing for works */
function wprl_columns_head($defaults) {
	$defaults['author'] = 'Post Author';
	$defaults['featured_image'] = 'Featured Image';
	return $defaults;
}

/*show the cover image for the admin works listing */
function wprl_columns_content($column_name, $post_ID) {
	if ($column_name == 'featured_image') 
	{
		$cover_image= wprl_get_cover_image($post_ID);
		if ($cover_image)
		{
			_e('<img src="'.$cover_image.'"/>');
		}
	}
}
add_filter('manage_posts_columns', 'wprl_columns_head');  
add_action('manage_posts_custom_column', 'wprl_columns_content', 10, 2); 

/* add an "author" column to the "all works" list */
function post_author_column( $columns ) {
    $columns['author'] = 'author'; 
    return $columns;
}

add_filter('manage_edit-works_sortable_columns', 'post_author_column');

/*
*End of File
*/