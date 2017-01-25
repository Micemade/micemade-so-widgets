<?php

/*
Widget Name: Micemade Carousel
Description: Display a list of custom HTML content as a carousel.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Carousel_Widget extends SiteOrigin_Widget {

    private $custom_css;

    function __construct() {
        parent::__construct(
            'mm_sow-carousel',
            __('Micemade Carousel', 'mm_sow'),
            array(
                'description' => __('Display a collection of html elements as a carousel.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#carousel-widget'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

                'elements' => array(
                    'type' => 'repeater',
                    'label' => __('HTML Elements', 'mm_sow'),
                    'item_name' => __('HTML Element', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='elements-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'mm_sow'),
                            'description' => __('The title to identify the HTML element', 'mm_sow'),
                        ),
						'back_image' => array(
							'type' => 'media',
							'label' => __('Background Image', 'mm_sow'),
							'description' => __('This background image will be used as a placeholder image if YouTube or HTML5 video background option is chosen.', 'mm_sow'),
							'library' => 'image',
							'fallback' => true,
						),
                        'text' => array(
                            'type' => 'tinymce',
                            'label' => __('HTML element', 'mm_sow'),
                            'description' => __('The HTML content for the carousel item.', 'mm_sow'),
                        ),
						
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('General Settings', 'mm_sow'),
                    'fields' => array(

                        'custom_css' => array(
                            'type' => 'textarea',
                            'label' => __('Custom CSS for presentation of the HTML elements. Will be embedded inline with the page.', 'mm_sow'),
                            'rows' => 20
                        ),
                    )
                ),

                'carousel_settings' => array(
                    'type' => 'section',
                    'label' => __('Carousel Settings', 'mm_sow'),
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
                            'default' => 3
                        ),

                        'scroll_columns' => array(
                            'type' => 'slider',
                            'label' => __('Columns to scroll', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),

                        'height' => array(
                            'type' => 'measurement',
                            'label' => __('Carousel height', 'mm_sow'),
                            'description' => __('Height applied in desktop view.', 'mm_sow'),
                            'default' => '100vh'
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
										'height' => array(
                                            'type' => 'measurement',
                                            'label' => __('Carousel height on tablets', 'mm_sow'),
                                            'default' => '100vh'
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
										'height' => array(
                                            'type' => 'measurement',
                                            'label' => __('Carousel height on mobiles', 'mm_sow'),
                                            'default' => '100vh'
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
                                    )
                                )

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
                    'mm_sow-slick-carousel',
                    MM_SOW_PLUGIN_URL . 'assets/js/'. MM_SOW_JS_PREFIX .'slick' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(
            array(
                array(
                    'mm_sow-slick',
                    MM_SOW_PLUGIN_URL . 'assets/css/slick.css',
                    array(),
                    MM_SOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(array(
                array(
                    'mm_sow-carousel',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );

        add_action('wp_enqueue_scripts', array($this, 'init_custom_css'), 15); // load as late as possible

    }

    function modify_instance($instance) {
        return $instance;
    }

    function init_custom_css() {

        if (!is_active_widget(false, false, $this->id_base)) {
            return;
        }

        $custom_css = '';

        $instances = $this->get_settings();

        if (array_key_exists($this->number, $instances)) {
            $instance = $instances[$this->number];
            if (!empty($instance))
                $custom_css = $instance['settings']['custom_css'];
        }

        if ($custom_css <> '') {
            $custom_css = $custom_css . "\n";
            wp_add_inline_style('mm_sow-carousel', $custom_css); // after custom.css file
        }

    }

    function get_less_variables($instance) {
        return array(
			
			'height'		=> $instance['carousel_settings']['height'],
            'gutter'		=> intval($instance['carousel_settings']['gutter']) . 'px',

            // All the responsive sizes
            'tablet_height'	=> intval($instance['carousel_settings']['responsive']['tablet']['height']),
            'tablet_width'	=> intval($instance['carousel_settings']['responsive']['tablet']['width']) . 'px',
            'tablet_gutter'	=> intval($instance['carousel_settings']['responsive']['tablet']['gutter']) . 'px',
            
			'mobile_height'	=> intval($instance['carousel_settings']['responsive']['mobile']['height']),
			'mobile_width'	=> intval($instance['carousel_settings']['responsive']['mobile']['width']) . 'px',
            'mobile_gutter'	=> intval($instance['carousel_settings']['responsive']['mobile']['gutter']) . 'px',
        );
    }

    function get_template_variables($instance, $args) {


        $return = array(
            'elements' => !empty($instance['elements']) ? $instance['elements'] : array(),
            'settings' => $instance['settings'],
            'carousel_settings' => $instance['carousel_settings']
        );

        unset($return['carousel_settings']['responsive']);

        $return['carousel_settings']['tablet_width'] = $instance['carousel_settings']['responsive']['tablet']['width'];
        $return['carousel_settings']['tablet_display_columns'] = $instance['carousel_settings']['responsive']['tablet']['display_columns'];
        $return['carousel_settings']['tablet_scroll_columns'] = $instance['carousel_settings']['responsive']['tablet']['scroll_columns'];
        $return['carousel_settings']['mobile_width'] = $instance['carousel_settings']['responsive']['mobile']['width'];
        $return['carousel_settings']['mobile_display_columns'] = intval($instance['carousel_settings']['responsive']['mobile']['display_columns']);
        $return['carousel_settings']['mobile_scroll_columns'] = $instance['carousel_settings']['responsive']['mobile']['scroll_columns'];

        return $return;
    }

}

siteorigin_widget_register('mm_sow-carousel', __FILE__, 'MM_SOW_Carousel_Widget');