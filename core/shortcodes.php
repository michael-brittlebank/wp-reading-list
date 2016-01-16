<?php

class WPRLShortcodes {

    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance() {
        if (null == self::$instance) {
            self::$instance = new WPRLShortcodes();
        }
        return self::$instance;
    }

    /**
     * Initializes the class by setting filters and administration functions.
     */
    private function __construct() {
        add_filter('widget_text', 'do_shortcode');
        add_shortcode('wprl', 'wprl_layout_shortcode');
    }

    /**
     * @param $attributes
     * @return string
     */
   public function wprl_layout_shortcode($attributes) {
        $args = shortcode_atts(
            array(
                'layout' => 'plain',
                'number' => '5',
            ),
            $attributes
        );
        $output = '';
        if (isset($args['layout']) && isset($args['number'])){
            $query = WPRLDatabase::getWorks($args['number']);
            if ($query->have_posts()){
                if ($args['layout'] === 'plain'){
                    $output .= '<ul>';
                    while ($query->have_posts()) {
                        $query->the_post();
                        $output .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
                    }
                    $output .= '</ul>';
                }
            }
        }
        return $output;
    }
}

add_action('plugins_loaded', array('WPRLShortcodes', 'get_instance'));
