<?php

/*
Widget Name: Micemade Stats Bars
Description: Display multiple stats bars that talk about skills or other percentage stats.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Stats_Bars_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-stats-bars',
            __('Micemade Stats Bars', 'mm_sow'),
            array(
                'description' => __('Display statistics or skills as a percentage stats bar.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#statistics-widgets'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),
                'stats-bars' => array(
                    'type' => 'repeater',
                    'label' => __('Stats Bars', 'mm_sow'),
                    'item_name' => __('Stats Bar', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='stats-bars-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'mm_sow'),
                            'description' => __('The title for the stats bar', 'mm_sow'),
                        ),

                        'value' => array(
                            'type' => 'text',
                            'label' => __('Percentage Value', 'mm_sow'),
                            'description' => __('The percentage value for the stats.', 'mm_sow'),
                        ),

                        'color' => array(
                            'type' => 'color',
                            'label' => __('Bar color', 'mm_sow'),
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
                    MM_SOW_PLUGIN_URL . 'assets/js/' . MM_SOW_JS_PREFIX . 'jquery.waypoints' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );


        $this->register_frontend_scripts(
            array(
                array(
                    'mm_sow-stats-bar',
                    plugin_dir_url(__FILE__) . 'js/' . MM_SOW_JS_PREFIX . 'stats-bar' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery')
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'mm_sow-stats-bar',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'stats_bars' => !empty($instance['stats-bars']) ? $instance['stats-bars'] : array()
        );
    }

}

siteorigin_widget_register('mm_sow-stats-bars', __FILE__, 'MM_SOW_Stats_Bars_Widget');