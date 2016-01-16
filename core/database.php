<?php

class WPRLDatabase {

    public static function getWorks($numPosts){
        $wprl_options = get_option('wprl_plugin_options');
        $orderby = $wprl_options['order'];
        if ($orderby == 'author') {
            $orderby .= ' title';
        }
        $args = array(
            'post_type' => 'works',
            'order' => $wprl_options['direction'],
            'orderby' => $orderby,
            'posts_per_page' => $numPosts,
            'post_status' => "publish"
        );
        return new WP_Query($args);
    }

    /*Delete works and authors function, called after 'save settings' or when deleting the plugin */
    public static function deleteWorks(){
        global $wpdb;
        $query = "DELETE FROM wp_posts WHERE post_type = 'works'";
        $wpdb->query($query);
        remove_taxonomy('work-author');
        $GLOBALS['wp_rewrite']->flush_rules();
    }

}