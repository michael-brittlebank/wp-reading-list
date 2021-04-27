<?php
/*FILE: wp-reading-list-admin-page.php
 *DESCRIPTION: Admin panel page
 */
 
function wprl_admin_page() {
if (!current_user_can('activate_plugins'))  {
		wp_die( _e('You do not have sufficient permissions to access this page.', 'wp_reading_list' ));
	} 
?>
	<div class="wrap">
	    	<?php screen_icon();?>
	   	<h2><?php _e('WP Reading List Settings', 'wp_reading_list' );?></h2>
	    	<form method="post" action="options.php">
	      		<?php
			    settings_fields('wprl_plugin_options');	
			    do_settings_sections('wprl_options');
			?>
			<input name="wprl_plugin_options[submit]" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wp_reading_list'); ?>" />
			<input name="wprl_plugin_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'wp_reading_list'); ?>" />
		</form>
	</div>
<?php }
/*
*End of File
*/