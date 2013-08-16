<?
/*FILE: wp-reading-list-admin-functions.php
*DESCRIPTION: Plugin admin functions
*/
//https://codex.wordpress.org/Creating_Options_Pages
//http://ottopress.com/2009/wordpress-settings-api-tutorial/
//http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/

//!!!!http://www.chipbennett.net/2011/02/17/incorporating-the-settings-api-in-wordpress-themes/2/

function wprl_default_options() {
     $options = array(
          'books_in_feed' => false,
          'layout' => 'list',
          'show_post_date' => false,
          'cover_width' => '300',
          'cover_height' => '400',
          'row_color' => 'blue',
          'colunn_color' => 'grey',
     );
     return $options;
}

// Initialize Theme options
function wprl_options_init() {
     global $wprl_options;
     $wprl_options = get_option('wprl_plugin_options');
     if ( false === $wprl_options ) {
          $wprl_options = wprl_default_options();
     }
     update_option('wprl_plugin_options', $wprl_options);
}
add_action('after_setup_theme','wprl_options_init', 9 );

function wprl_get_valid_layouts() {
     $layouts = array(
                    'grid' => array(
               'slug' => 'grid',
               'name' => 'Grid',
               'description' => 'The Grid layout emphasizes book cover images and multiple books per line',
          ),
               'list' => array(
               'slug' => 'list',
               'name' => 'List',
               'description' => 'The List layout is a basic style for displaying books, one per line',
          )
     );
     return $layouts;
}

//Prints current layout setting
function wprl_settings_layouts_section_text() {     
	$wprl_options = get_option('wprl_plugin_options');
	$wprl_layouts = wprl_get_valid_layouts();
	_e('<h4>Current Layout: ');
     	foreach ($wprl_layouts as $layout) {
          	if ( $layout['slug'] == $wprl_options['layout'] ) {
			 _e($layout['name'].'</h4>'); 
     		}
	}
}

//layout setting selector
function wprl_settings_layouts() {
     $wprl_options = get_option('wprl_plugin_options');
     $wprl_layouts = wprl_get_valid_layouts();
     foreach ( $wprl_layouts as $layout) {
          $currentlayout = ($layout ['slug'] == $wprl_options ['layout'] ? true : false);
                _e('<strong>'.$layout['name'].'</strong>');?>
                <input type="radio" name="layout" <?php checked( $currentlayout)?> value="<?php $layout['slug']?>"/>
                <?php
                _e('<small>'.$layout['description'].'</small><br/>');
                
	}
}

function wprl_options_validate($input) {
     $wprl_options = get_option('wprl_plugin_options');
     $valid_input = $wprl_options;

     // Determine which form action was submitted
     $submit = (!empty( $input['submit']) ? true : false);
     $reset = (!empty($input['reset']) ? true : false);

     if ( $submit) { // if General Settings Submit
       //  $valid_input['layout'] = $input['layout'];
          //$valid_input['header_nav_menu_depth'] = ( ( 1 || 2 || 3 ) == $input['header_nav_menu_depth'] ? $input['header_nav_menu_depth'] : $valid_input['header_nav_menu_depth'] );
         // $valid_input['display_footer_credit'] = ( 'true' == $input['display_footer_credit'] ? true : false );

     } elseif ($reset) { // if General Settings Reset Defaults
       		$wprl_default_options= wprl_get_default_options();
         	$valid_input['layout'] = $wprl_default_options['layout'];
         // $valid_input['header_nav_menu_depth'] = $oenology_default_options['header_nav_menu_depth'];
         //$valid_input['display_footer_credit'] = $oenology_default_options['display_footer_credit'];
     }
     return $valid_input;
}

function register_wprl_settings() {//use array in single entry
	register_setting('wprl_plugin_options', 'wprl_plugin_options', 'wprl_options_validate');
	add_settings_section('wprl_settings_layouts', 'WP Reading List Layout', 'wprl_settings_layouts_section_text', 'wprl_options');
	add_settings_field('wprl_settings_layouts', 'Available Layouts', 'wprl_settings_layouts', 'wprl_options', 'wprl_settings_layouts');
}


//primary and secondary color picker
//url to append to links
//layout choice
//show post date or not
//choose dimensions of cover picture size, enforce 3:4
//do you want to delete all 'books' posts?
//do you want to change all 'books' posts to regular posts?
 
 // Show posts of 'post', 'page' and 'book' post types on home page
/*
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

function add_my_post_types_to_query( $query ) {
	if ( is_home() && $query->is_main_query() )
		$query->set( 'post_type', array( 'post', 'page', 'book' ) );
	return $query;
}
*/
 
 /*
function wprl_admin_contextual_help() {
    global $wprl-options;
    $wprl-options = add_options_page(__('My Admin Page', 'wprl_options'), __('My Admin Page', 'wprl_options'), 'manage_options', 'wprl_options', 'wprl-options');

    // Adds my_help_tab when my_admin_page loads
    add_action('load-'.$wprl-options, 'wprl_admin_add_context');
}

function wprl_admin_add_context() {
    global $wprl-options;
    $screen = get_current_screen();

    if ( $screen->id != $wprl-options)
        return;

    $screen->add_help_tab( array(
        'id'	=> 'my_help_tab',
        'title'	=> __('My Help Tab'),
        'content'	=> '<p>' . __( 'Descriptive content that will show in My Help Tab-body goes here.' ) . '</p>',
    ) );
}
add_action('admin_menu', 'wprl_admin_contextual_help');
*/

/*
*End of File
*/