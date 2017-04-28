<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('MM_SOW_Setup')):

    class MM_SOW_Setup {
		
		public function __construct() {

            add_filter('siteorigin_widgets_widget_folders', array($this, 'add_widgets_collection'));
            add_filter('siteorigin_widgets_field_class_prefixes', array($this, 'custom_fields_class_prefixes'));
            add_filter('siteorigin_widgets_field_class_paths', array($this, 'custom_fields_class_paths'));

            add_filter('siteorigin_panels_widget_dialog_tabs', array($this, 'add_widget_tabs'), 20);

            add_filter('siteorigin_panels_widgets', array($this, 'add_bundle_groups'), 11);


			add_filter('siteorigin_panels_row_style_fields', array($this, 'row_style_fields'));
			add_filter('siteorigin_panels_row_style_attributes', array($this, 'row_style_attributes'), 10, 2);
			
			add_filter('siteorigin_panels_widget_style_fields', array($this, 'widget_style_fields'));
            add_filter('siteorigin_panels_widget_style_attributes', array($this, 'widget_style_attributes'), 10, 2);

            // Main filter to add any custom CSS.
            add_filter('siteorigin_panels_css_object', array($this, 'filter_css_object'), 10, 4);

            add_filter('siteorigin_widgets_default_active', array($this, 'activate_plugin_widgets'));
			
        }

        function row_style_fields($fields) {

            $fields['scroll_identifier'] = array(
				'name'        => __('Row unique identifier', 'mm_sow'),
				'type'        => 'text',
				'group'       => 'attributes',
				'description' => __('Enter unique identifier, which will be used for anchor links (e.g. in "Micemade Hero")', 'mm_sow'),
				'priority'    => 10,
			);
			
			$fields['max_width'] = array(
                'name' => __('Limit to maximum width', 'mm_sow'),
                'type' => 'checkbox',
                'group' => 'layout',
				'default' => false,
				'label'	=> __('Enable max. width limit ','mm_sow'),
                'description' => __('Applies only to standard row layout. Row maximum width is set in plugin settings', 'mm_sow'),
                'priority' => 1,
            );
			
			$fields['padding_tablet'] = array(
				'name'		=> __('Padding for tablet', 'mm_sow'),
				'type'		=> 'measurement',
				'group'		=> 'layout',
				'description' => __('Padding around the entire row.', 'mm_sow'),
				'priority'	=> 8,
				'multiple'	=> true
			);
			$fields['padding_mobile'] = array(
				'name'		=> __('Padding for mobiles', 'mm_sow'),
				'type'		=> 'measurement',
				'group'		=> 'layout',
				'description' => __('Padding around the entire row.', 'mm_sow'),
				'priority'	=> 8,
				'multiple'	=> true
			);
			
			
			$fields['margin_mobile'] = array(
				'name'		=> __('Margin for mobiles', 'mm_sow'),
				'type'		=> 'measurement',
				'group'		=> 'layout',
				'description' => __('Margin around the entire row on mobile devices', 'mm_sow'),
				'priority'	=> 9,
				'multiple'	=> true
			);
			$fields['margin_tablet'] = array(
				'name'		=> __('Margin for tablet', 'mm_sow'),
				'type'		=> 'measurement',
				'group'		=> 'layout',
				'description' => __('Margin around the entire row on tablet devices', 'mm_sow'),
				'priority'	=> 9,
				'multiple'	=> true
			);
			$fields['margin'] = array(
				'name'		=> __('Row margin', 'mm_sow'),
				'type'		=> 'measurement',
				'group'		=> 'layout',
				'description' => __('Margin around the entire row.', 'mm_sow'),
				'priority'	=> 9,
				'multiple'	=> true
			);
			
          
		  // Add design fields
		  
            $fields['mm_sow_dark_bg'] = array(
                'name' => __('Dark Background?', 'mm_sow'),
                'type' => 'checkbox',
                'group' => 'design',
                'label' => __('Indicate if this row has a dark background color. Dark color scheme will be applied for all widgets in this row.', 'mm_sow'),
                'default' => false,
                'priority' => 4,
            );

            $fields['mm_sow_row_bg_position'] = array(
                'name' => __('Background image position', 'mm_sow'),
                'type' => 'select',
                'group' => 'design',
                'label' => __('', 'mm_sow'),
                'default' => 'center_center',
                'options' => array(
					'left_top'		=> __('Left top', 'mm_sow'),
					'left_center'	=> __('Left middle', 'mm_sow'),
					'left_bottom'	=> __('Left bottom', 'mm_sow'),
					'right_top'		=> __('Right top', 'mm_sow'),
					'right_center'	=> __('Right Middle', 'mm_sow'),
					'right_bottom'	=> __('Right Bottom', 'mm_sow'),
					'center_top'	=> __('Center top', 'mm_sow'),
					'center_center'	=> __('Center', 'mm_sow'),
					'center_bottom'	=> __('Center Bottom', 'mm_sow'),
				),
				'description' => __('This setting will only apply if "Background Image Display" is set to "Fixed" or "Cover".', 'mm_sow'),
                'priority' => 8,
            );


            return $fields;
        }


        function row_style_attributes( $attributes, $args ) {

            $max_width = mm_sow_get_option('mm_sow_max_widget_width', "initial"); // plugin settings
			
			if (!empty($args['mm_sow_dark_bg'])) {
                if (empty($attributes['class']))
                    $attributes['class'] = array();

                $attributes['class'][] = 'mm_sow-dark-bg';
            }

			if( isset( $args['max_width'] )  ) {

				$standard_row_width = ( !empty( $args['row_stretch']) ) ? false : true; // $max_width applies only to standard row layout
				
				if( $args['max_width'] && $standard_row_width ) {
					$attributes['style'] .= "max-width:$max_width; margin: 0 auto;";
					
				}
			}
			
			if( isset( $args['mm_sow_row_bg_position'] ) ) {
			
				$back_pos = str_replace( '_',' ', $args['mm_sow_row_bg_position']);
				$attributes['style'] .= "background-position: $back_pos;";
			
			}
			
			if( isset( $args['scroll_identifier'] ) ) {
				if( $args['scroll_identifier'] ) {
					$data_anchor = $args['scroll_identifier'];
					$attributes['data-anchor'] = "$data_anchor";
				}
			}
			
			
            return $attributes;
        }
		
		function widget_style_fields($fields) {
			// in widget "Design" fields
			$fields['back_color_opacity'] = array(
				'name'        => __('Background color opacity', 'mm_sow'),
				'type'        => 'text',
				'group'       => 'design',
				'description' => __('Set opacity value, between 0 - 100 (only number, no units)', 'mm_sow'),
				'priority'    => 5,
			);
			// in widget "Layout" fields
			$fields['max_width'] = array(
                'name' => __('Limit to maximum width', 'mm_sow'),
                'type' => 'checkbox',
                'group' => 'layout',
				'default' => false,
				'label'	=> __('Enable max. width limit','mm_sow'),
                'description' => __('Widget maximum width is set in plugin settings', 'mm_sow'),
                'priority' => 1,
            );
			$fields['no_bottom_margin'] = array(
                'name' => __('No bottom margin', 'mm_sow'),
                'type' => 'checkbox',
                'group' => 'layout',
				'default' => false,
				'label'	=> __('Set default bottom margin to zero','mm_sow'),
                'priority' => 2,
            );
			$fields['padding_tablet'] = array(
				'name'		=> __('Padding for tablet', 'mm_sow'),
				'type'		=> 'measurement',
				'group'		=> 'layout',
				'description' => __('Padding around the entire widget.', 'mm_sow'),
				'priority'	=> 8,
				'multiple'	=> true
			);
			$fields['padding_mobile'] = array(
				'name'		=> __('Padding for mobiles', 'mm_sow'),
				'type'		=> 'measurement',
				'group'		=> 'layout',
				'description' => __('Padding around the entire widget.', 'mm_sow'),
				'priority'	=> 9,
				'multiple'	=> true
			);
			
			$fields['mm_sow_widget_bg_position'] = array(
                'name' => __('Background image position', 'mm_sow'),
                'type' => 'select',
                'group' => 'design',
                'label' => __('', 'mm_sow'),
                'default' => 'center_center',
                'options' => array(
					'left_top'		=> __('Left top', 'mm_sow'),
					'left_center'	=> __('Left middle', 'mm_sow'),
					'left_bottom'	=> __('Left bottom', 'mm_sow'),
					'right_top'		=> __('Right top', 'mm_sow'),
					'right_center'	=> __('Right Middle', 'mm_sow'),
					'right_bottom'	=> __('Right Bottom', 'mm_sow'),
					'center_top'	=> __('Center top', 'mm_sow'),
					'center_center'	=> __('Center', 'mm_sow'),
					'center_bottom'	=> __('Center Bottom', 'mm_sow'),
				),
                'priority' => 8,
            );
			
			return $fields;
		}

		function widget_style_attributes( $attributes, $args ) {
			
			
			if( !empty( $args['back_color_opacity'] ) && !empty( $args['background'] ) ) {

				$opacity	= intval( $args['back_color_opacity']  )/100;
				$color_rgb	= apply_filters( 'mm_sow_hex2rgb', $args['background'] );
				$attributes['style'] .= 'background-color: rgba('. $color_rgb .','.$opacity .') !important;' ;
				
			}
			if( !empty( $args['padding_tablet'] ) || !empty( $args['padding_mobile'] ) || !empty( $args['max_width'] ) ) {
				 
				 $attributes['class'][] = 'mm_sow-widget-custom-sizes';
				
			}
			
			if( ! empty( $args['no_bottom_margin'] ) ){
				
				$attributes['class'][] = 'mm_sow-widget-no-bottom-margin';
			}
			
			if( ! empty( $args['mm_sow_widget_bg_position'] ) ) {
			
				$back_pos = str_replace( '_',' ', $args['mm_sow_widget_bg_position']);
				$attributes['style'] .= "background-position: $back_pos;";
			
			}
			
			
			return $attributes;
		}
		
        function filter_css_object($css, $panels_data, $post_id, $layout) {

			// Get option from MM SOW plugin - maximum width
			$max_width = mm_sow_get_option('mm_sow_max_widget_width', "initial" ); // from MM SOW plugin settings
			
			// Custom attributes for row on different screens
			foreach ($layout as $ri => $row) {
				
				if( empty( $row[ 'style' ] ) ) $row[ 'style' ] = array();

                // Custom row padding and margins on different screens
				$padd_tablet	= isset( $row['style']['padding_tablet'] )	? $row['style']['padding_tablet'] : null;
				$padd_mobile	= isset( $row['style']['padding_mobile'] )	? $row['style']['padding_mobile'] : null;
				$margin			= isset( $row['style']['margin'] ) 			? $row['style']['margin'] : null;
				$margin_tablet	= isset( $row['style']['margin_tablet'] )	? $row['style']['margin_tablet'] : null;
				$margin_mobile	= isset( $row['style']['margin_mobile'] )	? $row['style']['margin_mobile'] : null;
				
				if( $padd_tablet ) {
					$css->add_row_css( $post_id, $ri, '> .panel-row-style', array('padding' => $padd_tablet .'!important' ), 960);
				}
				if( $padd_mobile ) {
					$css->add_row_css( $post_id, $ri, '> .panel-row-style', array('padding' => $padd_mobile .'!important' ), 478);
				}
				if( $margin ) {
					$css->add_row_css( $post_id, $ri, '> .panel-row-style', array('margin' => $margin  ) );
				}
				if( $margin_tablet ) {
					$css->add_row_css( $post_id, $ri, '> .panel-row-style', array('margin' => $margin_tablet .'!important' ), 960);
				}
				if( $margin_mobile ) {
					$css->add_row_css( $post_id, $ri, '> .panel-row-style', array('margin' => $margin_mobile .'!important' ), 478);
				}
				
				
				// Process the cells if there are any
				if( empty( $row[ 'cells' ] ) ) continue;
				
				foreach( $row[ 'cells' ] as $ci => $cell ) {						
					
					if( empty( $cell[ 'widgets' ] ) ) continue;
					
					// Process the widgets if there are any
					foreach( $cell['widgets'] as $wi => $widget ) {


						 //  Custom attributes for particular widgets
						 //   - paddings on different screens
						 //   - maximum width for widgets
						 //   - remove default widget bottom-margin
						
						$widget_style = !empty( $widget['panels_info']['style'] ) ? $widget['panels_info']['style'] : array();

						// Custom css attributes for widget
						$padd_tablet		= isset( $widget_style['padding_tablet'] )	 ? $widget_style['padding_tablet'] : 0;
						$padd_mobile		= isset( $widget_style['padding_mobile'] )	 ? $widget_style['padding_mobile'] : 0;
						$max_width_true		= isset( $widget_style['max_width'] ) 		 ? $widget_style['max_width'] : 0;
						$no_bottom_margin	= isset( $widget_style['no_bottom_margin'] ) ? $widget_style['no_bottom_margin']: 0;
						
						if( $padd_tablet ) {
							$css->add_widget_css( $post_id, $ri, $ci, $wi, '> .panel-widget-style', array( 'padding' => $padd_tablet ), 960);
						}
						
						if( $padd_mobile ) {
							$css->add_widget_css( $post_id, $ri, $ci, $wi, '> .panel-widget-style', array( 'padding' => $padd_mobile ) , 478);
						}
						
						if( $max_width_true ) {							
							$css->add_widget_css( $post_id, $ri, $ci, $wi, '> .panel-widget-style', array( 'max-width' =>  $max_width, 'margin' => '0 auto' ) );
						}
						if( $no_bottom_margin ) {							
							$css->add_widget_css( $post_id, $ri, $ci, $wi, '', array( 'margin-bottom' => '0 !important' ) );
						}
									
						
					} // end foreach widget
					
				} // end foreach cell
		   
		   } // end foreach row
			
           return $css;
		   
        }

        function add_widgets_collection($folders) {
            $folders[] = MM_SOW_PLUGIN_DIR . 'includes/widgets/';
            return $folders;
        }


        // Placing all widgets under the 'SiteOrigin Widgets' Tab
        function add_widget_tabs($tabs) {
            $tabs[] = array(
                'title' => __('Micemade SO Widgets', 'mm_sow'),
                'filter' => array(
                    'groups' => array('mm_sow-widgets')
                )
            );
            return $tabs;
        }


        // Adding group for all Widgets
        function add_bundle_groups($widgets) {
            foreach ($widgets as $class => &$widget) {
                if (preg_match('/MM_SOW_(.*)_Widget/', $class, $matches)) {
                    $widget['groups'] = array('mm_sow-widgets');
                }
            }
            return $widgets;
        }


        function custom_fields_class_prefixes($class_prefixes) {
            $class_prefixes[] = 'MM_SOW_Custom_Field_';
            return $class_prefixes;
        }

        function custom_fields_class_paths($class_paths) {
            $class_paths[] = MM_SOW_PLUGIN_DIR . 'includes/fields/';
            return $class_paths;
        }

        function activate_plugin_widgets($default_widgets) {

            $auto_activate = mm_sow_get_option('mm_sow_autoload_widgets', false);

            if (!$auto_activate)
                return $default_widgets;

            $plugin_widgets = array(

                "mm_sow-accordion-widget"		=> true,
                "mm_sow-button-widget"			=> true,
                "mm_sow-carousel-widget"		=> true,
                "mm_sow-clients-widget"			=> true,
				"mm_sow-divider-widget"			=> true,
                "mm_sow-heading-widget"			=> true,
                "mm_sow-hero-image-widget"		=> true,
                "mm_sow-icon-list-widget"		=> true,
                "mm_sow-odometers-widget"		=> true,
                "mm_sow-piecharts-widget"		=> true,
                "mm_sow-portfolio-widget"		=> true,
                "mm_sow-posts-carousel-widget"	=> true,
                "mm_sow-pricing-table-widget"	=> true,
                "mm_sow-services-widget"		=> true,
                "mm_sow-stretcher-widget"		=> true,
                "mm_sow-stats-bar-widget"		=> true,
                "mm_sow-tabs-widget"			=> true,
                "mm_sow-team-members-widget"	=> true,
                "mm_sow-testimonials-slider-widget" => true,
                "mm_sow-testimonials-widget"	=> true,
				"mm_sow-wc-cats-widget"			=> true,
				"mm_sow-sidebars-widget"		=> true,

            );

            return wp_parse_args($plugin_widgets, $default_widgets);

        }
		

    }

endif;

new MM_SOW_Setup();
