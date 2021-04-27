<?
/*FILE: wp-reading-list-admin-functions.php
*DESCRIPTION: Plugin admin functions
*/
//default cover image picker
//change name of taxonomy
//page ranges support

//Valid layout choices
function wprl_get_valid_layouts() {
     $layouts = array(
	'grid' => array(
	'slug' => 'grid',
        'name' => 'Grid',
        'description' => 'Display multiple books per line',
        ),
        'list' => array(
        'slug' => 'list',
        'name' => 'List',
        'description' => 'Display one book per line',
        )
	);
     return $layouts;
}

//Valid order directions
function wprl_get_valid_directions() {
     $layouts = array(
	'ASC' => array(
	'slug' => 'ASC',
        'name' => 'Ascending',
        ),
        'DESC' => array(
        'slug' => 'DESC',
        'name' => 'Descending',
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

//Valid order by choices
function wprl_get_valid_order_by() {
     $width = array(
     	'date' => array(
	'slug' => 'Date',
        'value' => 'date',
        ),
     	'author' => array(
	'slug' => 'Post Author',
        'value' => 'author',
        ),
        'rand' => array(
	'slug' => 'Random',
        'value' => 'rand',
        ),
        'title' => array(
	'slug' => 'Title',
        'value' => 'title',
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

//Order direction setting 
function wprl_settings_list_direction() {
	$wprl_options = get_option('wprl_plugin_options');
	$wprl_directions = wprl_get_valid_directions();
     	foreach ($wprl_directions as $direction) {
          	$currentdirection = ($direction['slug'] == $wprl_options['direction'] ? true : false); ?>
                <input type="radio" id="<?php _e($direction['slug']); ?>" name="wprl_plugin_options[direction]" <?php checked($currentdirection)?> value="<?php _e($direction['slug']);?>"/>
		<label for="<?php _e($direction['slug']); ?>"><?php _e($direction['name']);?></label><br/>
	<?}
}

//Grid width setting 
function wprl_settings_grid_width() {
     	$wprl_options = get_option('wprl_plugin_options');
     	$wprl_nums = wprl_get_valid_grid_num();
     	$i = 0; ?>
     	<select id="wprl-options-grid-width" name="wprl_plugin_options[grid_width]" value="<?php _e($wprl_options['grid_width']);?>">
     	<? foreach ($wprl_nums as $width) {
     	     	if ($i > 3)
                {
                      	break;
                } ?>
                <option <?php selected($width['value'], $wprl_options ['grid_width'])?> value="<?php _e($width['value']);?>"><?php _e($width['slug']);?></option>
	<?php $i++; } ?>
<?}

//Book cover size setting
function wprl_settings_size() {
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-cover-width" name="wprl_plugin_options[cover_width_grid]" size="4" value="<?php _e($wprl_options['cover_width_grid']);?>" onchange="numValGrid()"/>
        <input type="text" id="wprl-options-cover-height" name="wprl_plugin_options[cover_height_grid]" size="4" value="<?php _e($wprl_options['cover_height_grid']);?>"readonly/>
	<? _e('<p class="margin">(Sizes are enforced to a 3:4 aspect ratio and capped at a 600px by 800px maximum and 60px by 80px minimum.)</p>', 'wprl_options' );
}

//Number of grid rows setting
function wprl_settings_grid_rows() {
     	$wprl_options = get_option('wprl_plugin_options');
     	$wprl_nums = wprl_get_valid_grid_num(); ?>
     	<select id="wprl-options-grid-tall" name="wprl_plugin_options[grid_rows]" value="<?php _e($wprl_options['grid_rows']);?>">
	<? foreach ($wprl_nums as $rows) { ?>
                <option <?php selected($rows['value'],  $wprl_options ['grid_rows'])?> value="<?php _e($rows['value']);?>"><?php _e($rows['slug']);?></option>
	<?php } ?>
	</select>
<? }

//Order by setting
function wprl_settings_list_order (){
     	$wprl_options = get_option('wprl_plugin_options');
     	$wprl_orders = wprl_get_valid_order_by(); ?>
     	<select id="wprl-options-list-order" name="wprl_plugin_options[order]" value="<?php _e($wprl_options['order']);?>">
	<? foreach ($wprl_orders as $orders) { ?>
                <option <?php selected($orders['value'],  $wprl_options ['order'])?> value="<?php _e($orders['value']);?>"><?php _e($orders['slug']);?></option>
	<?php } ?>
	</select>
<? }

//Show date setting 
function wprl_settings_date() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-date" name="wprl_plugin_options[show_post_date]"<? if($wprl_options['show_post_date']){_e('checked="checked"');} ?> value="show-post-date"/>
<? }

//Show books on homepage setting 
function wprl_settings_homepage() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-homepage" name="wprl_plugin_options[books_in_feed]"<? if($wprl_options['books_in_feed']){_e('checked="checked"');} ?> value="books-in-feed"/>
	<? _e('<p class="margin">Shows Reading List items on the homepage and in search results</p>', 'wprl_options' );
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

//Show single book link setting 
function wprl_settings_book_link() {
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-book-link" name="wprl_plugin_options[show_book]"<? if($wprl_options['show_book']){_e('checked="checked"');} ?> value="show-book-link"/>
<? }

//Show image in list layout setting
function wprl_settings_list_image(){
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-list-image" name="wprl_plugin_options[list_image]"<? if($wprl_options['list_image']){_e('checked="checked"');} ?> value="show-list-image"/>
<? }

//Show post author setting
function wprl_settings_post_author(){
     	$wprl_options = get_option('wprl_plugin_options');?>
     	<input type="checkbox" id="wprl-options-post-author" name="wprl_plugin_options[post_author]"<? if($wprl_options['post_author']){_e('checked="checked"');} ?> value="show-post-author"/>
     	<? _e('<p class="margin">(If you wish to enable this, it is recommended that you also turn on the "Display on Whole Site" setting)</p>');
}

//Delete books setting
function wprl_settings_delete() {
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="checkbox" id="wprl-options-delete" name="wprl_plugin_options[delete]" value="<?php _e($wprl_options['delete']);?>" onclick="if(this.checked){deleteConfirm()}"/>
	<? _e('<p class="margin">Everyone needs a fresh start sometimes.  Check if you would like to delete your Reading List items and authors. However, please realize that this is permanent; there is no way back.</p>', 'wprl_options');
}

//Single book title
function wprl_settings_single(){
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-title" name="wprl_plugin_options[title]" size="30" value="<?php _e($wprl_options['title']);?>" onchange="titleCheck()" />
	<? _e('<p class="margin">What are you writing about? Notes, a review, fan fiction, ...?</p>', 'wprl_options');
}

//Multiple book or layout title
function wprl_settings_multiple(){
	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-multiple-title" name="wprl_plugin_options[multiple_title]" size="30" value="<?php _e($wprl_options['multiple_title']);?>" onchange="titleCheck()" />
	<? _e('<p class="margin">What do you want to call your list of items?</p>', 'wprl_options');
}

//List size setting
function wprl_settings_list_size(){
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-list-size" name="wprl_plugin_options[list_size]" size="4" value="<?php _e($wprl_options['list_size']);?>" onchange="rowCheck()" />
	<? _e('<p class="margin">Show up to 50 items in your list</p>', 'wprl_options');
}

//Margin left setting
function wprl_settings_margin_left(){
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-margin-left" name="wprl_plugin_options[css_margin_left]" size="4" value="<?php _e($wprl_options['css_margin_left']);?>" onchange="marginCheck()" />
	<? _e('%<p class="margin">Distance of the layout from the left of the screen</p>', 'wprl_options' );

}

//Cover spacing in grid layout setting
function wprl_settings_padding(){
     	$wprl_options = get_option('wprl_plugin_options');?>
        <input type="text" id="wprl-options-padding" name="wprl_plugin_options[padding]" size="4" value="<?php _e($wprl_options['padding']);?>" onchange="paddingCheck()" />
	<? _e('%', 'wprl_options' );
}

//validate checkboxes
function wprl_options_validate_helper($setting, $input){
	if(isset($input[$setting]))
        {
         	return true;
        }
	else{
		return false;
	}
}

//validate numbers given ranges
function wprl_options_validate_helper_numCheck($setting, $input, $wprl_defaults, $num1, $num2){
	if(is_nan($input[$setting]) || $input[$setting] > $num1 || $input[$setting] < $num2)
        {
         	return sanitize_text_field($input[$setting]);
        }
	else{
		return $wprl_defaults[$setting];
	}
}

function wprl_options_validate($input) {
     	$valid_input = get_option('wprl_plugin_options'); 
     	$wprl_defaults=wprl_default_options();
     	$submit = (!empty( $input['submit']) ? true : false);
     	$reset = (!empty($input['reset']) ? true : false);

     	if ($submit) {
     		$valid_layouts = wprl_get_valid_layouts();
     		$valid_direction = wprl_get_valid_directions();
     		$valid_grid_height = wprl_get_valid_grid_num(); 
     		$valid_order = wprl_get_valid_order_by();         	
		if(isset($input['delete']))
         	{
         		$valid_input['delete'] = delete_books();
         	}
		else{
			$valid_input['delete'] = false;
		}
		$valid_input['cover_width_grid'] = wprl_options_validate_helper_numCheck('cover_width_grid', $input, $wprl_defaults, 60, 600);;
	        $valid_input['cover_height_grid'] = wprl_options_validate_helper_numCheck('cover_height_grid', $input, $wprl_defaults, 80, 800);
		$valid_input['grid_width'] = wprl_options_validate_helper_numCheck('grid_width', $input, $wprl_defaults, 1, 4);
		$valid_input['css_margin_left'] = wprl_options_validate_helper_numCheck('css_margin_left', $input, $wprl_defaults, 0, 100);
		$valid_input['padding'] = wprl_options_validate_helper_numCheck('padding', $input, $wprl_defaults, 0, 100);
		$valid_input['list_size'] = wprl_options_validate_helper_numCheck('list_size', $input, $wprl_defaults, 1, 50);
		$valid_input['books_in_feed'] = wprl_options_validate_helper('books_in_feed', $input);
         	$valid_input['show_post_date'] = wprl_options_validate_helper('show_post_date', $input);
         	$valid_input['show_page_nums'] = wprl_options_validate_helper('show_page_nums', $input);
         	$valid_input['show_author'] = wprl_options_validate_helper('show_author', $input);
         	$valid_input['post_author'] = wprl_options_validate_helper('post_author', $input);
         	$valid_input['list_image'] = wprl_options_validate_helper('list_image', $input);
         	$valid_input['show_url'] = wprl_options_validate_helper('show_url', $input);
         	$valid_input['show_book'] = wprl_options_validate_helper('show_book', $input);
         	$valid_input['order'] = (array_key_exists($input['order'], $valid_order) ? $input['order'] : $valid_input['order'] );
         	$valid_input['direction'] = (array_key_exists($input['direction'], $valid_direction) ? $input['direction'] : $valid_input['direction'] );
		$valid_input['grid_rows'] = (array_key_exists($input['grid_rows'], $valid_grid_height) ? $input['grid_rows'] : $valid_input['grid_rows'] );
		$valid_input['layout'] = (array_key_exists($input['layout'], $valid_layouts) ? $input['layout'] : $valid_input['layout'] );
		$valid_input['title'] = sanitize_text_field($input['title']);
		$valid_input['multiple_title'] = sanitize_text_field($input['multiple_title']);
     	} 
     	elseif ($reset) {
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
        elseif (is_admin() && 'books' == get_post_type())
        {
	        wp_register_script('wprl-core-script', plugins_url('wp-reading-list/wprl-core/wp-reading-list-core-script.js'));  
		wp_enqueue_script('wprl-core-script');
	        wp_register_style('wprl-core-style', plugins_url('wp-reading-list/wprl-core/wp-reading-list-core-style.css'));  
        	wp_enqueue_style('wprl-core-style');
        }
}

//use single entry with array of options
function register_wprl_settings() {
	register_setting('wprl_plugin_options', 'wprl_plugin_options', 'wprl_options_validate');
	add_settings_section('wprl_settings_layout_options', 'Layout', '', 'wprl_options');
	add_settings_field('wprl_settings_layouts', 'Available Layouts', 'wprl_settings_layouts', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_field('wprl_settings_list_order', 'Order Posts By', 'wprl_settings_list_order', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_field('wprl_settings_list_direction', 'Order Direction', 'wprl_settings_list_direction', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_field('wprl_settings_margin_left', 'Left Margin', 'wprl_settings_margin_left', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_field('wprl_settings_padding', 'Layout Item Spacing', 'wprl_settings_padding', 'wprl_options', 'wprl_settings_layout_options');
	add_settings_section('wprl_settings_grid_layout', 'Grid', '', 'wprl_options');
	add_settings_field('wprl_settings_grid_width', 'Grid Width', 'wprl_settings_grid_width', 'wprl_options', 'wprl_settings_grid_layout');
	add_settings_field('wprl_settings_grid_height', 'Number of Grid Rows', 'wprl_settings_grid_rows', 'wprl_options', 'wprl_settings_grid_layout');
	add_settings_section('wprl_settings_list_layout', 'List', '', 'wprl_options');
	add_settings_field('wprl_settings_list_size', 'Number of List Items', 'wprl_settings_list_size', 'wprl_options', 'wprl_settings_list_layout');
	add_settings_field('wprl_settings_list_image', 'Show Cover Image', 'wprl_settings_list_image', 'wprl_options', 'wprl_settings_list_layout');
	add_settings_field('wprl_settings_size', 'Book Cover Size', 'wprl_settings_size', 'wprl_options', 'wprl_settings_list_layout');
	add_settings_section('wprl_settings_layout_dispay', 'Display', '', 'wprl_options');
	add_settings_field('wprl_settings_show_url', 'Show Cover Image Link', 'wprl_settings_show_url', 'wprl_options', 'wprl_settings_layout_dispay');
	add_settings_field('wprl_settings_book_link', 'Show Link to Single Post', 'wprl_settings_book_link', 'wprl_options', 'wprl_settings_layout_dispay');	
	add_settings_field('wprl_settings_author', 'Show Item Author/s', 'wprl_settings_author', 'wprl_options', 'wprl_settings_layout_dispay');
	add_settings_field('wprl_settings_post_author', 'Show Post Author', 'wprl_settings_post_author', 'wprl_options', 'wprl_settings_layout_dispay');
	add_settings_field('wprl_settings_date', 'Show Date Published', 'wprl_settings_date', 'wprl_options', 'wprl_settings_layout_dispay');
	add_settings_field('wprl_settings_page_nums', 'Show Page Numbers', 'wprl_settings_page_nums', 'wprl_options', 'wprl_settings_layout_dispay');
	add_settings_section('wprl_settings_appearance', 'General', '', 'wprl_options');
	add_settings_field('wprl_settings_homepage', 'Display on Whole Site', 'wprl_settings_homepage', 'wprl_options', 'wprl_settings_appearance');
	add_settings_field('wprl_settings_single', 'Single Post Header', 'wprl_settings_single', 'wprl_options', 'wprl_settings_appearance');
	add_settings_field('wprl_settings_multiple', 'Layout Header', 'wprl_settings_multiple', 'wprl_options', 'wprl_settings_appearance');
	add_settings_section('wprl_settings_admin', 'Admin', '', 'wprl_options');
	add_settings_field('wprl_settings_delete', 'Delete All', 'wprl_settings_delete', 'wprl_options', 'wprl_settings_admin');
}

function wprl_featured_image_html($content) {
	if (is_admin() && 'books' == get_post_type())
        {
		$content = str_replace(__('Set featured image'), __('Set cover image'), $content);
		return $content = str_replace(__('Remove featured image'), __('Remove cover image'), $content);

	}
	else
	{
		return $content;
	}
}

function wprl_featured_image_mod($title) {
	if (is_admin() && 'books' == get_post_type())
        {
     		return $title = str_replace('Featured Image', 'Cover Image', $title);
     	}
	else
	{
		return $title;
	}
}

/*
*End of File
*/