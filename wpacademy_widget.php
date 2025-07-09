<?php

/**
 * academy widget
**/


// The widget class
class Wpacademy_Widegt extends WP_Widget {

    //Main Constructor
    public function __construct() {
        $widget_ops = array(
            'classname'    => 'wpacademy_widget',
            'description'  => __('This Widget displays the social icons', 'wpacademy'),
            'customize_selective_refresh'  => true,
        );
        parent::__construct(
            'wpacademy_widget',
            __('&raquo; Academy Social Icons', 'wpacademy'),
            $widget_ops
        );
    }

    public function form($instance) {
        // Set widget defaults
        $fields = array(
            'title' => __('Widget Title', 'wpacademy'),
            'facebook' => __('Facebook', 'wpacademy'),
            'twitter' => __('Twitter', 'wpacademy'),
            'instagram' => __('Instagram', 'wpacademy'),
            'linkedin' => __('LinkedIn', 'wpacademy')
        );

        foreach($fields as $field => $label) { ?>
            <p>
                <label for="<?php echo $this->get_field_id($field);?>">
                    <?php echo $label; ?>
                </label>
                <input class="widefat" 
                id="<?php echo $this->get_field_id($field);?>" 
                name="<?php echo $this->get_field_name($field);?>"
                type="text"
                value="<?php echo esc_attr($instance[$field]);?>" />
            </p>
        <?php
        }
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        foreach ($new_instance as $key => $value) {
            $instance[$key] = wp_strip_all_tags($value);
        }
        return $instance;
    }

    public function widget($args, $instance) {
        extract($args);
        echo $before_widget;

        if (!empty($instance['title'])) {
            echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        }

        echo '<div class="social-icons">';
        $social_networks = array(
            'facebook' => 'fa-facebook-f',
            'twitter' => 'fa-x-twitter',
            'instagram' => 'fa-instagram',
            'linkedin' => 'fa-linkedin'
        );

        foreach($social_networks as $network => $icon) {
            if(!empty($instance[$network])){
                echo '<a class="' . $network . '" href="' . esc_url($instance[$network]) . '"><i class="fa-brands ' . $icon . '"></i></a>';
            }
        }

        echo '</div>';
        echo $after_widget;
    }
}

function register_wpacademy_widget() {
    register_widget('Wpacademy_Widegt');
}

add_action('widgets_init', 'register_wpacademy_widget');