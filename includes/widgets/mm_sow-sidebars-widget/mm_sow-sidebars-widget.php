<?php

/*
Widget Name: Micemade Sidebars
Description: Choose one of registered sidebars to display.
Author: Micemade
Author URI: http://micemade.com
*/


class MM_SOW_Sidebards_Widget extends SiteOrigin_Widget {

    /**
     * Holds the ID for the button element used for generating custom CSS.
     */
    private $element_id = '';

    function __construct() {
        parent::__construct(
            "mm_sow-sidebars",
            __("Micemade Sidebars", 'mm_sow'),
            array(
                "description" => __("Choose one of registered sidebars to display.", 'mm_sow'),
                "panels_icon" => "mm-widgets-icon",
                'help' => MM_SOW_PLUGIN_HELP_URL. '#sidebars-widget'

            ),
            array(),
            false,
			plugin_dir_path(__FILE__)
        );
    }
	function get_widget_form() {
		
		return array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", 'mm_sow'),
                ),

                'widget_area' => array(
                    'type' => 'select',
                    'label' => __('Choose a sidebar (widget area)', 'mm_sow'),
                    'default' => 'none',
                    'options' => apply_filters( 'mm_sow_get_widgets','' )
                ),
                
            );
		
	}
	
	function modify_form( $form ) {
        // We can modify this $form array however we want
        $form['widget_area'] =  array(
                    'type' => 'select',
                    'label' => __('Choose theme sidebar (widget area)', 'mm_sow'),
                    'default' => 'none',
                    'options' => apply_filters( 'mm_sow_get_widgets','' )
                );
        return $form;
    }
	
	/* 
    function modify_instance($instance) {
		
		if( isset( $instance['widget_area'] ) ) {
			
			$instance['widget_area'] = array();
			if( isset( $instance['widget_area']['options'] ) ) {
				$instance['widget_area']['options'] = apply_filters( 'mm_sow_get_widgets','' );
			}

			unset( $instance['widget_area'] );

		}
		return $instance;
		
	}
	*/
    function get_template_variables($instance, $args) {
        return array(
            "id" => $this->element_id,
            "widget_area" => $instance["widget_area"],
            
        );
    }

}

siteorigin_widget_register("mm_sow-sidebars", __FILE__, "MM_SOW_Sidebards_Widget");