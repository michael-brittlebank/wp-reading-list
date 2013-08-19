<?
/*FILE: wp-reading-list-admin-functions.php
*DESCRIPTION: Plugin admin functions
*/
//items to show checkbox for list
//maybe colors for list
//implementation

//Valid layout choices
function wprl_get_valid_layouts() {
     $layouts = array(
	'grid' => array(
	'slug' => 'grid',
        'name' => 'Grid',
        'description' => 'The Grid layout emphasizes visual appeal and displays book cover images and multiple books per line',
        ),
        'list' => array(
        'slug' => 'list',
        'name' => 'List',
        'description' => 'The List layout promotes functionality and displays one book per line in a sortable list',
        )
	);
     return $layouts;
}

//Valid grid width choices
function wprl_get_valid_grid_num() {
     $width = array(
     	'1' => array(
	'slug' => 'One',
        'value' => '1',
        ),
     	'2' => array(
	'slug' => 'Two',
        'value' => '2',
        ),
        '3' => array(
	'slug' => 'Three',
        'value' => '3',
        ),
        '4' => array(
	'slug' => 'Four',
        'value' => '4',
        ),
       	'3' => array(
	'slug' => 'Three',
        'value' => '3',
        ), 
        '5' => array(
	'slug' => 'Five',
        'value' => '5',
        ),
       	'6' => array(
	'slug' => 'Six',
        'value' => '6',
        ),
	'7' => array(
	'slug' => 'Seven',
        'value' => '7',
        ),
      	'8' => array(
	'slug' => 'Eight',
        'value' => '8',
        ),
        '9' => array(
	'slug' => 'Nine',
        'value' => '9',
        ),
        '10' => array(
	'slug' => 'Ten',
        'value' => '10',
        )
        );
     return $width ;
}

//Layout setting selector
function wprl_settings_layouts() {
	$wprl_options = get_option('wprl_plugin_options');
	$wprl_layouts = wprl_get_valid_layouts();
	$i = 0;
     	foreach ($wprl_layouts as $layout) {
          	$currentlayout = ($layout ['slug'] == $wprl_options ['layout'] ? true : false); ?>
                <input type="radio" id="<?php _e($layout['slug']); ?>" name="wprl_plugin_options[layout]" <?php checked($currentlayout)?> value="<?php _e($layout['slug']);?>"/>
		<label for="<?php _e($layout['slug']); ?>"><?php _e($layout['name']);?>: </label>
		<?php _e($layout['description']);?><br/>     
	<?}
}

//Grid options setting selector
function wprl_settings_grid_width() {
     	$wprl_options = get_option('wprl_plugin_options');
     	$wprl_nums = wprl_get_valid_grid_num();
     	$currentwidth= $wprl_options ['grid_width'];
     	$i = 0; ?>
     	<select id="wprl-options-grid-width" class="grid-nums" name="wprl_plugin_options[grid_width]" value="<?php _e($wprl_options['grid_width']);?>">
     	<? foreach ($wprl_nums as $width) {
     	     	if ($i > 3)
                {
                      	break;
                } ?>
                <option <?php selected($width['value'], $currentwidth)?> value="<?php _e($width['value']);?>"><?php _e($width['slug']);?></option>
	<?php $i++; } ?>
<?}

//Number of grid rows setting
function wprl_settings_grid_rows() {
     	$wprl_options = get_option('wprl_plugin_options');
     	$wprl_nums = wprl_get_valid_grid_num();
     	$currentrows = $wprl_options ['grid_rows'];
     	$i = 0; ?>
     	<select id="wprl-options-grid-tall" class="grid-nums" name="wprl_plugin_options[grid_rows]" value="<?php _e($wprl_options['grid_rows']);?>">
	<? foreach ($wprl_nums as $rows) { ?>
                <option <?php selected($rows['value'], $currentrows)?> value="<?php _e($rows['value']);?>"><?php _e($rows['slug']);?></option>
	<?php } ?>
	</select>
<? }

//Book cover size setting
function wprl_settings_size() {
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-grid-width" name="wprl_plugin_options[cover_width_grid]" size="4" value="<?php _e($wprl_options['cover_width_grid']);?>" onchange="numValGrid()"/>
        <input type="text" id="wprl-options-grid-height" name="wprl_plugin_options[cover_height_grid]" size="4" value="<?php _e($wprl_options['cover_height_grid']);?>"readonly/>
	<? _e('<p>(Sizes are enforced to a 3:4 aspect ratio and capped at a 600px by 800px maximum and 60px by 80px minimum.)</p>', 'wprl_options' );
}

//Show date setting 
function wprl_settings_date() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-date" name="wprl_plugin_options[show_post_date]"<? if($wprl_options['show_post_date']){_e('checked="checked"');} ?> value="show-post-date"/>
<? }

//Show books on homepage setting 
function wprl_settings_homepage() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-homepage" name="wprl_plugin_options[books_in_feed]"<? if($wprl_options['books_in_feed']){_e('checked="checked"');} ?> value="books-in-feed"/>
	<? _e('<p>If you would like to show your books as part of your feed on the homepage and as search results.</p>', 'wprl_options' );
}

//Show book author setting 
function wprl_settings_author() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-author" name="wprl_plugin_options[show_author]"<? if($wprl_options['show_author']){_e('checked="checked"');} ?> value="show-author"/>
<? }

//Show cover image url setting 
function wprl_settings_show_url() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-url" name="wprl_plugin_options[show_url]"<? if($wprl_options['show_url']){_e('checked="checked"');} ?> value="show-url"/>
<? }

//Show page numbers setting 
function wprl_settings_page_nums() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-page-nums" name="wprl_plugin_options[show_page_nums]"<? if($wprl_options['show_page_nums']){_e('checked="checked"');} ?> value="show-page-nums"/>
<? }

//Delete books setting
function wprl_settings_delete() {
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="checkbox" id="wprl-options-delete" name="wprl_plugin_options[delete]" value="<?php _e($wprl_options['delete']);?>" onclick="if(this.checked){deleteConfirm()}"/>
	<? _e('<p>Everyone needs a fresh start sometimes.  Check if you would like to delete your books and authors. However, please realize that this is permanent; there is no way back.</p>', 'wprl_options');
}

//Single book title
function wprl_settings_single(){
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-title" name="wprl_plugin_options[title]" size="30" value="<?php _e($wprl_options['title']);?>" onchange="titleCheck()" />
	<? _e('<p>What are you writing about? Notes, a review, fan fiction, ...?</p>', 'wprl_options');
}

//Muliple book or layout title
function wprl_settings_multiple(){
	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-multiple-title" name="wprl_plugin_options[multiple_title]" size="30" value="<?php _e($wprl_options['multiple_title']);?>" onchange="titleCheck()" />
	<? _e('<p>What do you want to call your list of books?</p>', 'wprl_options');
}

function wprl_settings_list_size(){
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-list-size" name="wprl_plugin_options[list_size]" size="4" value="<?php _e($wprl_options['list_size']);?>" onchange="rowCheck()" />
	<? _e('<p>Show up to 50 items in your list.</p>', 'wprl_options');
}

function wprl_options_validate_helper($setting, $input){
	if(isset($input[$setting]))
        {
         	return true;
        }
	else{
		return false;
	}
}

function wprl_options_validate($input) {
     	$valid_input = get_option('wprl_plugin_options'); 
     	$wprl_defaults=wprl_default_options();
     	$submit = (!empty( $input['submit']) ? true : false);
     	$reset = (!empty($input['reset']) ? true : false);

     	if ( $submit) { // if General Settings Submit
     		$valid_layouts = wprl_get_valid_layouts();
     		$valid_grid_height = wprl_get_valid_grid_num();
         	if (is_numeric($input['cover_width_grid']) && is_numeric($input['cover_height_grid']))
         	{
	         	$valid_input['cover_width_grid'] = sanitize_text_field($input['cover_width_grid']);
	         	$valid_input['cover_height_grid'] = sanitize_text_field($input['cover_height_grid']);
         	}
         	else
         	{
	         	$valid_input['cover_width_grid'] = $wprl_defaults['cover_width_grid'];
	         	$valid_input['cover_height_grid'] = $wprl_defaults['cover_height_grid'];
         	}
		if(isset($input['delete']))
         	{
         		$valid_input['delete'] = delete_books();
         	}
		else{
			$valid_input['delete'] = false;
		}
		if (is_numeric($input['list_size']))
		{
			$valid_input['list_size'] = sanitize_text_field($input['list_size']);
		}
		if ($input['grid_width'] > 0 && $input['grid_width'] < 5)
		{
			$valid_input['grid_width'] = $input['grid_width'];
		}
		$valid_input['books_in_feed'] = wprl_options_validate_helper('books_in_feed', $input);
         	$valid_input['show_post_date'] = wprl_options_validate_helper('show_post_date', $input);
         	$valid_input['show_page_nums'] = wprl_options_validate_helper('show_page_nums', $input);
         	$valid_input['show_author'] = wprl_options_validate_helper('show_author', $input);
         	$valid_input['show_url'] = wprl_options_validate_helper('show_url', $input);
		$valid_input['layout'] = (array_key_exists($input['layout'], $valid_layouts) ? $input['layout'] : $valid_input['layout'] );
		$valid_input['title'] = sanitize_text_field($input['title']);
		$valid_input['multiple_title'] = sanitize_text_field($input['multiple_title']);
		$valid_input['grid_rows'] = (array_key_exists($input['grid_rows'], $valid_grid_height) ? $input['grid_rows'] : $valid_input['grid_rows'] );
     	} 
     	elseif ($reset) { // if General Settings Reset Defaults
       		$valid_input = $wprl_defaults;
     	}
     	return $valid_input;
}
function wprl_enqueue($hook){
	if ('settings_page_wprl-options' == $hook){
	        wp_register_script('wprl-admin-script', plugins_url('wp-reading-list/wprl-admin/wp-reading-list-admin-script.js'));  
	        wp_enqueue_script('wprl-admin-script');
	        wp_register_style('wprl-admin-style', plugins_url('wp-reading-list/wprl-admin/wp-reading-list-admin-style.css'));  
        	wp_enqueue_style('wprl-admin-style');
        }
        else
        {
	        wp_register_script('wprl-core-script', plugins_url('wp-reading-list/wprl-core/wp-reading-list-core-script.js'));  
		wp_enqueue_script('wprl-core-script');
	        wp_register_style('wprl-core-style', plugins_url('wp-reading-list/wprl-core/wp-reading-list-core-style.css'));  
        	wp_enqueue_style('wprl-core-style');
		add_action('edit_form_advanced', 'force_post_title');
        }
}

//use single entry with array of options
function register_wprl_settings() {
	register_setting('wprl_plugin_options', 'wprl_plugin_options', 'wprl_options_validate');
	add_settings_section('wprl_settings_layout', 'Layout', '', 'wprl_options');
	add_settings_field('wprl_settings_layouts', 'Available Layouts', 'wprl_settings_layouts', 'wprl_options', 'wprl_settings_layout');
	add_settings_field('wprl_settings_size', 'Grid Cover Size', 'wprl_settings_size', 'wprl_options', 'wprl_settings_layout');
	add_settings_field('wprl_settings_grid_width', 'Grid Width', 'wprl_settings_grid_width', 'wprl_options', 'wprl_settings_layout');
	add_settings_field('wprl_settings_grid_height', 'Number of Grid Rows', 'wprl_settings_grid_rows', 'wprl_options', 'wprl_settings_layout');
	add_settings_field('wprl_settings_list_size', 'Number of List Rows', 'wprl_settings_list_size', 'wprl_options', 'wprl_settings_layout');
	add_settings_section('wprl_settings_layout_options', 'Display Options', '', 'wprl_options');
	add_settings_field('wprl_settings_show_url', 'Show Cover Image URL', 'wprl_settings_show_url', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_field('wprl_settings_author', 'Show Book Author/s', 'wprl_settings_author', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_field('wprl_settings_page_nums', 'Show Page Numbers', 'wprl_settings_page_nums', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_field('wprl_settings_date', 'Show Date Published', 'wprl_settings_date', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_section('wprl_settings_appearance', 'Appearance', '', 'wprl_options');
	add_settings_field('wprl_settings_homepage', 'Show Books on Homepage', 'wprl_settings_homepage', 'wprl_options', 'wprl_settings_appearance');
	add_settings_field('wprl_settings_single', 'Single Book Header', 'wprl_settings_single', 'wprl_options', 'wprl_settings_appearance');
	add_settings_field('wprl_settings_multiple', 'Layout Header', 'wprl_settings_multiple', 'wprl_options', 'wprl_settings_appearance');
	add_settings_section('wprl_settings_admin', 'Admin', '', 'wprl_options');
	add_settings_field('wprl_settings_delete', 'Delete All Books & Authors?', 'wprl_settings_delete', 'wprl_options', 'wprl_settings_admin');
}

function wprl_featured_image_html($content) {
    return $content = str_replace( __('Set featured image'), __('Set cover image'), $content);
}

function wprl_featured_image_mod($title) {
     return $title = str_replace('Featured Image', 'Book Cover', $title);
}

add_filter('admin_post_thumbnail_html', 'wprl_featured_image_html' );
add_filter('gettext', 'wprl_featured_image_mod');
add_filter('ngettext', 'wprl_featured_image_mod');

/*
*End of File
*/