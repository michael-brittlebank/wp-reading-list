<?php
/*FILE: wp-reading-list-admin-page.php
 *DESCRIPTION: Admin panel page
 */
 
function wprl_admin_page() {
if (!current_user_can('activate_plugins'))  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ));
	} 
?>
	<div class="wrap">
	    	<?php screen_icon();?>
	   	<h2>WP Reading List Settings</h2>
	    	<form method="post" action="options.php">
	      		<?php
			    settings_fields('wprl_plugin_options');	
			    do_settings_sections('wprl_options');
			?>
			<input name="wprl_plugin_options[submit]" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wprl_options'); ?>" />
			<input name="wprl_plugin_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset Defaults', 'wprl_options'); ?>" />
		</form>
	</div>
<?php }
/*
*End of File
*/