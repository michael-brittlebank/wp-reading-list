<?
/*FILE: wp-reading-list-admin-functions.php
*DESCRIPTION: Plugin admin functions
*/
//http://www.chipbennett.net/2011/02/17/incorporating-the-settings-api-in-wordpress-themes/2/

//Set wprl default option settings
function wprl_default_options() {
	$options = array(
          	'books_in_feed' => false,
          	'layout' => 'list',
          	'show_post_date' => false,
          	'cover_width' => '300',
          	'cover_height' => '400',
          	'row_color' => 'blue',
          	'colunn_color' => 'grey',
          	'url' => ''
    	);
    	return $options;
}

// Initialize wprl options
function wprl_options_init() {
	global $wprl_options;
    	$wprl_options = get_option('wprl_plugin_options');
     	if ( false == $wprl_options ) {
       		$wprl_options = wprl_default_options();
     	}
     	update_option('wprl_plugin_options', $wprl_options);
}

//Valid layout choices
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
function wprl_settings_layouts_text() {     
	$wprl_options = get_option('wprl_plugin_options');
	$wprl_layouts = wprl_get_valid_layouts();
	_e('<h4>Current Layout: ');
     	foreach ($wprl_layouts as $layout) {
          	if ( $layout['slug'] == $wprl_options['layout'] ) {
			 _e($layout['name'].'</h4>'); 
     		}
	}
}

//Layout setting selector
function wprl_settings_layouts() {
     	$wprl_options = get_option('wprl_plugin_options');
     	$wprl_layouts = wprl_get_valid_layouts();
     	foreach ( $wprl_layouts as $layout) {
          	$currentlayout = ($layout ['slug'] == $wprl_options ['layout'] ? true : false);?>
                <strong><?php _e($layout['name']);?></strong>
                <input type="radio" id="<?php _e($layout['slug']); ?>" name="wprl_plugin_options[layout]" <?php checked($currentlayout)?> value="<?php _e($layout['slug']);?>"/>
		<?php _e($layout['description']);?><br/>     
	<?}
}

//Prints current url
function wprl_settings_url_text() {     
	_e('<p>If you have an affiliate link that you would like to add to the end of the book urls, enter it here.</p>', 'wprl_options' );
	$wprl_options = get_option('wprl_plugin_options');
	_e('<h4>Current Link: <span class="faded">http://example.com/</span>');
        if (empty ($wprl_options['url'])) {
        	_e('Not Set</h4>');
      	}
     	else
     	{
     		_e($wprl_options['url'].'</h4>');
     	}
}

//URL setting selector
function wprl_settings_url() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<label for="wprl-options-url">Link: </label>
        <input type="text" id="wprl-options-url" name="wprl_plugin_options[url]" value="<?php _e($wprl_options['url']);?>"/>
<?}

function wprl_options_validate($input) {
     	$wprl_options = get_option('wprl_plugin_options');
     	$valid_input = $wprl_options;
	//var_dump($_POST);
	//die;
     	// Determine which form action was submitted
     	$submit = (!empty( $input['submit']) ? true : false);
     	$reset = (!empty($input['reset']) ? true : false);

     	if ( $submit) { // if General Settings Submit
     		$valid_layouts = wprl_get_valid_layouts();
         	$valid_input['layout'] = (array_key_exists($input['layout'], $valid_layouts) ? $input['layout'] : $valid_input['layout'] );
         	$valid_input['url'] = sanitize_text_field($input['url']);
     	} 
     	elseif ($reset) { // if General Settings Reset Defaults
       		$wprl_default_options= wprl_default_options();
         	$valid_input['layout'] = $wprl_default_options['layout'];
         	$valid_input['url'] = $wprl_default_options['url'];
     	}
     	return $valid_input;
}

//use single entry with array of options
function register_wprl_settings() {
	wp_register_style('wprl-admin-style', plugins_url('wp-reading-list/wprl-admin/wp-reading-list-admin-style.css'));  
        wp_enqueue_style('wprl-admin-style');
	register_setting('wprl_plugin_options', 'wprl_plugin_options', 'wprl_options_validate');
	add_settings_section('wprl_settings_layouts', 'Reading List Layout', 'wprl_settings_layouts_text', 'wprl_options');
	add_settings_field('wprl_settings_layouts', 'Available Layouts', 'wprl_settings_layouts', 'wprl_options', 'wprl_settings_layouts');
	add_settings_section('wprl_settings_url', 'Affiliate Link', 'wprl_settings_url_text', 'wprl_options');
	add_settings_field('wprl_settings_url', '', 'wprl_settings_url', 'wprl_options', 'wprl_settings_url');

}


//primary and secondary color picker
//url to append to links
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