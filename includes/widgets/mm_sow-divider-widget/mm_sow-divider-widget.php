<?php

/*
Widget Name: Micemade Divider / Spacer
Description: Create divider or create empty space.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Divider_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'mm_sow-divider',
			__( 'Micemade Divider / Spacer', 'mm_sow' ),
			array(
				'description' => __( 'Create divider or create empty space.', 'mm_sow' ),
				'panels_icon' => 'mm-widgets-icon',
				//'help'        => ''
			),
			array(
			),
			false,
			plugin_dir_path(__FILE__)
		);
	}

	function get_widget_form() {
		return array(

			'type'            => array(
				'type'           => 'select',
				'label'          => __( 'Type', 'mm_sow' ),
				'default'        => 'none',
				'options'        => array(
					'none'          => __( 'Gap', 'mm_sow' ),
					'solid'         => __( 'Single Line', 'mm_sow' ),
					'double'        => __( 'Double Line', 'mm_sow' ),
					'dotted'        => __( 'Dotted Line', 'mm_sow' ),
					'dashed'        => __( 'Dashed Line', 'mm_sow' )
				)
			),

			'styling'         => array(
				'type'           => 'section',
				'label'          => __( 'Styling' , 'mm_sow' ),
				'hide'           => true,
				'fields'         => array(

					'color'         => array(
						'type'         => 'color',
						'label'        => __( 'Color', 'mm_sow' ),
						'description'  => __( 'Select the color of your divider.', 'mm_sow' ),
						'default'      => '#333'
					),

					'size'          => array(
						'type'         => 'measurement',
						'label'        => __( 'Thickness', 'mm_sow' ),
						'default'      => '3px'
					),

					'width'         => array(
						'type'         => 'measurement',
						'label'        => __( 'Width', 'mm_sow' ),
						'default'      => '100%'
					),

					'margin-top'    => array(
						'type'         => 'measurement',
						'label'        => __( 'Margin Top', 'mm_sow' ),
						'default'      => '0'
					),

					'margin-bottom' => array(
						'type'         => 'measurement',
						'label'        => __( 'Margin Bottom', 'mm_sow' ),
						'default'      => '0'
					),

				)
			),

			'attributes'         => array(
				'type'           => 'section',
				'label'          => __( 'Attributes' , 'mm_sow' ),
				'hide'           => true,
				'fields'         => array(

					'divider'         => array(
						'type'         => 'text',
						'label'        => __( 'Divider Class', 'mm_sow' ),
					),

				)
			),
			'visibility' => array(
				'type' => 'section',
				'label' => __('Visibility', 'mm_sow'),
				'hide' => true,
				'fields' => array(

					'hide_desktop' => array(
						'type' => 'checkbox',
						'label' => __('Hide in desktop view?', 'mm_sow'),
						'default' => false
					),

					'tablet' => array(
						'type' => 'section',
						'label' => __('Tablet', 'mm_sow'),
						'fields' => array(

							'hide' => array(
								'type' => 'checkbox',
								'label' => __('Hide in tablet view?', 'mm_sow'),
								'default' => false
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

							'hide' => array(
								'type' => 'checkbox',
								'label' => __('Hide in mobile view?', 'mm_sow'),
								'default' => false
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

			),// visibility section
		);
	}

	function get_less_variables( $instance ) {

		if( empty( $instance ) ) return array();

		return array(
			'type'			=> $instance['type'],
			'color'			=> $instance['styling']['color'],
			'size'			=> $instance['styling']['size'],
			'width'			=> $instance['styling']['width'],
			'm-top'			=> $instance['styling']['margin-top'],
			'm-btm'			=> $instance['styling']['margin-bottom'],
			'hide_desktop'	=> $instance['visibility']['hide_desktop'],
			'hide_on_tablet'=> $instance['visibility']['tablet']['hide'],
			'hide_on_mobile'=> $instance['visibility']['mobile']['hide'],
			'tablet_width'  => intval($instance['visibility']['tablet']['width']),
            'mobile_width'  => intval($instance['visibility']['mobile']['width'])
		);
	}

	function get_template_variables( $instance, $args ) {

		if( empty( $instance ) ) return array();

		return array(
			'class_divider' => $instance['attributes']['divider'],
		);
	}

}

siteorigin_widget_register( 'mm_sow-divider', __FILE__, 'MM_SOW_Divider_Widget' );
