<?
/*FILE: wp-reading-list-admin.php
*DESCRIPTION: Plugin admin setup
*/

require 'wp-reading-list-admin-page.php';//the menu page
require 'wp-reading-list-admin-functions.php;

function wprl_admin_menu(){
	add_options_page('WP Reading List','WP Reading List','activate_plugins','wp-reading-list','wprl_admin_settings');
}
add_action('admin_menu','wprl_admin_menu');
add_action( 'admin_init', 'register_wprl_settings' );


/*
*End of File
*/