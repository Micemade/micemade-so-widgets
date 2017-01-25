<?php

/*
Widget Name: Micemade Heading
Description: Create heading for display on the top of a section.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Heading_Widget extends SiteOrigin_Widget {

    function __construct() {

        parent::__construct(
            'mm_sow-heading',
            __('Micemade Heading', 'mm_sow'),
            array(
                'description' => __('Create heading for display on the top of a section.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#heading-widget'
            ),
            array(),
            array(
                
				'heading' => array(
                    'type' => 'text',
                    'label' => __('Heading title', 'mm_sow'),
                    'description' => __('Title for the heading.', 'mm_sow'),
                ),
				
				'heading_tag' => array(
                    'type' => 'select',
                    'label' => __('Heading tag', 'mm_sow'),
                    'default' => 'h3',
                    'options' => array(
                        'h1' => __('H1', 'mm_sow'),
                        'h2' => __('H2', 'mm_sow'),
                        'h3' => __('H3', 'mm_sow'),
                        'h4' => __('H4', 'mm_sow'),
                        'h5' => __('H5', 'mm_sow'),
                        'h6' => __('H6', 'mm_sow'),
                    )
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
                    )
                ),
                'align' => array(
                    'type' => 'select',
                    'description' => __('Alignment of the heading.', 'mm_sow'),
                    'label' => __('Align', 'mm_sow'),
                    'options' => array(
                        'center' => __('Center', 'mm_sow'),
                        'left' => __('Left', 'mm_sow'),
                        'right' => __('Right', 'mm_sow'),
                    ),
                    'default' => 'center'
                ),

                
				'heading_size' => array(
					'type' => 'slider',
					'label' => __( 'Heading title custom text size', 'mm_sow' ),
					'default' => 0,
					'min' => -100,
					'max' => 100,
					'description' => __('Add or subtract from default percentage of 100% for title size', 'mm_sow'),
					'integer' => true
				),
				'heading_color' => array(
					'type' => 'color',
					'label' => __('Header custom font color', 'mm_sow'),
					'default' => '',
				),
				
				'heading_font' => array(
					'type' => 'font',
					'label' => __( 'Heading custom font', 'mm_sow' ),
					'default' => 'default'
				),
				
				'image_id' => array(
					'type' => 'media',
					'label' => __( 'Divider image for title', 'mm_sow' ),
					'description' => __('Upload / choose image as divider. Since it\'s divider, image should be horizontally narrow', 'mm_sow'),
					'choose' => __( 'Choose image', 'mm_sow' ),
					'update' => __( 'Set image', 'mm_sow' ),
					'library' => 'image',
					'fallback' => true
				),
				
                'subtitle' => array(
                    'type' => 'text',
                    'label' => __('Subheading', 'mm_sow'),
                    'description' => __('A subtitle displayed above the title heading.', 'mm_sow'),
                    'state_handler' => array(
                        'style[style2]' => array('show'),
                        '_else[style]' => array('hide'),
                    ),
                ),
				'subheading_size' => array(
					'type' => 'slider',
					'label' => __( 'Sub-heading custom text size', 'mm_sow' ),
					'default' => 0,
					'min' => -100,
					'max' => 100,
					'integer' => true
				),
				'subheading_color' => array(
					'type' => 'color',
					'label' => __('Sub-heading custom font color', 'mm_sow'),
					'default' => '',
				),
				'subheading_font' => array(
					'type' => 'font',
					'label' => __( 'Subheading Font', 'mm_sow' ),
					'default' => 'default',
					'state_handler' => array(
                        'style[style2]' => array('show'),
                        '_else[style]' => array('hide'),
                    ),
				),
                'short_text' => array(
                    'type' => 'textarea',
                    'label' => __('Short Text', 'mm_sow'),
                    'description' => __('Short text generally displayed below the heading title.', 'mm_sow'),
                    'state_handler' => array(
                        'style[style3]' => array('hide'),
                        '_else[style]' => array('show')
                    ),
                ),

            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'mm_sow-heading',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'heading'		=> $instance['heading'],
            'heading_tag'	=> $instance['heading_tag'],
			'style'			=> $instance['style'],
            'align'			=> $instance['align'],
            'heading_size'	=> $instance['heading_size'],
            'heading_color'	=> $instance['heading_color'],
			'heading_font'	=> $instance['heading_font'],
            'short_text'	=> !empty($instance['short_text']) ? $instance['short_text'] : '',
            'subtitle'		=> !empty($instance['subtitle']) ? $instance['subtitle'] : '',
			'subheading_size'=> $instance['subheading_size'],
			'subheading_color'=> $instance['subheading_color'],
			'subheading_font'=> $instance['subheading_font'],
			'image_id'		=> $instance['image_id'],
        );
    }
	
	function get_less_variables( $instance ) {
		
		$less_vars = array();
		
		// Headline font family and weight
		if ( ! empty( $instance['heading_font'] ) ) {
			$font = siteorigin_widget_get_font( $instance['heading_font'] );
			$less_vars['headline_font'] = $font['family'];
			if ( ! empty( $font['weight'] ) ) {
				$less_vars['headline_font_weight'] = $font['weight'];
			}
		}
		// Sub headline font family and weight
		if ( ! empty( $instance['subheading_font'] ) ) {
			$font = siteorigin_widget_get_font( $instance['subheading_font'] );
			$less_vars['sub_headline_font'] = $font['family'];
			if ( ! empty( $font['weight'] ) ) {
				$less_vars['sub_headline_font_weight'] = $font['weight'];
			}
		}
		
		return $less_vars;
	}

	function get_google_font_fields( $instance ) {
		return array(
			$instance['heading_font'],
			$instance['subheading_font'],
		);
	}
	
}

siteorigin_widget_register('mm_sow-heading', __FILE__, 'MM_SOW_Heading_Widget');