<?php

/*
Widget Name: Micemade Services
Description: Capture services in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Services_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-services',
            __('Micemade Services', 'mm_sow'),
            array(
                'description' => __('Create services to display in a column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#services-widget'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

                'style' => array(
                    'type' => 'select',
                    'label' => __('Choose Style', 'mm_sow'),
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('style')
                    ),
                    'default' => 'style1',
                    'options' => array(
                        'style1' => __('Style 1', 'mm_sow'),
                        'style2' => __('Style 2', 'mm_sow'),
                        'style3' => __('Style 3', 'mm_sow'),
                        'style4' => __('Style 4 (style 2 reversed)', 'mm_sow'),
                    )
                ),

                'services' => array(
                    'type' => 'repeater',
                    'label' => __('Services', 'mm_sow'),
                    'item_name' => __('Service', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='services-heading']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(

                        'heading' => array(
                            'type' => 'text',
                            'label' => __('Title', 'mm_sow'),
                            'description' => __('Title of the service. (select text to use basic formatting)', 'mm_sow'),
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
                            'label' => __('Service Image.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array('show'),
                                'icon_type[icon]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Service Icon.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),

                        'excerpt' => array(
                            'type' => 'textarea',
                            'label' => __('Short description', 'mm_sow'),
                            'description' => __('Provide a short description for the service', 'mm_sow'),
                        ),
						
						'url' => array(
							'type' => 'link',
							'label' => __('URL for service (optional)', 'mm_sow'),
							'sanitize' => 'url',
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
						
						'margin' => array(
                            'type' => 'number',
                            'label' => __('Top and bottom margin', 'mm_sow'),
                            'default' => 0,
							'description' => __('Enter only the number, unit is hardcoded in pixels.', 'mm_sow'),
                        ),
						
						'title_tag' => array(
                            'type' => 'select',
                            'label' => __('Title tag.', 'mm_sow'),
							'default' => 'h3',
							'options' => array(
								'h2' => __('H2', 'mm_sow'),
								'h3' => __('H3', 'mm_sow'),
								'h4' => __('H4', 'mm_sow'),
								'h5' => __('H5', 'mm_sow'),
								'p' => __('Paragraph (bold)', 'mm_sow'),
							)
                        ),
						
						'title_resize' => array(
                            'type' => 'slider',
                            'label' => __('Resize title', 'mm_sow'),
                            'min' => 0,
                            'max' => 200,
                            'integer' => true,
                            'default' => 100
                        ),
						
						'icons_color' => array(
                            'type' => 'color',
                            'label' => __('Icons color.', 'mm_sow'),
							'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),
						
						'title_color' => array(
                            'type' => 'color',
                            'label' => __('Title color.', 'mm_sow'),
                        ),
						
						'desc_color' => array(
                            'type' => 'color',
                            'label' => __('Short description color.', 'mm_sow'),
                        ),
                    )
                ), // settings
            )
        );
    }

    function enqueue_frontend_scripts($instance) {

        wp_enqueue_style('mm_sow-frontend-styles', MM_SOW_PLUGIN_URL . 'assets/css/mm_sow-frontend.css', array(), MM_SOW_VERSION);

        wp_enqueue_style('mm_sow-services', siteorigin_widget_get_plugin_dir_url('mm_sow-services') . 'css/style.css', array(), MM_SOW_VERSION);

        parent::enqueue_frontend_scripts($instance);
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'services' => !empty($instance['services']) ? $instance['services'] : array(),
            'settings' => $instance['settings']
        );
    }
	
	function get_less_variables($instance) {
		
		return array(
			'margin'		=> isset( $instance['settings']['margin'] )			? $instance['settings']['margin'].'px' : 0 ,
			'icons_color'	=> isset( $instance['settings']['icons_color'] )	? $instance['settings']['icons_color'] : '',
			'title_color'	=> isset( $instance['settings']['title_color'] )	? $instance['settings']['title_color'] : '',
			'desc_color'	=> isset( $instance['settings']['desc_color'] )		? $instance['settings']['desc_color'] : '',
			'title_resize'	=> isset( $instance['settings']['title_resize'] )	? $instance['settings']['title_resize'] .'%' : 100 .'%',
        );
    }

}

siteorigin_widget_register('mm_sow-services', __FILE__, 'MM_SOW_Services_Widget');