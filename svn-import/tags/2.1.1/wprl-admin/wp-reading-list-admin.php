<?php

/*FILE: wp-reading-list-admin.php

*DESCRIPTION: Plugin admin setup

*/



require 'wp-reading-list-admin-page.php';/*the menu page */

require 'wp-reading-list-admin-functions.php';



/*Set up the admin page */

function wprl_admin_menu(){

	global $wprl_admin_page;

	$wprl_admin_page = add_options_page('WP Reading List','WP Reading List','activate_plugins','wprl-options','wprl_admin_page');

	add_action('load-'.$wprl_admin_page , 'wprl_add_help_tab');

}



/*Add contextual help to the plugin admin page */

function wprl_add_help_tab() {

	global $wprl_admin_page;

	$screen = get_current_screen();

	if ( $screen->id != $wprl_admin_page ){

		return;

	}



	$screen->add_help_tab(array(

	        'id'	=> 'wprl_help_overview',

	        'title'	=> _e('WPRL Overview'),

	        'content'	=> '<p>' . _e('<b>WP Reading List</b> (or, <b>WPRL</b>)is a plugin designed to help organize and display books, magazines, articles, and or anything else that you have read lately.  This plugin allows users to display what they have read, attach text like a review or notes to it, and provide a link to where visitors can find the piece.<br/><br/>Please select any of the other tabs to read more about the various administration functions available in this plugin.') . '</p>',

	    ) );    

	$screen->add_help_tab(array(

	        'id'	=> 'wprl_help_layout',

	        'title'	=> _e('Layout'),

	        'content'	=> '<p>' . _e('

			<b>Available Layouts</b>: There are two layouts available, "grid" and "list". "Grid" is a layout which emphasizes cover images is intended to be more visually appealing.  "List" is a layout which displays Reading List materials more like traditional posts, with one item per line.

			<br/><br/>

			<b>Order Posts By</b>: There are four options available for ordering your Reading List items, "Date", "Post Author", "Random", and "Title".  "Date" is the default, and WordPress&apos;s default, which orders posts by the date they were published.  "Post Author" orders Reading List items by alphabetizing the author of the post.  (*Note here, this is not the author or authors that you listed when you wrote your Reading List item.)  This is useful if you have multiple contributors who are all writing Reading List items and you want to sort by who is contributing what.  "Random" is pretty straightforward; your Reading List items are put in random order every time the page is loaded.  "Title" allows you to display Reading List items alphabetically by their title.

			<br/><br/>

			<b>Order Direction</b>: Descending order is the WordPress default and it orders Reading List items from newest to oldest in the case dates and from the end of the alphabet to numbers for text.  Ascending order is the opposite.

			<br/><br/>

			<b>Left Margin</b>: This option allows you to specify how far over to the right (from the left-hand side of the screen) that you want your content.  Use this to match your theme&apos;s layout or customize your views.  <br/>Range: 0-25.

			<br/><br/>

			<b>Cover Image Spacing</b>: This option allows you to specify how far apart you want your layout items, left-right space for the grid layout and up-down space for the list layout.  <br/>Range: 1-10.') . '</p>',

	    ) );

	    $screen->add_help_tab(array(

	        'id'	=> 'wprl_help_grid',

	        'title'	=> _e('Grid'),

	        'content'	=> '<p>' . _e('

			<b>Grid Width</b>: This option sets the number of Reading List items on each line in the grid layout.

			<br/>Range: 1-4.

			<br/><br/>

			<b>Number of Grid Rows</b>: This option sets how many rows of Reading List items are displayed in the grid layout.

			<br/>Range: 1-10.') . '</p>',

	    ) );

	    $screen->add_help_tab(array(

	        'id'	=> 'wprl_help_list',

	        'title'	=> _e('List'),

	        'content'	=> '<p>' . _e('

			<b>Number of List Items</b>: This is similar to the option for showing the number of blog posts in the "General Settings" page.  This allows you to have a different number of Reading List items than the rest of the site.

			<br/>Range: 1-50.

			<br/><br/>

			<b>Show Cover Image</b>: Check this option if you want to show cover images in the list layout.  This is not necessary for the list layout.

			<br/><br/>

			<b>Cover Size</b>: Use this option to change the size of the cover image shown in the list layout.  You can only set the width; the height will automatically be adjusted to what you input since it is enforced at a 4:3 ratio.  If a cover image is smaller than the dimensions you specified or is not originally in a 4:3 ratio, the original size will be shown up to whatever dimension limit it hits first.  Images will not be inflated or warped to fit this setting, it is more like setting a maximum size.

			<br/>Range: 60-600.

	        ') . '</p>',

	    ) );

	    $screen->add_help_tab(array(

	        'id'	=> 'wprl_help_display',

	        'title'	=> _e('Display'),

	        'content'	=> '<p>' . _e('*These options will affect both the archive layouts and the single item layout.

			<br/><br/>

			<b>Show Cover Image Link</b>: Check this option if you do not want any of your cover images to display the link you set in the Reading List item, i.e. post, editor.

			<br/><br/>

			<b>Show Link to Single Postb>: Check this option if you want to show a link to the single post view.  If you only wish to show the list of works you read, like if you choose not to write anything in the post&apos;s content, this is a good option as it will only show the grid or list layout.

			<br/><br/>

			<b>Show Item Author/s</b>: Check this option if you want to show the author/s that you listed in the Reading List item&apos;s metabox labeled "Author/s". 

			<br/><br/>

			<b>Show Author/s Link</b>: Check this option if you want to show a link on the reading list item author/s&apos; name.  This is essentially an "archive" view for all reading list items that were written by the author selected.

			<br/><br/>

			<b>Show Post Author</b>: Check this option if you wish to show which user on the site wrote/published the Reading List item.

			<br/>*If you enable this, it is recommended that you also turn on the "Display on Whole Site" setting, otherwise a user&apos;s Reading List items will not show up in searches with regular posts by the same user.

	        ') . '</p>',

	    ) );

	    $screen->add_help_tab(array(

	        'id'	=> 'wprl_help_general',

	        'title'	=> _e('General'),

	        'content'	=> '<p>' . _e('

			<b>Display on Whole Site</b>: Check this option if you wish to show Reading List items in your blog&apos;s feed and search results.  This also enables Reading List items to show up if searching for a specific user&apos;s content.

			<br/><br/>

			<b>Single Post Header</b>: Use this option to change what the content of the single item view is called.

			<br/><br/>

			<b>Layout Header</b>: Use this option to change what the header of the grid or list layout view is called.') . '</p>',

	    ) );

	    $screen->add_help_tab(array(

	        'id'	=> 'wprl_help_admin',

	        'title'	=> _e('Admin'),

	        'content'	=> '<p>' . _e('

			<b>Delete All</b>: If you would like to delete all of your Reading List items, select this option.  This deletes all works and authors but does not delete the feature images in the media library. 

			<br/>*IMPORTANT! This is permanant and there is no way to recover the data once this option is checked and the "Save Settings" button is pressed.

			<br/><br/>

			This is the only way to delete all traces of this plugin from your database.  Deactivating and/or deleting the plugin only removes the plugin settings and does not delete your content.'). '</p>',

	    ) );

}



add_action('admin_init','register_wprl_settings');

add_action('admin_menu','wprl_admin_menu');

add_action('admin_enqueue_scripts', 'wprl_enqueue' );

add_action('edit_form_advanced', 'force_post_title');

add_filter('admin_post_thumbnail_html', 'wprl_featured_image_html');

add_filter('gettext', 'wprl_featured_image_mod');

add_filter('ngettext', 'wprl_featured_image_mod');



/*

*End of File

*/