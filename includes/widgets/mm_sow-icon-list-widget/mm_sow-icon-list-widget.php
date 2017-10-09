<?php

/*
Widget Name: Micemade Icon List
Description: Use images or icon fonts to create social icons list, show payment options etc.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Icon_List_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-icon-list',
            __('Micemade Icon List', 'mm_sow'),
            array(
                'description' => __('Use images or icon fonts to create social icons list, show payment options etc.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#icon-list'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
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

                'icon_list' => array(
                    'type' => 'repeater',
                    'label' => __('Icon List', 'mm_sow'),
                    'item_name' => __('Icon', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='icon_list-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(

                        'title' => array(
                            'type' => 'text',
                            'label' => __('Title', 'mm_sow'),
                            'description' => __('Title for the Icon.', 'mm_sow'),
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => __('Icon Image.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array('show'),
                                'icon_type[icon]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Icon.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),


                        "href" => array(
                            "type" => "link",
                            "label" => __("Target URL", 'mm_sow'),
                            "description" => __("The URL to which icon/image should point to. (optional)", 'mm_sow'),
                        ),

                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        'icon_size' => array(
                            'type' => 'slider',
                            'label' => __('Icon/Image size in pixels', 'mm_sow'),
                            'min' => 1,
                            'max' => 128,
                            'integer' => true,
                            'default' => 32
                        ),

                        'icon_color' => array(
                            'type' => 'color',
                            'label' => __('Icon color', 'mm_sow'),
                            'default' => '#666666',
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),

                        'hover_color' => array(
                            'type' => 'color',
                            'label' => __('Icon hover color', 'mm_sow'),
                            'default' => '#444444',
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),
                        
						'title_size' => array(
                            'type' => 'slider',
                            'label' => __('Title size in pixels', 'mm_sow'),
                            'min' => 1,
                            'max' => 128,
                            'integer' => true,
                            'default' => 28
                        ),
						
                        "target" => array(
                            "type" => "checkbox",
                            "label" => __("Open the links in new window", 'mm_sow'),
                            "default" => true,
                        ),

                        'align' => array(
                            'type' => 'select',
                            'label' => __('Alignment', 'mm_sow'),
                            'default' => 'left',
                            'options' => array(
                                'left' => __('Left', 'mm_sow'),
                                'right' => __('Right', 'mm_sow'),
                                'center' => __('Center', 'mm_sow'),
                            )
                        ),
						'orientation' => array(
                            'type' => 'select',
                            'label' => __('List orientation', 'mm_sow'),
                            'default' => 'vertical',
                            'options' => array(
                                'vertical'		=> __('Vertical list', 'mm_sow'),
								'horizontal'	=> __('Horizontal list', 'mm_sow'),
                            )
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
                    'mm_sow-tooltips',
                    MM_SOW_PLUGIN_URL . 'assets/js/'. MM_SOW_JS_PREFIX .'jquery.powertip' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );

        $this->register_frontend_scripts(array(
                array(
                    'mm_sow-icon-list',
                    plugin_dir_url(__FILE__) . 'js/'. MM_SOW_JS_PREFIX .'icon-list' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
                array(
                    'mm_sow-icon-list',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );
    }

    function get_less_variables($instance) {
        return array(
            'icon_size'		=> intval($instance['settings']['icon_size'] ) . 'px',
            'icon_color'	=> $instance['settings']['icon_color'],
            'hover_color'	=> $instance['settings']['hover_color'],
			'title_size'	=> isset( $instance['settings']['title_size'] ) ? intval($instance['settings']['title_size'] ) . 'px' : '',
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'icon_type' => $instance['icon_type'],
            'icon_list' => !empty($instance['icon_list']) ? $instance['icon_list'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-icon-list', __FILE__, 'MM_SOW_Icon_List_Widget');