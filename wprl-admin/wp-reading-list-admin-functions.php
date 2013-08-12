<?
/*FILE: wp-reading-list-admin-functions.php
*DESCRIPTION: Plugin admin functions
*/
//https://codex.wordpress.org/Creating_Options_Pages
//http://ottopress.com/2009/wordpress-settings-api-tutorial/
//http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/

function register_wprl_settings() {
  register_setting('wprl_option', 'new_option_name');
  register_setting('wprl_option', 'some_other_option');
  register_setting('wprl_option', 'option_etc');
}


 //primary and secondary color picker
 //reset default button
 //url to append to links
 //layout choice
 //show post date or not
 //choose dimensions of cover picture size, enforce 3:4
 //choose whether or not you want your books to show up in your normal feed
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
 
 //http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 
    add_action( 'admin_init', 'my_plugin_admin_init' );
    add_action( 'admin_menu', 'my_plugin_admin_menu' );

    function my_plugin_admin_init() {
        /* Register our script. 
        wp_register_script( 'my-plugin-script', plugins_url( '/script.js', __FILE__ ) );
    }

    function my_plugin_admin_menu() {
        /* Add our plugin submenu and administration screen 
        $page_hook_suffix = add_submenu_page( 'edit.php', // The parent page of this submenu
                                  __( 'My Plugin', 'myPlugin' ), // The submenu title
                                  __( 'My Plugin', 'myPlugin' ), // The screen title
				  'manage_options', // The capability required for access to this submenu
				  'my_plugin-options', // The slug to use in the URL of the screen
                                  'my_plugin_manage_menu' // The function to call to display the screen
                               );

        /*
          * Use the retrieved $page_hook_suffix to hook the function that links our script.
          * This hook invokes the function only on our plugin administration screen,
          * see: http://codex.wordpress.org/Administration_Menus#Page_Hook_Suffix
          
        add_action('admin_print_scripts-' . $page_hook_suffix, 'my_plugin_admin_scripts');
    }

    function my_plugin_admin_scripts() {
        /* Link our already registered script to a page
        wp_enqueue_script( 'my-plugin-script' );
    } 
 */

/*
*End of File
*/