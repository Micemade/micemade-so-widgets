<?php

/*
Widget Name: Micemade WooCommerce Categories
Description: WooCommerce categories to display in a column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_WC_Cats_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-wc-cats',
            __('Micemade WooCommerce Categories', 'mm_sow'),
            array(
                'description' => __('WooCommerce categories to display in a column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#wc-cats-widget'
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
                        'style1' => __('Style 1 - Image background', 'mm_sow'),
                        'style2' => __('Style 2 - Image right', 'mm_sow'),
                        'style3' => __('Style 3 - Image left', 'mm_sow'),
                        'style4' => __('Style 4 - Simple list', 'mm_sow'),
                        'style5' => __('Style 5 - List of all available categories', 'mm_sow'),
                    )
                ),
                
				'image_type' => array(
					'type' => 'select',
					'label' => __('Choose Category Image Type', 'mm_sow'),
					'default' => 'image',
					'description' => __('WC product category images are set in Products > Categories.', 'mm_sow'),
					'state_emitter' => array(
						'callback' => 'select',
						'args' => array('image_type')
					),
					'options' => array(
						'image' => __('Image', 'mm_sow'),
						'icon' => __('Icon', 'mm_sow'),
						'none' => __('None', 'mm_sow'),
					),
					'state_handler' => array(
						'style[style1]' => array('show'),
						'style[style2]' => array('show'),
						'style[style3]' => array('show'),
						'style[style4]' => array('hide'),
						'style[style5]' => array('hide'),
					),
				), // image_type field
				
				'thumb_size' => array(
                    'type' => 'number',
                    'label' => __('Thumb size', 'mm_sow'),
                    'default' => '40',
                    'state_handler' => array(
                        'style[style1]' => array('hide'),
                        'style[style2]' => array('hide'),
                        'style[style3]' => array('hide'),
                        'style[style4]' => array('show'),
                        'style[style5]' => array('hide'),
                    ),
                ),
				'img_format' => array(
					'type' => 'select',
					'label' => __('Choose image format', 'mm_sow'),
					'default' => 'thumbnail',
					'options' => apply_filters("mm_sow_image_sizes",""),
					'state_handler' => array(
                        'style[style1]' => array('show'),
                        'style[style2]' => array('show'),
                        'style[style3]' => array('show'),
                        'style[style4]' => array('hide'),
                    ),
				),

                'wc_cats' => array(

                    'type' => 'repeater',
                    'label' => __('Categories selection', 'mm_sow'),
                    'item_name' => __('WC Category', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='wc_cats-term'] :selected",
                        'update_event' => 'change',
                        'value_method' => 'text'
                    ),
					'state_handler' => array(
						'style[style1]' => array('show'),
						'style[style2]' => array('show'),
						'style[style3]' => array('show'),
						'style[style4]' => array('show'),
						'style[style5]' => array('hide'),
					),

                    'fields' => array(

                        'term' => array(
                            'type' => 'select',
                            'label' => __('Choose Category', 'mm_sow'),
                            'default' => '',
		                        'description' => __('pick single woocommerce products category', 'mm_sow'),
                            'options' => mm_sow_get_terms( 'product_cat' )
                        ),
						
						/* 
						'image_type' => array(
                            'type' => 'select',
                            'label' => __('Choose Category Image Type', 'mm_sow'),
                            'default' => 'image',
				            'description' => __('WC product category images are set in Products > Categories.', 'mm_sow'),
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('image_type_{$repeater}')
                            ),
                            'options' => array(
                                'image' => __('Image', 'mm_sow'),
				                'icon' => __('Icon', 'mm_sow'),
                                'none' => __('None', 'mm_sow'),
                            )
                        ), // image_type field

                        
						// IF IN REPEATER FIELD (to toggle):
						'state_emitter' => array(
							'callback' => 'select',
							'args' => array('image_type_{$repeater}')
						),
						// in field which will be toggled
						'state_handler' => array(
							'image_type_{$repeater}[image]' => array('show'),
							'image_type_{$repeater}[icon]' => array('hide'),
							'image_type_{$repeater}[none]' => array('hide'),
						),
						*/
						
						'custom_image' => array(
                            'type' => 'media',
                            'label' => __('Custom Image.', 'mm_sow'),
                            'description' => __('(*optional) override WC product category image (if set) with custom image .', 'mm_sow'),
                            'state_handler' => array(
                                'image_type[image]' => array('show'),
                                'image_type[icon]' => array('hide'),
                                'image_type[none]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Custom Icon.', 'mm_sow'),
                            'state_handler' => array(
                                'image_type[icon]' => array('show'),
                                'image_type[image]' => array('hide'),
                                'image_type[none]' => array('hide'),
                            ),
                        ), // icon field

						
                        'excerpt' => array(
                            'type' => 'textarea',
                            'label' => __('Short description', 'mm_sow'),
                            'description' => __('*( optional ) Provide a short description. Note: In case of bad readability (dark background), use Edit Row > Row Styles : Design > "Dark Background?" setting.', 'mm_sow'),
                            'state_handler' => array(
                                'style[style1]' => array('show'),
                                'style[style2]' => array('show'),
                                'style[style3]' => array('show'),
                                'style[style4]' => array('hide'),
                                'style[style5]' => array('hide'),
                            ),
                        ), // excerpt field

                        'featured' => array(
                            'type' => 'checkbox',
                            'label' => __('Display category as featured', 'mm_sow'),
                            'description' => __('Make category text bold and slightly shadowed.', 'mm_sow')
                        ),
						
						'additional_args' => array(
							'type' => 'text',
							'label' => __('Additional URL args', 'mm_sow'),
							'description' => __('add additional query arguments', 'mm_sow'),
							'default' => '',
						)

                    ) // fields

                ), // wc_cats repeater field

                'settings' => array(

                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'state_handler' => array(
                        'style[style1]' => array('show'),
                        'style[style2]' => array('show'),
                        'style[style3]' => array('show'),
                        'style[style4]' => array('hide'),
                        'style[style5]' => array('hide'),
                    ),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),

						'overlay_color' => array(
                            'type' => 'color',
                            'label' => __('Overlay color.', 'mm_sow'),

                        ),
						
						 'overlay_opacity' => array(
                            'type' => 'slider',
                            'label' => __('Overlay opacity', 'mm_sow'),
                            'min' => 1,
                            'max' => 100,
                            'integer' => true,
                            'default' => 40
                        ),

						'title_color' => array(
                            'type' => 'color',
                            'label' => __('Category title color.', 'mm_sow'),
                        ),

						'icon_color' => array(
                            'type' => 'color',
                            'label' => __('Icon color.', 'mm_sow'),
							'state_handler' => array(
                                'image_type[icon]' => array('show'),
                                'image_type[image]' => array('hide'),
                                'image_type[none]' => array('hide'),
                            ),
                        ),

						'gutter' => array(
							'type' => 'number',
							'label' => __('Gutter', 'mm_sow'),
							'default' => 20,
							'description' => __('Space between columns.', 'mm_sow'),
						),

						'margin_bottom' => array(
							'type' => 'number',
							'label' => __('Margin bottom', 'mm_sow'),
							'default' => 20,
							'description' => __('Margin bellow the each category.', 'mm_sow'),
						),

						'height' => array(
							'type' => 'number',
							'label' => __('Categories height', 'mm_sow'),
							'default' => 300,
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
                                            'type' => 'number',
                                            'label' => __('Tablet categories height', 'mm_sow'),
                                            'default' => 200,
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
                                            'type' => 'number',
                                            'label' => __('Mobile categories height', 'mm_sow'),
                                            'default' => 150,
                                        ),

                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'mm_sow'),
                                            'description' => __('The resolution to treat as a mobile resolution.', 'mm_sow'),
                                            'default' => 480,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                ) // mobile section

                            ) // fields

                        ),// responsive section

                    ) // settings fields

                ), // settings section
            )
        );
    }

    function enqueue_frontend_scripts($instance) {

        wp_enqueue_style('mm_sow-frontend-styles', MM_SOW_PLUGIN_URL . 'assets/css/mm_sow-frontend.css', array(), MM_SOW_VERSION );

        wp_enqueue_style('mm_sow-wc_cats', siteorigin_widget_get_plugin_dir_url('mm_sow-wc-cats') . 'css/style.css', array(), MM_SOW_VERSION );

        parent::enqueue_frontend_scripts($instance);
    }

    function get_template_variables($instance, $args) {
        return array(
            'style'         	=> $instance['style'],
			'image_type'		=> $instance['image_type'],
            'wc_cats'       	=> !empty($instance['wc_cats']) ? $instance['wc_cats'] : array(),
            'settings'      	=> $instance['settings'],
			'img_format'      	=> $instance['img_format'],
        );
    }

	function get_less_variables($instance) {

        $less_vars = array();

        if( isset($instance['settings'] ) ) {

            $settings = $instance['settings'];
			
			$less_vars['overlay_color']		= $settings['overlay_color'] ;
            $less_vars['overlay_opacity']	= isset( $settings['overlay_opacity']) ? (intval($settings['overlay_opacity']) / 100) : 0.4 ;
            $less_vars['title_color']		= $settings['title_color'] ;
            $less_vars['icon_color']		= isset($settings['icon_color']) ? $settings['icon_color']  : '';
            $less_vars['gutter']        	= intval($settings['gutter']) . 'px' ;
            $less_vars['margin_bottom'] 	= intval($settings['margin_bottom']) . 'px' ;
            $less_vars['height']        	= intval($settings['height']) . 'px' ;
            $less_vars['tablet_width']  	= intval($settings['responsive']['tablet']['width']) . 'px' ;
            $less_vars['mobile_width']  	= intval($settings['responsive']['mobile']['width']) . 'px' ;
            $less_vars['tablet_height'] 	= intval($settings['responsive']['tablet']['height']) . 'px' ;
            $less_vars['mobile_height']		= intval($settings['responsive']['mobile']['height']) . 'px' ;

        }

        $less_vars['thumb_size'] = isset( $instance['thumb_size']) ? intval($instance['thumb_size']) . 'px' : 40;

        return $less_vars;

    }

}

siteorigin_widget_register('mm_sow-wc-cats', __FILE__, 'MM_SOW_WC_Cats_Widget');
