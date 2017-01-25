<?php

/*
Widget Name: Micemade Piecharts
Description: Display one or more piecharts depicting a percentage value in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Piechart_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-piecharts',
            __('Micemade Piecharts', 'mm_sow'),
            array(
                'description' => __('Display statistics or skills as a percentage piechart.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#statistics-widgets'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

                'piecharts' => array(
                    'type' => 'repeater',
                    'label' => __('Piecharts', 'mm_sow'),
                    'item_name' => __('Piechart', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='piecharts-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'stats_title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'mm_sow'),
                            'description' => __('The title for the piechart', 'mm_sow'),
                        ),

                        'percentage' => array(
                            'type' => 'text',
                            'label' => __('Percentage Value', 'mm_sow'),
                            'description' => __('The percentage value for the stats.', 'mm_sow'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        'bar_color' => array(
                            'type' => 'color',
                            'label' => __('Bar color', 'mm_sow'),
                            'default' => '#f94213'
                        ),

                        'track_color' => array(
                            'type' => 'color',
                            'label' => __('Track color', 'mm_sow'),
                            'default' => '#dddddd'
                        ),

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __( 'Piecharts per row', 'mm_sow' ),
                            'min' => 1,
                            'max' => 5,
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
                    MM_SOW_PLUGIN_URL . 'assets/js/' . MM_SOW_JS_PREFIX . 'jquery.waypoints' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
                array(
                    'mm_sow-stats',
                    MM_SOW_PLUGIN_URL . 'assets/js/' . MM_SOW_JS_PREFIX . 'jquery.stats' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );


        $this->register_frontend_scripts(
            array(
                array(
                    'mm_sow-piecharts',
                    plugin_dir_url(__FILE__) . 'js/' . MM_SOW_JS_PREFIX . 'piechart' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
            array(
                'mm_sow-piecharts',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'piecharts' => !empty($instance['piecharts']) ? $instance['piecharts'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-piecharts', __FILE__, 'MM_SOW_Piechart_Widget');