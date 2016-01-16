<?php

class WPRLTaxonomies {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new WPRLTaxonomies();
        }
        return self::$instance;
    }

    /**
     * Initializes the class by setting filters and administration functions.
     */
    private function __construct() {
        /* Create custom taxonomy for authors */
        add_action('init', 'wprl_custom_tax', 0);
        /* Custom help tab for wprl */
        add_action('admin_head', 'codex_custom_help_tab');
        /* Customize admin messages related to the wprl custom post type */
        add_filter( 'post_updated_messages', 'wprl_custom_messages' );
        /* Create custom post type for reading list 'items' */
        add_action('init', 'register_wprl_cpt');

    }

}

add_action('plugins_loaded', array('WPRLTaxonomies', 'get_instance'));