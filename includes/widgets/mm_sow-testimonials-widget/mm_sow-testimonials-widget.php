<?php

/*
Widget Name: Micemade Testimonials
Description: Display testimonials from your clients/customers in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Testimonials_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-testimonials',
            __('Micemade Testimonials', 'mm_sow'),
            array(
                'description' => __('Display testimonials in a responsive multi-column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#testimonials-widgets'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),
                'testimonials' => array(
                    'type' => 'repeater',
                    'label' => __('Testimonials', 'mm_sow'),
                    'item_name' => __('Testimonial', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='testimonials-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'mm_sow'),
                            'description' => __('The author of the testimonial', 'mm_sow'),
                        ),

                        'credentials' => array(
                            'type' => 'text',
                            'label' => __('Author Details', 'mm_sow'),
                            'description' => __('The details of the author like company name, position held, company URL etc. HTML accepted.', 'mm_sow'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Image', 'mm_sow'),
                        ),

                        'text' => array(
                            'type' => 'tinymce',
                            'label' => __('Text', 'mm_sow'),
                            'description' => __('What your customer had to say', 'mm_sow'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),
                    )
                ),
            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'mm_sow-testimonials',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'testimonials' => !empty($instance['testimonials']) ? $instance['testimonials'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-testimonials', __FILE__, 'MM_SOW_Testimonials_Widget');