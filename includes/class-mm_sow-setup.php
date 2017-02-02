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
            add_filter('siteorigin_panels_css_object', array($this, 'filter_css_object'), 10, 3);

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
		
        function filter_css_object($css, $panels_data, $post_id) {

			// Custom attributes for row on different screens
			foreach ($panels_data['grids'] as $gi => $grid) {

                $grid_id = !empty($grid['style']['id']) ? (string)sanitize_html_class($grid['style']['id']) : intval($gi);

                // Custom row padding on different screens
				$padd_tablet = isset( $grid['style']['padding_tablet'] ) ? $grid['style']['padding_tablet'] : null;
				$padd_mobile = isset( $grid['style']['padding_mobile'] ) ? $grid['style']['padding_mobile'] : null;

				if( $padd_tablet ) {
					$css->add_row_css( $post_id, $grid_id, '.panel-row-style', array('padding' => $padd_tablet .'!important' ), 960);
				}
				if( $padd_mobile ) {
					$css->add_row_css( $post_id, $grid_id, '.panel-row-style', array('padding' => $padd_mobile .'!important' ), 478);
				}
				
				// Custom row margin
				$margin = isset( $grid['style']['margin'] ) ? $grid['style']['margin'] : null;
				
				if( $margin ) {
					$css->add_row_css( $post_id, $grid_id, '.panel-row-style', array('margin' => $margin  ) );
				}
				
				// Custom row margin on different screens
				$margin_tablet = isset( $grid['style']['margin_tablet'] ) ? $grid['style']['margin_tablet'] : null;
				$margin_mobile = isset( $grid['style']['margin_mobile'] ) ? $grid['style']['margin_mobile'] : null;

				if( $margin_tablet ) {
					$css->add_row_css( $post_id, $grid_id, '.panel-row-style', array('margin' => $margin_tablet .'!important' ), 960);
				}
				if( $margin_mobile ) {
					$css->add_row_css( $post_id, $grid_id, '.panel-row-style', array('margin' => $margin_mobile .'!important' ), 478);
				}
				
				/* 
				$top_padding = (isset($grid['style']['top_padding']) ? $grid['style']['top_padding'] : null);
                $bottom_padding = (isset($grid['style']['bottom_padding']) ? $grid['style']['bottom_padding'] : null);;

                // Filter the bottom margin for this row with the arguments
                if ($top_padding)
                    $css->add_row_css($post_id, $grid_id, '.mm_sow-row', array('padding-top' => $top_padding), 1920);
                if ($bottom_padding)
                    $css->add_row_css($post_id, $grid_id, '.mm_sow-row', array('padding-bottom' => $bottom_padding), 1920);

                $top_padding = (isset($grid['style']['tablet_top_padding']) ? $grid['style']['tablet_top_padding'] : null);
                $bottom_padding = (isset($grid['style']['tablet_bottom_padding']) ? $grid['style']['tablet_bottom_padding'] : null);;

                // Filter the bottom margin for this row with the arguments
                if ($top_padding)
                    $css->add_row_css($post_id, $grid_id, '.mm_sow-row', array('padding-top' => $top_padding), 960);
                if ($bottom_padding)
                    $css->add_row_css($post_id, $grid_id, '.mm_sow-row', array('padding-bottom' => $bottom_padding), 960);


                $top_padding = (isset($grid['style']['mobile_top_padding']) ? $grid['style']['mobile_top_padding'] : null);
                $bottom_padding = (isset($grid['style']['mobile_bottom_padding']) ? $grid['style']['mobile_bottom_padding'] : null);;

                // Filter the bottom margin for this row with the arguments
                if ($top_padding)
                    $css->add_row_css($post_id, $grid_id, '.mm_sow-row', array('padding-top' => $top_padding), 478);
                if ($bottom_padding)
                    $css->add_row_css($post_id, $grid_id, '.mm_sow-row', array('padding-bottom' => $bottom_padding), 478);
				 */

            }

			/**
			 *  Custom attributes for particular widgets
			 *   - paddings on different screens
			 *   - maximum width for widgets
			 *   - remove default widget bottom-margin
			 */

			$widgets = $panels_data['widgets'];

			foreach( $widgets as $wi => $widget ){
				
				$panels_info	= $widget['panels_info'];
				$grid_id		= $panels_info['grid'];
				$cell_id		= $panels_info['cell'];
				$panel			= $panels_info['cell_index'];
				$panel_id		= $post_id.'-'.$grid_id .'-'.$cell_id.'-'.$panel;
				
				// Custom attributes for widget on different screens
				$padd_tablet = isset( $panels_info['style']['padding_tablet'] ) ? $panels_info['style']['padding_tablet'] : null;
				$padd_mobile = isset( $panels_info['style']['padding_mobile'] ) ? $panels_info['style']['padding_mobile'] : null;

				if( $padd_tablet ) {
					$css->add_cell_css( $post_id, $grid_id, $cell_id, '#panel-'. $panel_id .' .mm_sow-widget-custom-sizes', array('padding' => $padd_tablet .'!important' ), 960);
				}
				if( $padd_mobile ) {
					$css->add_cell_css( $post_id, $grid_id, $cell_id, '#panel-'. $panel_id .' .mm_sow-widget-custom-sizes', array('padding' => $padd_mobile .'!important' ), 478);
				}
				
				// Custom attributes for widget - maximum width
				$max_width = mm_sow_get_option('mm_sow_max_widget_width', "initial" ); // plugin settings
			
				if(  isset( $panels_info['style']['max_width'] ) ) {
					if( $panels_info['style']['max_width'] ) {
						
						$css->add_cell_css( $post_id, $grid_id, $cell_id, '#panel-'. $panel_id .' .mm_sow-widget-custom-sizes', array('max-width' => $max_width .'; margin: 0 auto;' ) );
					}
				}
				// Remove default widget bottom-margin
				if(  isset( $panels_info['style']['no_bottom_margin'] ) ) {
					if( $panels_info['style']['no_bottom_margin'] ) {
						
						$css->add_cell_css( $post_id, $grid_id, $cell_id, '#panel-'. $panel_id .'', array('margin-bottom'=>'0;' ) );
					}
				}
				 
			}
			
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
