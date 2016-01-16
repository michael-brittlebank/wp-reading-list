<?php

class WPRLMeta {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new WPRLMeta();
        }
        return self::$instance;
    }

    /**
     * Initializes the class by setting filters and administration functions.
     */
    private function __construct() {
        /*Add meta boxes on the 'add_meta_boxes' hook. */
        add_action('add_meta_boxes', array($this, 'wprl_add_post_meta_boxes'));
        /*Save post meta on the 'save_post' hook. */
        add_action('save_post', array($this, 'wprl_pages_save_meta', 10, 2));

        add_action('load-post.php', 'wprl_post_meta_boxes_setup');
        add_action('load-post-new.php', 'wprl_post_meta_boxes_setup');
    }

    /* Custom meta boxes for post/'work' admin screen.  */
    public function wprl_add_post_meta_boxes() {
        add_meta_box(
            'wprl-link', /* Unique ID */
            __('Work URL', 'wp_reading_list'), /* Title */
            'wprl_pages_meta_link',	 /* Callback function */
            'works', /* Add metabox to our custom post type */
            'side',	 /* Context */
            'default' /* Priority */
        );
        add_meta_box(
            'wprl-pages', /* Unique ID */
            __('Number of Pages', 'wp-readinglist'), /* Title */
            'wprl_pages_meta_pages',	 /* Callback function */
            'works', /* Add metabox to our custom post type */
            'side',	 /* Context */
            'default' /* Priority */
        );
    }

    /* Display link meta box */
    public function wprl_pages_meta_link($object, $box) {
        wp_nonce_field(basename(__FILE__), 'wprl_pages_nonce');
        require '../views/partials/meta-link.php';
    }

    /* Display pages meta box */
    public function wprl_pages_meta_pages($object, $box) {
        wp_nonce_field(basename(__FILE__), 'wprl_pages_nonce');
        require '../views/partials/meta-pages.php';
    }

    /* Save meta box data as post_meta */
    function wprl_pages_save_meta($post_id, $post) {
        if(!isset($_POST['wprl_pages_nonce']) || !wp_verify_nonce($_POST['wprl_pages_nonce'], basename(__FILE__))) {
            return false;
        }
        $post_type = get_post_type_object($post->post_type);
        if(!current_user_can($post_type->cap->edit_post, $post_id)) {
            return false;
        }
        $new_link_value = esc_url_raw(isset($_POST['wprl-link']) ?  $_POST['wprl-link']  : '');
        $new_pages_value = sanitize_text_field((isset($_POST['wprl-pages']) ?  $_POST['wprl-pages']  : ''));
        $link_key = 'wprl_link';
        $pages_key = 'wprl_pages';
        $link_value = get_post_meta($post_id, $link_key, true);
        $pages_value = get_post_meta($post_id, $pages_key, true);
        if($new_link_value && '' == $link_value) {
            add_post_meta($post_id, $link_key, $new_link_value, true);
        }
        elseif($new_link_value && $new_link_value != $link_value) {
            update_post_meta($post_id, $link_key, $new_link_value);
        }
        elseif('' == $new_link_value && $link_value) {
            delete_post_meta($post_id, $link_key, $link_value);
        }
        if($new_pages_value && '' == $pages_value) {
            add_post_meta($post_id, $pages_key, $new_pages_value, true);
        }
        elseif($new_pages_value && $new_pages_value != $pages_value) {
            update_post_meta($post_id, $pages_key, $new_pages_value);
        }
        elseif('' == $new_pages_value && $pages_value) {
            delete_post_meta($post_id, $pages_key, $pages_value);
        }
        return true;
    }
}

add_action('plugins_loaded', array('WPRLMeta', 'get_instance'));