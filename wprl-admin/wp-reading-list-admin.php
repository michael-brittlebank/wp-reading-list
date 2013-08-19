<?
/*FILE: wp-reading-list-admin.php
*DESCRIPTION: Plugin admin setup
*/
//contextual help

require 'wp-reading-list-admin-page.php';//the menu page
require 'wp-reading-list-admin-functions.php';

//Set up the admin page
function wprl_admin_menu(){
	global $wprl_admin_page;
	$wprl_admin_page = add_options_page('WP Reading List','WP Reading List','activate_plugins','wprl-options','wprl_admin_page');
	add_action('load-'.$wprl_admin_page , 'wprl_add_help_tab');
}

//Add contextual help to the plugin admin page
function wprl_add_help_tab() {
	global $wprl_admin_page;
	$screen = get_current_screen();
	if ( $screen->id != $wprl_admin_page ){
		return;
	}
	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_overview',
	        'title'	=> __('WPRL Overview'),
	        'content'	=> '<p>' . __('WP Reading List (or, WPRL) is a plugin designed to help organize and display books, magazines, articles, or anything that you have read lately.  This plugin allows users to display what they have read, attach text like a review or notes to it, and provide a link to where visitors can find the piece.<br/>Please select any of the other tabs to read more about the various administration functions available in this plugin.') . '</p>',
	    ) );    
	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_layout',
	        'title'	=> __('Layout'),
	        'content'	=> '<p>' . __('There are two available layouts at this time, "grid" and "list". "Grid" is a layout which emphasizes cover images and "flow".  It is intended to be more visually appealing.  "List" is a layout which incorporates a sortable list and, while not as pretty, compensates with increased functionality.<br/>The "Cover Size" setting changes the default dimensions for the cover image in the grid layout.') . '</p>',
	    ) );
	    	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_appearance',
	        'title'	=> __('Appearance'),
	        'content'	=> '<p>' . __('Descriptive content that will show in My Help Tab-body goes here.') . '</p>',
	    ) );
	    	$screen->add_help_tab(array(
	        'id'	=> 'wprl_help_admin',
	        'title'	=> __('Admin'),
	        'content'	=> '<p>' . __('If you would like to delete all of your books, select this option.  This deletes all books and authors but does not delete the feature images in the media library.') . '</p>',
	    ) );
}

add_action('after_setup_theme','wprl_options_init',9);
add_action('admin_menu','wprl_admin_menu');
add_action('admin_init','register_wprl_settings');
add_action('admin_enqueue_scripts', 'wprl_enqueue' );
/*
*End of File
*/