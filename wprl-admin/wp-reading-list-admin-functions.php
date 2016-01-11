<?php
/*FILE: wp-reading-list-admin-functions.php
*DESCRIPTION: Plugin admin functions
*/

/*Valid layout choices */
function wprl_get_valid_layouts() {
    $layouts = array(
        'grid' => array(
            'slug' => 'grid',
            'name' => 'Grid',
            'description' => 'Display multiple items per line',
        ),
        'list' => array(
            'slug' => 'list',
            'name' => 'List',
            'description' => 'Display one item per line',
        )
    );
    return $layouts;
}

/*Valid order directions */
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

/*Valid grid width choices */
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

/*Valid order by choices */
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


/*Layout setting selector */
function wprl_settings_layouts() {
    $wprl_options = get_option('wprl_plugin_options');
    $wprl_layouts = wprl_get_valid_layouts();
    $i = 0;
    foreach ($wprl_layouts as $layout) {
        $currentlayout = ($layout ['slug'] == $wprl_options ['layout'] ? true : false); ?>
        <input type="radio" id="<?php echo ($layout['slug']); ?>" name="wprl_plugin_options[layout]" <?php checked($currentlayout)?> value="<?php echo ($layout['slug']);?>"/>
        <label for="<?php echo ($layout['slug']); ?>"><?php echo ($layout['name']);?>: </label>
        <?php echo ($layout['description']);?><br/>
    <?php }
}

/*Order direction setting  */
function wprl_settings_list_direction() {
    $wprl_options = get_option('wprl_plugin_options');
    $wprl_directions = wprl_get_valid_directions();
    foreach ($wprl_directions as $direction) {
        $currentdirection = ($direction['slug'] == $wprl_options['direction'] ? true : false); ?>
        <input type="radio" id="<?php echo ($direction['slug']); ?>" name="wprl_plugin_options[direction]" <?php checked($currentdirection)?> value="<?php echo ($direction['slug']);?>"/>
        <label for="<?php echo ($direction['slug']); ?>"><?php echo ($direction['name']);?></label><br/>
    <?php }
}

/*Grid width setting  */
function wprl_settings_grid_width() {
    $wprl_options = get_option('wprl_plugin_options');
    $wprl_nums = wprl_get_valid_grid_num();
    $i = 0; ?>
    <select id="wprl-options-grid-width" name="wprl_plugin_options[grid_width]" value="<?php echo ($wprl_options['grid_width']);?>">
    <?php foreach ($wprl_nums as $width) {
        if ($i > 3) {
            break;
        } ?>
        <option <?php selected($width['value'], $wprl_options ['grid_width'])?> value="<?php echo ($width['value']);?>"><?php echo ($width['slug']);?></option>
        <?php $i++;
    }
    echo ('</select><p class="margin">');_e('Number of works in each row.', 'wp_reading_list' );echo ('</p>');
}

/* cover size setting */
function wprl_settings_size() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="text" id="wprl-options-cover-width" name="wprl_plugin_options[cover_width_grid]" size="4" value="<?php echo ($wprl_options['cover_width_grid']);?>" onchange="numValGrid()"/>
    <input type="text" id="wprl-options-cover-height" name="wprl_plugin_options[cover_height_grid]" size="4" value="<?php echo ($wprl_options['cover_height_grid']);?>"readonly/>
    <?php echo ('<p class="margin">');_e('Sizes are enforced to a 3:4 aspect ratio and capped at a 600px by 800px maximum and 60px by 80px minimum.', 'wp_reading_list' );echo ('</p>');
}

/*Number of grid rows setting */
function wprl_settings_grid_rows() {
    $wprl_options = get_option('wprl_plugin_options');
    $wprl_nums = wprl_get_valid_grid_num(); ?>
    <select id="wprl-options-grid-tall" name="wprl_plugin_options[grid_rows]" value="<?php echo ($wprl_options['grid_rows']);?>">
        <?php foreach ($wprl_nums as $rows) { ?>
            <option <?php selected($rows['value'],  $wprl_options ['grid_rows'])?> value="<?php echo ($rows['value']);?>"><?php echo ($rows['slug']);?></option>
        <?php } ?>
    </select><p class="margin"><?php _e('Number of rows on each page.', 'wp_reading_list' );?></p>
<?php }

/*Order by setting */
function wprl_settings_list_order (){
    $wprl_options = get_option('wprl_plugin_options');
    $wprl_orders = wprl_get_valid_order_by(); ?>
    <select id="wprl-options-list-order" name="wprl_plugin_options[order]" value="<?php echo ($wprl_options['order']);?>">
        <?php foreach ($wprl_orders as $orders) { ?>
            <option <?php selected($orders['value'],  $wprl_options ['order'])?> value="<?php echo ($orders['value']);?>"><?php echo ($orders['slug']);?></option>
        <?php } ?>
    </select>
<?php }

/*Show date setting  */
function wprl_settings_date() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-date" name="wprl_plugin_options[show_post_date]"<?php if($wprl_options['show_post_date']){echo ('checked="checked"');} ?> value="show-post-date"/>
<?php }

/*Show reading list items on homepage setting  */
function wprl_settings_homepage() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-homepage" name="wprl_plugin_options[works_in_feed]"<?php if($wprl_options['works_in_feed']){echo ('checked="checked"');} ?> value="works-in-feed"/>
    <?php echo('<p class="margin">');_e('Shows Reading List items on the homepage and in search results', 'wprl_options' );echo ('</p>');
}

/*Override default theme taxonomy pages  */
function wprl_settings_override_taxonomy() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-override-taxonomy" name="wprl_plugin_options[override_theme_taxonomies]"<?php if($wprl_options['override_theme_taxonomies']){echo ('checked="checked"');} ?> value="taxonomy-override"/>
    <?php echo('<p class="margin">');_e("Use the plugin's taxonomy pages for work authors and work types instead of your theme's pages", 'wprl_options' );echo ('</p>');
}

/*Show item author setting  */
function wprl_settings_author() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-author" name="wprl_plugin_options[show_author]"<?php if($wprl_options['show_author']){echo ('checked="checked"');} ?> value="show-author"/>
<?php }

/*Show author link setting  */
function wprl_settings_author_link() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-author-link" name="wprl_plugin_options[show_author_link]"<?php if($wprl_options['show_author_link']){echo ('checked="checked"');} ?> value="author-link"/>
<?php }

/*Show cover image url setting  */
function wprl_settings_show_url() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-url" name="wprl_plugin_options[show_url]"<?php if($wprl_options['show_url']){echo ('checked="checked"');} ?> value="show-url"/>
<?php }

/*Show page numbers setting  */
function wprl_settings_page_nums() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-page-nums" name="wprl_plugin_options[show_page_nums]"<?php if($wprl_options['show_page_nums']){echo ('checked="checked"');} ?> value="show-page-nums"/>
<?php }

/*Show single item link setting  */
function wprl_settings_work_link() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-work-link" name="wprl_plugin_options[show_single_work]"<?php if($wprl_options['show_single_work']){echo ('checked="checked"');} ?> value="show-work-link"/>
<?php }

/*Show image in list layout setting */
function wprl_settings_list_image(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-list-image" name="wprl_plugin_options[list_image]"<?php if($wprl_options['list_image']){echo ('checked="checked"');} ?> value="show-list-image"/>
<?php }

/*Show post author setting */
function wprl_settings_post_author(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-post-author" name="wprl_plugin_options[post_author]"<?php if($wprl_options['post_author']){echo ('checked="checked"');} ?> value="show-post-author"/>
    <?php echo ('<p class="margin">');_e('(If you wish to enable this, it is recommended that you also turn on the "Display on Whole Site" setting)', 'wp_reading_list');echo ('</p>');
}

/*Show list excerpt  */
function wprl_settings_show_list_excerpt() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-list-excerpt" name="wprl_plugin_options[show_list_excerpt]"<?php if($wprl_options['show_list_excerpt']){echo ('checked="checked"');} ?> value="show-list-excerpt"/>
<?php }

/*Show work type  */
function wprl_settings_show_work_type() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-work-type" name="wprl_plugin_options[show_work_type]"<?php if($wprl_options['show_work_type']){echo ('checked="checked"');} ?> value="show-work-type"/>
<?php }

/*Show work type link  */
function wprl_settings_show_type_link() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-type-link" name="wprl_plugin_options[show_type_link]"<?php if($wprl_options['show_type_link']){echo ('checked="checked"');} ?> value="show-type-link"/>
<?php }

/*Delete items setting */
function wprl_settings_delete() {
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="checkbox" id="wprl-options-delete" name="wprl_plugin_options[delete]" value="<?php echo ($wprl_options['delete']);?>" onclick="if(this.checked){deleteConfirm()}"/>
    <?php echo('<p class="margin">');_e('Everyone needs a fresh start sometimes.  Check if you would like to delete your Reading List items and authors. However, please realize that this is permanent; there is no way back.', 'wp_reading_list'); echo('</p>');
}

/*Single item title */
function wprl_settings_single(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="text" id="wprl-options-title" name="wprl_plugin_options[title]" size="30" value="<?php echo ($wprl_options['title']);?>" onchange="titleCheck()" />
    <?php echo ('<p class="margin">');_e('What are you writing about? Notes, a review, fan fiction, ...?', 'wp_reading_list'); echo ('</p>');
}

/*Multiple item or layout title */
function wprl_settings_multiple(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="text" id="wprl-options-multiple-title" name="wprl_plugin_options[multiple_title]" size="30" value="<?php echo ($wprl_options['multiple_title']);?>" onchange="layoutHeaderCheck()" />
    <?php echo('<p class="margin">');_e('What do you want to call your list of items?', 'wp_reading_list'); echo('</p>');
}

/*List size setting */
function wprl_settings_list_size(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="text" id="wprl-options-list-size" name="wprl_plugin_options[list_size]" size="4" value="<?php echo ($wprl_options['list_size']);?>" onchange="rowCheck()" />
    <?php echo('<p class="margin">');_e('Show up to 50 items in your list', 'wp_reading_list'); echo('</p>');
}

/*Margin left setting */
function wprl_settings_margin_left(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="text" id="wprl-options-margin-left" name="wprl_plugin_options[css_margin_left]" size="4" value="<?php echo ($wprl_options['css_margin_left']);?>" onchange="marginCheck()" />
    <?php echo('%<p class="margin">');_e('Distance of the layout from the left of the screen', 'wp_reading_list');echo('</p>');
}

/*Cover spacing in grid layout setting */
function wprl_settings_padding(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <input type="text" id="wprl-options-padding" name="wprl_plugin_options[padding]" size="4" value="<?php echo ($wprl_options['padding']);?>" onchange="paddingCheck()" />
    <?php echo('%<p class="margin">');_e('Distance between items in the layout', 'wp_reading_list');echo('</p>');
}

/*Cover image setting */
function wprl_settings_cover_image(){
    $wprl_options = get_option('wprl_plugin_options');?>
    <label for="upload_image">
        <input id="wprl-options-cover-image" type="text" size="36" name="wprl_plugin_options[cover_image]" value="<?php echo ($wprl_options['cover_image']);?>" />
        <input id="wprl-options-cover-image-button" class="button" type="button" value="Upload Image" />
    </label>
    <br/><br/>
    <img src="<?php echo ($wprl_options['cover_image']);?>" id="wprl-options-cover-image-preview"/>
<?php }

/*Validate checkboxes helper*/
function wprl_options_validate_helper($setting, $input){
    return isset($input[$setting]);
}

/*validate numbers given ranges helper*/
function wprl_options_validate_helper_numCheck($setting, $input, $wprl_defaults, $num1, $num2){
    if(is_nan($input[$setting]) || $input[$setting] > $num1 || $input[$setting] < $num2) {
        return sanitize_text_field($input[$setting]);
    }
    else{
        return $wprl_defaults[$setting];
    }
}

/*validate master settings input */
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
        if(isset($input['delete'])) {
            $valid_input['delete'] = delete_works();
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
        $valid_input['works_in_feed'] = wprl_options_validate_helper('works_in_feed', $input);
        $valid_input['show_post_date'] = wprl_options_validate_helper('show_post_date', $input);
        $valid_input['show_page_nums'] = wprl_options_validate_helper('show_page_nums', $input);
        $valid_input['show_author'] = wprl_options_validate_helper('show_author', $input);
        $valid_input['show_list_excerpt'] = wprl_options_validate_helper('show_list_excerpt', $input);
        $valid_input['show_work_type'] = wprl_options_validate_helper('show_work_type', $input);
        $valid_input['show_type_link'] = wprl_options_validate_helper('show_type_link', $input);
        $valid_input['show_author_link'] = wprl_options_validate_helper('show_author_link', $input);
        $valid_input['post_author'] = wprl_options_validate_helper('post_author', $input);
        $valid_input['list_image'] = wprl_options_validate_helper('list_image', $input);
        $valid_input['show_url'] = wprl_options_validate_helper('show_url', $input);
        $valid_input['show_single_work'] = wprl_options_validate_helper('show_single_work', $input);
        $valid_input['override_theme_taxonomies'] = wprl_options_validate_helper('override_theme_taxonomies', $input);
        $valid_input['order'] = (array_key_exists($input['order'], $valid_order) ? $input['order'] : $valid_input['order'] );
        $valid_input['direction'] = (array_key_exists($input['direction'], $valid_direction) ? $input['direction'] : $valid_input['direction'] );
        $valid_input['grid_rows'] = (array_key_exists($input['grid_rows'], $valid_grid_height) ? $input['grid_rows'] : $valid_input['grid_rows'] );
        $valid_input['layout'] = (array_key_exists($input['layout'], $valid_layouts) ? $input['layout'] : $valid_input['layout'] );
        $valid_input['title'] = sanitize_text_field($input['title']);
        $valid_input['multiple_title'] = sanitize_text_field($input['multiple_title']);
        $valid_input['cover_image'] = filter_var($input['cover_image'], FILTER_VALIDATE_URL)?$input['cover_image']:$wprl_defaults['cover_image'];
    }
    elseif ($reset) {
        $valid_input = $wprl_defaults;
    }
    return $valid_input;
}

/* add style sheets depending on user's location */
function wprl_enqueue($hook){
    global $version;
    if ('settings_page_wprl-options' == $hook){
        wp_enqueue_media();
        wp_register_script('wprl-admin-script', plugins_url('wp-reading-list/wprl-admin/wp-reading-list-admin-script.js?'.$version));
        wp_enqueue_script('wprl-admin-script');
        wp_register_style('wprl-admin-style', plugins_url('wp-reading-list/wprl-admin/wp-reading-list-admin-style.css?'.$version));
        wp_enqueue_style('wprl-admin-style');
    }
    elseif (is_admin() && 'works' == get_post_type()) {
        wp_register_script('wprl-core-script', plugins_url('wp-reading-list/wprl-core/wp-reading-list-core-script.js?'.$version));
        wp_enqueue_script('wprl-core-script');
        wp_register_style('wprl-core-style', plugins_url('wp-reading-list/wprl-core/wp-reading-list-core-style.css?'.$version));
        wp_enqueue_style('wprl-core-style');
    }
}

/*use single entry with array of options */
function register_wprl_settings() {
    register_setting('wprl_plugin_options', 'wprl_plugin_options', 'wprl_options_validate');
    add_settings_section('wprl_settings_layout_options', 'Layout', '', 'wprl_options');
    add_settings_field('wprl_settings_layouts', 'Available Layouts', 'wprl_settings_layouts', 'wprl_options', 'wprl_settings_layout_options');
    add_settings_field('wprl_settings_list_order', 'Order Posts By', 'wprl_settings_list_order', 'wprl_options', 'wprl_settings_layout_options');
    add_settings_field('wprl_settings_list_direction', 'Order Direction', 'wprl_settings_list_direction', 'wprl_options', 'wprl_settings_layout_options');
    add_settings_field('wprl_settings_margin_left', 'Left Margin', 'wprl_settings_margin_left', 'wprl_options', 'wprl_settings_layout_options');
    add_settings_field('wprl_settings_padding', 'Item Spacing', 'wprl_settings_padding', 'wprl_options', 'wprl_settings_layout_options');
    add_settings_section('wprl_settings_grid_layout', 'Grid', '', 'wprl_options');
    add_settings_field('wprl_settings_grid_width', 'Grid Width', 'wprl_settings_grid_width', 'wprl_options', 'wprl_settings_grid_layout');
    add_settings_field('wprl_settings_grid_height', 'Number of Grid Rows', 'wprl_settings_grid_rows', 'wprl_options', 'wprl_settings_grid_layout');
    add_settings_section('wprl_settings_list_layout', 'List', '', 'wprl_options');
    add_settings_field('wprl_settings_list_size', 'Number of List Items', 'wprl_settings_list_size', 'wprl_options', 'wprl_settings_list_layout');
    add_settings_field('wprl_settings_show_list_excerpt', 'Show Item Excerpt', 'wprl_settings_show_list_excerpt', 'wprl_options', 'wprl_settings_list_layout');
    add_settings_field('wprl_settings_size', 'Cover Size', 'wprl_settings_size', 'wprl_options', 'wprl_settings_list_layout');
    add_settings_section('wprl_settings_layout_dispay', 'Display', '', 'wprl_options');
    add_settings_field('wprl_settings_list_image', 'Show Cover Image', 'wprl_settings_list_image', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_show_url', 'Show Cover Image Link', 'wprl_settings_show_url', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_work_link', 'Show Link to Single Post', 'wprl_settings_work_link', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_author', 'Show Item Author/s', 'wprl_settings_author', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_author_link', 'Show Author/s Archive', 'wprl_settings_author_link', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_show_work_type', 'Show Item Type', 'wprl_settings_show_work_type', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_show_type_link', 'Show Type/s Archive', 'wprl_settings_show_type_link', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_post_author', 'Show Post Author', 'wprl_settings_post_author', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_date', 'Show Date Published', 'wprl_settings_date', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_field('wprl_settings_page_nums', 'Show Page Numbers', 'wprl_settings_page_nums', 'wprl_options', 'wprl_settings_layout_dispay');
    add_settings_section('wprl_settings_appearance', 'General', '', 'wprl_options');
    add_settings_field('wprl_settings_homepage', 'Display on Whole Site', 'wprl_settings_homepage', 'wprl_options', 'wprl_settings_appearance');
    add_settings_field('wprl_settings_single', 'Single Post Header', 'wprl_settings_single', 'wprl_options', 'wprl_settings_appearance');
    add_settings_field('wprl_settings_multiple', 'Layout Header', 'wprl_settings_multiple', 'wprl_options', 'wprl_settings_appearance');
    add_settings_field('wprl_settings_cover_image', 'Cover Image', 'wprl_settings_cover_image', 'wprl_options', 'wprl_settings_appearance');
    add_settings_section('wprl_settings_advanced', 'Advanced', '', 'wprl_options');
    add_settings_field('wprl_settings_override_taxonomy', 'Taxonomy Override', 'wprl_settings_override_taxonomy', 'wprl_options', 'wprl_settings_advanced');
    add_settings_field('wprl_settings_delete', 'Delete All', 'wprl_settings_delete', 'wprl_options', 'wprl_settings_advanced');
}

/* Change description of "featured image" */
function wprl_featured_image_html($content) {
    if (is_admin() && 'works' == get_post_type()) {
        $content = str_replace(__('Set featured image'), __('Set cover image'), $content);
        return $content = str_replace(__('Remove featured image'), __('Remove cover image'), $content);
    }
    else {
        return $content;
    }
}

/* Changed name of "featured image" */
function wprl_featured_image_mod($title) {
    if (is_admin() && 'works' == get_post_type()) {
        return $title = str_replace('Featured Image', 'Cover Image', $title);
    }
    else {
        return $title;
    }
}

/*
*End of File
*/