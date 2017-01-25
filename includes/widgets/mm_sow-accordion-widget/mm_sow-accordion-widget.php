<?php

/*
Widget Name: Micemade Accordion
Description: Displays collapsible content panels to help display information when space is limited.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Accordion_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-accordion',
            __('Micemade Accordion', 'mm_sow'),
            array(
                'description' => __('Displays collapsible content panels to help display information when space is limited.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#tabs-accordions'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

                'style' => array(
                    'type' => 'select',
                    'label' => __('Choose Accordion Style', 'mm_sow'),
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

                'toggle' => array(
                    'type' => 'checkbox',
                    'label' => __('Allow to function like toggle?', 'mm_sow'),
                    'description' => __('Check if multiple elements can be open at the same time.', 'mm_sow')
                ),

                'accordion' => array(
                    'type' => 'repeater',
                    'label' => __('Accordion', 'mm_sow'),
                    'item_name' => __('Panel', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='accordion-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Panel Title', 'mm_sow'),
                            'description' => __('The title for the panel.', 'mm_sow'),
                        ),

                        'panel_content' => array(
                            'type' => 'tinymce',
                            'label' => __('Panel Content', 'mm_sow'),
                            'description' => __('The collapsible content of the panel in the accordion.', 'mm_sow'),
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
                    'mm_sow-accordion',
                    plugin_dir_url(__FILE__) . 'js/'. MM_SOW_JS_PREFIX .'accordion' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery')
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'mm_sow-accordion',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'toggle' => $instance['toggle'],
            'accordion' => !empty($instance['accordion']) ? $instance['accordion'] : array()
        );
    }

}

siteorigin_widget_register('mm_sow-accordion', __FILE__, 'MM_SOW_Accordion_Widget');