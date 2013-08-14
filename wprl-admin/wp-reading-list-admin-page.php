<?
/*FILE: wp-reading-list-admin-page.php
 *DESCRIPTION: Admin panel page
 */
 
function wprl_admin_settings() {
if (!current_user_can('activate_plugins'))  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ));
	} 
?>
	<div class="wrap">
	    <?php screen_icon(); ?>
	    <h2>Settings</h2>			
	    <form method="post" action="options.php">
	        <?php
                    // This prints out all hidden setting fields
		    settings_fields('wprl_option');	
		    do_settings_sections('wprl_option');
		?>
	        <?php submit_button(); ?>
	    </form>
	</div>
<? }
/*
*End of File
*/
?>
