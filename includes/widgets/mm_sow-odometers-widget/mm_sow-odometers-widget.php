<?php

/*
Widget Name: Micemade Odometers
Description: Display one or more animated odometer statistics in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Odometer_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-odometers',
            __('Micemade Odometers', 'mm_sow'),
            array(
                'description' => __('Display statistics as animated odometers in a multi-column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#statistics-widgets'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

                'odometers' => array(
                    'type' => 'repeater',
                    'label' => __('Odometers', 'mm_sow'),
                    'item_name' => __('Odometer', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='odometers-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'stats_title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'mm_sow'),
                            'description' => __('The title for the odometer stats', 'mm_sow'),
                        ),

                        'start_value' => array(
                            'type' => 'number',
                            'label' => __('Start Value', 'mm_sow'),
                            'description' => __('The start value for the odometer stats.', 'mm_sow'),
                        ),

                        'stop_value' => array(
                            'type' => 'number',
                            'label' => __('Stop Value', 'mm_sow'),
                            'description' => __('The stop value for the odometer stats.', 'mm_sow'),
                        ),

                        'icon_type' => array(
                            'type' => 'select',
                            'label' => __('Choose Icon Type', 'mm_sow'),
                            'default' => 'icon',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('icon_type')
                            ),
                            'options' => array(
                                'icon' => __('Icon', 'mm_sow'),
                                'icon_image' => __('Icon Image', 'mm_sow'),
                            )
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => __('Stats Image.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array('show'),
                                'icon_type[icon]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Stats Icon.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),

                        'prefix' => array(
                            'type' => 'text',
                            'label' => __('Prefix', 'mm_sow'),
                            'description' => __('The prefix string for the odometer stats. Examples include currency symbols like $ to indicate a monetary value.', 'mm_sow'),
                        ),

                        'suffix' => array(
                            'type' => 'text',
                            'label' => __('Suffix', 'mm_sow'),
                            'description' => __('The suffix string for the odometer stats. Examples include strings like hr for hours or m for million.', 'mm_sow'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Odometers per row', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
                        ),
						'numbers_size' => array(
                            'type' => 'select',
                            'label' => __('Numbers size', 'mm_sow'),
                            'options' => array(
                                'normal'		=> __('Normal', 'mm_sow'),
                                'smaller'		=> __('Smaller', 'mm_sow'),
                                'even_smaller'	=> __('Even smaller', 'mm_sow'),
                                'bigger'		=> __('Bigger', 'mm_sow'),
                                'even_bigger'	=> __('Even bigger', 'mm_sow'),
                            ),
							'default'			=> 'normal'
                        ),
						'numbers_weight' => array(
                            'type' => 'select',
                            'label' => __('Numbers weight', 'mm_sow'),
                            'options' => array(
                                'normal'	=> __('Normal', 'mm_sow'),
                                'bold'		=> __('Bold', 'mm_sow'),
                            ),
							'default'		=> 'normal'
                        ),
						'numbers_style' => array(
                            'type' => 'select',
                            'label' => __('Numbers style', 'mm_sow'),
                            'options' => array(
                                'normal'	=> __('Normal', 'mm_sow'),
                                'italic'	=> __('Italic', 'mm_sow'),
                            ),
							'default'		=> 'normal'
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
                    'mm_sow-odometers',
                    plugin_dir_url(__FILE__) . 'js/' . MM_SOW_JS_PREFIX . 'odometer' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
            array(
                'mm_sow-odometers',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }
	
	function get_less_variables($instance) {
        		
		
		return array(

            'numbers_weight'	=> $instance['settings']['numbers_weight'],
            'numbers_style'		=> $instance['settings']['numbers_style'],
			
            );
    }

	
    function get_template_variables($instance, $args) {
        return array(
            'odometers' => !empty($instance['odometers']) ? $instance['odometers'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-odometers', __FILE__, 'MM_SOW_Odometer_Widget');