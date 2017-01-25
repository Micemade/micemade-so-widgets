<?php

/*
Widget Name: Micemade Clients
Description: Display list of your clients in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Client_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-clients',
            __('Micemade Clients', 'mm_sow'),
            array(
                'description' => __('Display one or more clients in a multi-column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#clients-widget'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

                'clients' => array(
                    'type' => 'repeater',
                    'label' => __('Clients', 'mm_sow'),
                    'item_name' => __('Client', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='clients-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Client Name', 'mm_sow'),
                            'description' => __('The name of the client/customer.', 'mm_sow'),
                        ),
                        'link' => array(
                            'type' => 'link',
                            'label' => __('Client URL', 'mm_sow'),
                            'description' => __('The website of the client/customer.', 'mm_sow'),
                        ),
                        'image' => array(
                            'type' => 'media',
                            'label' => __('Client Logo', 'mm_sow'),
                            'library' => 'image',
                            'description' => __('The logo image for the client/customer.', 'mm_sow'),
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
                            'max' => 6,
                            'integer' => true,
                            'default' => 4
                        ),
                    )
                ),

            )
        );
    }

    function initialize() {

        $this->register_frontend_scripts(
            array(
                array(
                    'mm_sow-waypoints',
                    MM_SOW_PLUGIN_URL . 'assets/js/'. MM_SOW_JS_PREFIX .'jquery.waypoints' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'mm_sow-clients',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'clients' => !empty($instance['clients']) ? $instance['clients'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-clients', __FILE__, 'MM_SOW_Client_Widget');