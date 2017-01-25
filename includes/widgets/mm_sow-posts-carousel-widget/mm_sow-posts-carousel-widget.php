<?php

/*
Widget Name: Micemade Posts Carousel
Description: Display blog posts or custom post types as a carousel.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Posts_Carousel_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-posts-carousel',
            __('Micemade Posts Carousel', 'mm_sow'),
            array(
                'description' => __('Display blog posts or custom post types as a carousel', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#post-carousel'
            ),
            array(),
			false,
			plugin_dir_path(__FILE__)
            
        );
    }

	function get_widget_form() {
		
		// Gets taxonomy objects and extracts the 'label' field from each one.
		$taxonomies = wp_list_pluck( get_taxonomies( array(), 'objects' ), 'label' );
		
		return array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),
				
				'hide_title' => array(
                    'type'			=> 'checkbox',
                    'label'			=> __('Hide title', 'mm_sow'),
					'default'		=> 1,
					'description'	=> __('Hide title on frontend (make visible only in PB admin - easier to identify widgets)','mm_sow')
                ),
				
                'posts' => array(
                    'type' => 'posts',
                    'label' => __('Posts query', 'mm_sow'),
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('General Settings', 'mm_sow'),
                    'fields' => array(

                        'style' => array(
                            'type' => 'select',
                            'label' => __('Posts display style.', 'mm_sow'),
                            'description' => __('Pick one of preredefined styles', 'mm_sow'),
                            'options' => array(
								'style1' => 'Style 1 (default)',
								'style2' => 'Style 2'
							),
                            'default' => 'category',
                        ),
						
                        'taxonomy_chosen' => array(
                            'type' => 'select',
                            'label' => __('Choose the taxonomy to display info.', 'mm_sow'),
                            'description' => __('Choose the taxonomy to use for display of taxonomy information for posts/custom post types.', 'mm_sow'),
                            'options' => $taxonomies,
                            'default' => 'category',
                        ),
						
						'img_format' => array(
                            'type' => 'select',
                            'label' => __('Choose post image format', 'mm_sow'),
                            'default' => 'thumbnail',
                            'options' => apply_filters("mm_sow_image_sizes","")
                        ),
						
                        'title_on_hover' => array(
                            'type' => 'checkbox',
                            'label' => __('Display post title on hover', 'mm_sow'),
							'description' => __('applicable only to Style 1', 'mm_sow'),
                            'default' => true
                        ),

                        'display_taxonomy' => array(
								'type' => 'checkbox',
								'label' => __('Display taxonomy on hover?', 'mm_sow'),
								'default' => false
							),
						
						'display_title' => array(
                            'type' => 'checkbox',
                            'label' => __('Display posts title below the post item?', 'mm_sow'),
							'description' => __('must be enabled for Style 2', 'mm_sow'),
                            'default' => true
                        ),

                        'display_summary' => array(
                            'type' => 'checkbox',
                            'label' => __('Display post excerpt/summary below the post item?', 'mm_sow'),
							'description' => __('In case of WooCommerce products, excerpt is replaced with price and shop buttons', 'mm_sow'),
                            'default' => true
                        ),

                        'post_meta' => array(
                            'type' => 'section',
                            'label' => __('Post Meta', 'mm_sow'),
                            'fields' => array(

                                'display_author' => array(
                                    'type' => 'checkbox',
                                    'label' => __('Display post author info below the post item?', 'mm_sow'),
                                    'default' => false
                                ),

                                'display_post_date' => array(
                                    'type' => 'checkbox',
                                    'label' => __('Display post date info below the post item?', 'mm_sow'),
                                    'default' => false
                                ),


                            )

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
                                            'default' => 800,
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
                    )
                ),
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
                    'mm_sow-posts-carousel',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );

    }

    function get_less_variables($instance) {
        		
		return array(

            'gutter' => intval($instance['carousel_settings']['gutter']) . 'px',

            // All the responsive sizes
            'tablet_width'		=> intval($instance['carousel_settings']['responsive']['tablet']['width']) . 'px',
            'tablet_gutter'		=> intval($instance['carousel_settings']['responsive']['tablet']['gutter']) . 'px',
            'mobile_width'		=> intval($instance['carousel_settings']['responsive']['mobile']['width']) . 'px',
            'mobile_gutter'		=> intval($instance['carousel_settings']['responsive']['mobile']['gutter']) . 'px',
			
        );
    }

    function modify_form( $form ) {
		
		// Gets taxonomy objects and extracts the 'label' field from each one.
		$taxonomies = wp_list_pluck( get_taxonomies( array(), 'objects' ), 'label' );
		
        $form['settings']['fields']['taxonomy_chosen']['options'] = $taxonomies;
        return $form;
    }

    function get_template_variables($instance, $args) {

        $return = array(
            'posts' => $instance['posts'],
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

siteorigin_widget_register('mm_sow-posts-carousel', __FILE__, 'MM_SOW_Posts_Carousel_Widget');