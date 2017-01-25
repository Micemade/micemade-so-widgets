<?php

/*
Widget Name: Micemade Grid
Description: Display posts or custom post types in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Portfolio_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-portfolio',
            __('Micemade Grid', 'mm_sow'),
            array(
                'description' => __('Display posts or custom post types in a multi-column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#grid-widget'
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

                'heading' => array(
                    'type' => 'text',
                    'label' => __('Heading for the grid', 'mm_sow'),
                ),

                'posts' => array(
                    'type' => 'posts',
                    'label' => __('Posts query', 'mm_sow'),
                    'description' => __('After you build the query, make sure you choose the right taxonomy below to display for your posts and filter on, based on the post type selected during build query.', 'mm_sow'),
                ),

                'taxonomy_filter' => array(
                    'type' => 'select',
                    'label' => __('Choose the taxonomy to display and filter on.', 'mm_sow'),
                    'description' => __('Choose the taxonomy information to display for posts/portfolio and the taxonomy that is used to filter the portfolio/post. Takes effect only if no taxonomy filters are specified when building query.', 'mm_sow'),
                    'options' =>$taxonomies,
                    'default' => 'portfolio_category',
                ),

                'tax_heading_align' => array(
					'type' => 'select',
					'label' => __('Heading / taxonomy filter align', 'mm_sow'),
					'state_emitter' => array(
						'callback' => 'select',
						'args' => array('tax_heading_align')
					),
					'default' => 'align_left',
					'options' => array(
							'align_left'	=> __('Align left', 'mm_sow'),
							'center'		=> __('Centered', 'mm_sow'),
							'align_right'	=> __('Align right', 'mm_sow'),
						)
				),
				
				'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        'filterable' => array(
                            'type' => 'checkbox',
                            'label' => __('Filterable?', 'mm_sow'),
                            'default' => true
                        ),

                        'layout_mode' => array(
                            'type' => 'select',
                            'label' => __('Choose a layout for the grid', 'mm_sow'),
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('layout_mode')
                            ),
                            'default' => 'fitRows',
                            'options' => array(
                                'fitRows' => __('Fit Rows', 'mm_sow'),
                                'masonry' => __('Masonry', 'mm_sow'),
                            )
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
                            'default' => true
                        ),
						
						'display_taxonomy' => array(
							'type' => 'checkbox',
							'label' => __('Display taxonomy info below the post image?', 'mm_sow'),
							'default' => true
						),
						
                        'display_title' => array(
                            'type' => 'checkbox',
                            'label' => __('Display post title below the post image?', 'mm_sow'),
                            'default' => true
                        ),

                        'display_summary' => array(
                            'type' => 'checkbox',
                            'label' => __('Display post excerpt/summary below the post image?', 'mm_sow'),
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

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
                        ),

                        'gutter' => array(
                            'type' => 'number',
                            'label' => __('Gutter', 'mm_sow'),
                            'description' => __('Space between columns in masonry grid.', 'mm_sow'),
                            'default' => 20
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
            );
		
	}
	
    function initialize() {

        $this->register_frontend_scripts(
            array(
                array(
                    'mm_sow-isotope',
                    MM_SOW_PLUGIN_URL . 'assets/js/' . MM_SOW_JS_PREFIX . 'isotope.pkgd' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
                
            )
        );

        $this->register_frontend_styles(
            array(

                array(
                    'mm_sow-frontend-styles',
                    MM_SOW_PLUGIN_URL . 'assets/css/mm_sow-frontend.css',
                    array(),
                    MM_SOW_VERSION
                ),

                array(
                    'mm_sow-icomoon-styles',
                    MM_SOW_PLUGIN_URL . 'assets/css/font-awesome.min.css',
                    array(),
                    MM_SOW_VERSION
                ),
            )
        );

        $this->register_frontend_scripts(array(
                array(
                    'mm_sow-portfolio',
                    plugin_dir_url(__FILE__) . 'js/' . MM_SOW_JS_PREFIX . 'portfolio' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
                array(
                    'mm_sow-portfolio',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );
    }

    function modify_form($form) {
        // Gets taxonomy objects and extracts the 'label' field from each one.
		$taxonomies = wp_list_pluck( get_taxonomies( array(), 'objects' ), 'label' );
		
		$form['taxonomy_filter']['options'] = $taxonomies;
        return $form;
    }

    function get_less_variables($instance) {
        		
		return array(

            'gutter'		=> intval($instance['settings']['gutter']) . 'px',

            // All the responsive sizes
            'tablet_width'	=> intval($instance['settings']['responsive']['tablet']['width']) . 'px',
            'tablet_gutter'	=> intval($instance['settings']['responsive']['tablet']['gutter']) . 'px',
            'mobile_width'	=> intval($instance['settings']['responsive']['mobile']['width']) . 'px',
            'mobile_gutter'	=> intval($instance['settings']['responsive']['mobile']['gutter']) . 'px',
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'posts'				=> $instance['posts'],
            'taxonomy_filter'	=> $instance['taxonomy_filter'],
            'heading'			=> $instance['heading'],
            'tax_heading_align' => $instance['tax_heading_align'],
            'settings'			=> $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-portfolio', __FILE__, 'MM_SOW_Portfolio_Widget');