<?php

/*
Widget Name: Micemade Stretcher
Description: Display posts/product in fancy stretching panes.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Stretcher_Widget extends SiteOrigin_Widget {

    function __construct() {
       
	   parent::__construct(
            'mm_sow-stretcher',
            __('Micemade Stretcher', 'mm_sow'),
            array(
                'description' => __(' Display posts/product in fancy stretching panes.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#stretcher'
            ),
            array(),
            false,
			plugin_dir_path( __FILE__ )
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
					'default'		=> 0,
					'description'	=> __('Hide title on frontend (display it only in page page builder admin)','mm_sow')
                ),

                'stretcher_posts' => array(
                    'type' => 'posts',
                    'label' => __('Posts query', 'mm_sow'), 
					'description' => __('Choose post types, taxonomies, number of posts and other posts query arguments.', 'mm_sow'),
					'options'	=> array(
						'posts_per_page' => 64
					)
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('General Settings', 'mm_sow'),
                    'fields' => array(

						
                        'taxonomy_chosen' => array(
                            'type' => 'select',
                            'label' => __('Choose the taxonomy to display info.', 'mm_sow'),
                            'description' => __('Choose the taxonomy to use for display of taxonomy information for posts/custom post types.', 'mm_sow'),
                            'options' => $taxonomies,

                        ),

                        'display_taxonomy' => array(
							'type' => 'checkbox',
							'label' => __('Display taxonomies ?', 'mm_sow'),
							'default' => false
						),
						'display_summary' => array(
                            'type' => 'checkbox',
                            'label' => __('Display post excerpt/summary ?', 'mm_sow'),
							'description' => __('In case of WooCommerce products, excerpt is replaced with price and shop buttons', 'mm_sow'),
                            'default' => true
                        ),
						
						'img_format' => array(
                            'type' => 'select',
                            'label' => __('Post image format', 'mm_sow'),
                            'default' => 'full',
                            'options' => apply_filters("mm_sow_image_sizes","")
                        ),
						
						'img_size' => array(
                            'type' => 'select',
                            'label' => __('Post image size', 'mm_sow'),
							'description' => __('Post image is displayed as element background image - choose the background image size','mm_sow'),
                            'default' => 'contain',
                            'options' => array(
								'cover'	=> 'Cover',
								'contain'	=> 'Contain',
							)
                        ),
						
						'title_size' => array(
							'type' => 'slider',
							'label' => __( 'Post title size', 'mm_sow' ),
							'description' => __('increase or decrease title in percentage', 'mm_sow'),
							'default' => 20,
							'min' => -100,
							'max' => 100,
							'integer' => true
						),

						'overlay_color' => array(
							'type' => 'color',
							'label' => __('Items overlay color', 'mm_sow'),
							'default' => '#000',
						),
						'text_color' => array(
							'type' => 'color',
							'label' => __('Items text color', 'mm_sow'),
							'default' => '#fff',
						),
                        'post_meta' => array(
                            'type' => 'section',
                            'label' => __('Post Meta', 'mm_sow'),
                            'fields' => array(

                                'display_author' => array(
                                    'type' => 'checkbox',
                                    'label' => __('Display post author info ?', 'mm_sow'),
                                    'default' => false
                                ),

                                'display_post_date' => array(
                                    'type' => 'checkbox',
                                    'label' => __('Display post date info ?', 'mm_sow'),
                                    'default' => false
                                ),


                            ) // fields

                        ), // post_meta section
						
                    ) // field settings
					
                ), // settings section
				

                'stretcher_settings' => array(
                    'type' => 'section',
                    'label' => __('Stretcher Settings', 'mm_sow'),
                    'fields' => array(

                        'imgspeed' => array(
							'type' => 'text',
							'label' => __('Image animation speed', 'mm_sow'),
							'description' => __('How fast the image will slide in.', 'mm_sow'),
							'default' => '1500ms',

						),

                        'bgspeed' => array(
							'type' => 'text',
							'label' => __('Background animation speed', 'mm_sow'),
							'description' => __('How fast the background will appear.', 'mm_sow'),
							'default' => '750ms',

						),

                        'height' => array(
                            'type' => 'measurement',
                            'label' => __('Stretcher height', 'mm_sow'),
                            'description' => __('Height of whole block with stretching slides.', 'mm_sow'),
                            'default' => '100vh'
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

                                        'height' => array(
                                            'type' => 'measurement',
                                            'label' => __('Stretcher height on tablets', 'mm_sow'),
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
                                       
                                        'height' => array(
                                            'type' => 'measurement',
                                            'label' => __('Stretcher height on mobiles', 'mm_sow'),
                                            'description' => __('Space between columns.', 'mm_sow'),
                                            'default' => '100vh'
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
                    'mm_sow-stretcher',
                    plugin_dir_url(__FILE__) . 'js/' . MM_SOW_JS_PREFIX . 'stretcher' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );


        $this->register_frontend_styles(array(
                array(
                    'mm_sow-stretcher',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );

    }

    function get_less_variables($instance) {
        		
		$posts = siteorigin_widget_post_selector_process_query( $instance['stretcher_posts'] );
		
		return array(

            'img_size'		=> $instance['settings']['img_size'],	
			'overlay_color'	=> $instance['settings']['overlay_color'],	
            'text_color'	=> $instance['settings']['text_color'],
			
			'height'		=> $instance['stretcher_settings']['height'],

            'numslides'		=> !empty( $posts['posts_per_page']) ? intval($posts['posts_per_page']) : 3,
            'imgspeed'		=> $instance['stretcher_settings']['imgspeed'],
            'bgspeed'		=> $instance['stretcher_settings']['bgspeed'],
			
			// All the responsive sizes
            'tablet_height'	=> $instance['stretcher_settings']['responsive']['tablet']['height'],
			'tablet_width'	=> intval($instance['stretcher_settings']['responsive']['tablet']['width']) . 'px',
            
			'mobile_height'	=> $instance['stretcher_settings']['responsive']['mobile']['height'],
            'mobile_width'	=> intval($instance['stretcher_settings']['responsive']['mobile']['width']) . 'px',
			
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
            'posts'				=> $instance['stretcher_posts'],
            'settings'			=> $instance['settings'],
            'stretcher_settings'=> $instance['stretcher_settings']
        );

        unset($return['stretcher_settings']['responsive']);

        $return['stretcher_settings']['tablet_width'] = $instance['stretcher_settings']['responsive']['tablet']['width'];
        $return['stretcher_settings']['mobile_width'] = $instance['stretcher_settings']['responsive']['mobile']['width'];


        return $return;
    }

}

siteorigin_widget_register('mm_sow-stretcher', __FILE__, 'MM_SOW_Stretcher_Widget');