<?php

/*
Widget Name: Micemade Testimonials Slider
Description: Display responsive touch friendly slider of testimonials from clients/customers.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Testimonials_Slider_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-testimonials-slider',
            __('Micemade Testimonials Slider', 'mm_sow'),
            array(
                'description' => __('Share your product/service testimonials in a responsive slider.', 'mm_sow'),
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

                        'arrows' => array(
                            'type' => 'checkbox',
                            'label' => __('Prev/Next Arrows?', 'mm_sow'),
                            'default' => true
                        ),

                        'dots' => array(
                            'type' => 'checkbox',
                            'label' => __('Show dot indicators for navigation?', 'mm_sow'),
                        ),

                        'autoplay' => array(
                            'type' => 'checkbox',
                            'label' => __('Autoplay?', 'mm_sow'),
                            'description' => __('Should the carousel autoplay as in a slideshow.', 'mm_sow'),
                            'default' => false
                        ),


                        'autoplay_speed' => array(
                            'type' => 'number',
                            'label' => __('Autoplay speed in ms', 'mm_sow'),
                            'default' => 3000
                        ),


                        'animation_speed' => array(
                            'type' => 'number',
                            'label' => __('Autoplay animation speed in ms', 'mm_sow'),
                            'default' => 300
                        ),

                        'pause_on_hover' => array(
                            'type' => 'checkbox',
                            'label' => __('Pause on mouse hover?', 'mm_sow'),
                            'default' => true
                        ),

                        'display_columns' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 1
                        ),

                        'scroll_columns' => array(
                            'type' => 'slider',
                            'label' => __('Columns to scroll', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 1
                        ),

                        'gutter' => array(
                            'type' => 'number',
                            'label' => __('Gutter', 'mm_sow'),
                            'description' => __('Space between columns.', 'mm_sow'),
                            'default' => 10
                        ),
						
						'responsive' => array(
                            'type' => 'section',
                            'label' => __('Responsive', 'mm_sow'),
                            'hide' => true,
                            'fields' => array(
                                'tablet' => array(
                                    'type' => 'section',
                                    'label' => __('Tablet', 'mm_sow'),
                                    'fields' => array(
                                        'display_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns per row', 'mm_sow'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 2
                                        ),
                                        'scroll_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns to scroll', 'mm_sow'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 2
                                        ),
                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'mm_sow'),
                                            'description' => __('Space between columns.', 'mm_sow'),
                                            'default' => 10
                                        ),
                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'mm_sow'),
                                            'description' => __('The resolution to treat as a tablet resolution.', 'mm_sow'),
                                            'default' => 768,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                ),
                                'mobile' => array(
                                    'type' => 'section',
                                    'label' => __('Mobile Phone', 'mm_sow'),
                                    'fields' => array(
                                        'display_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns per row', 'mm_sow'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 1
                                        ),
                                        'scroll_columns' => array(
                                            'type' => 'slider',
                                            'label' => __('Columns to scroll', 'mm_sow'),
                                            'min' => 1,
                                            'max' => 5,
                                            'integer' => true,
                                            'default' => 1
                                        ),
                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'mm_sow'),
                                            'description' => __('Space between columns.', 'mm_sow'),
                                            'default' => 10
                                        ),
                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'mm_sow'),
                                            'description' => __('The resolution to treat as a mobile resolution.', 'mm_sow'),
                                            'default' => 480,
                                            'sanitize' => 'intval',
                                        )
                                    ) // "mobile" fields
									
                                ) // "mobile" section

                            ) // "responsive" fields
							
                        ), // "responsive" section
						
						
						
                    )// end fields
					
                ),// end "settings" section
				
            )
        );
    }

    function initialize() {

        $this->register_frontend_scripts(
            array(
                array(
                    'mm_sow-slick-carousel',
                    MM_SOW_PLUGIN_URL . 'assets/js/' . MM_SOW_JS_PREFIX . 'slick' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(
            array(
                array(
					'mm_sow-testimonials-slider',
					plugin_dir_url(__FILE__) . 'css/style.css'
				),
				array(
                    'mm_sow-slick',
                    MM_SOW_PLUGIN_URL . 'assets/css/slick.css',
                    array(),
                    MM_SOW_VERSION
                )
            )
        );

		/* 
        $this->register_frontend_scripts(array(
            array(
                'mm_sow-testimonials-slider',
                plugin_dir_url(__FILE__) . 'js/' . MM_SOW_JS_PREFIX . 'testimonials' . MM_SOW_JS_SUFFIX . '.js',
                array('mm_sow-flexslider')
            )
        ));
		
        $this->register_frontend_styles(array(
            array(
                'mm_sow-testimonials-slider',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));*/
    }

    function get_template_variables($instance, $args) {
        $return = array(
            'testimonials' => !empty($instance['testimonials']) ? $instance['testimonials'] : array(),
            'settings' => $instance['settings']
        );
		
		        unset($return['settings']['responsive']);

        $return['settings']['tablet_width'] = $instance['settings']['responsive']['tablet']['width'];
        $return['settings']['tablet_display_columns'] = $instance['settings']['responsive']['tablet']['display_columns'];
        $return['settings']['tablet_scroll_columns'] = $instance['settings']['responsive']['tablet']['scroll_columns'];
        $return['settings']['mobile_width'] = $instance['settings']['responsive']['mobile']['width'];
        $return['settings']['mobile_display_columns'] = intval($instance['settings']['responsive']['mobile']['display_columns']);
        $return['settings']['mobile_scroll_columns'] = $instance['settings']['responsive']['mobile']['scroll_columns'];
		
		return $return;
    }

}

siteorigin_widget_register('mm_sow-testimonials-slider', __FILE__, 'MM_SOW_Testimonials_Slider_Widget');