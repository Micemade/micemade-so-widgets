<?php

/*
Widget Name: Micemade Button
Description: Flat style buttons with rich set of customization options.
Author: Micemade
Author URI: http://micemade.com
*/


class MM_SOW_Button_Widget extends SiteOrigin_Widget {

    /**
     * Holds the ID for the button element used for generating custom CSS.
     */
    private $element_id = '';

    function __construct() {
        parent::__construct(
            "mm_sow-button",
            __("Micemade Button", 'mm_sow'),
            array(
                "description" => __("Flat style buttons with rich set of customization options.", 'mm_sow'),
                "panels_icon" => "mm-widgets-icon",
                'help' => MM_SOW_PLUGIN_HELP_URL. '#button-widget'

            ),
            array(),
            array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", 'mm_sow'),
                ),

                "href" => array(
                    "type" => "link",
                    "description" => __("The URL to which button should point to.", 'mm_sow'),
                    "label" => __("Target URL", 'mm_sow'),
                    "default" => __("http://targeturl.com", 'mm_sow'),
                ),
                "text" => array(
                    "type" => "text",
                    "description" => __("The button title or text. ", 'mm_sow'),
                    "label" => __("Button Text", 'mm_sow'),
                    "default" => __("Buy Now", 'mm_sow'),
                ),

                'icon_type' => array(
                    'type' => 'select',
                    'label' => __('Choose Icon Type', 'mm_sow'),
                    'default' => 'none',
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('icon_type')
                    ),
                    'options' => array(
                        'none' => __('None', 'mm_sow'),
                        'icon' => __('Icon', 'mm_sow'),
                        'icon_image' => __('Icon Image', 'mm_sow'),
                    )
                ),

                'icon_image' => array(
                    'type' => 'media',
                    'label' => __('Service Image.', 'mm_sow'),
                    'state_handler' => array(
                        'icon_type[icon_image]' => array('show'),
                        '_else[icon_type]' => array('hide'),
                    ),
                ),

                'icon' => array(
                    'type' => 'icon',
                    'label' => __('Service Icon.', 'mm_sow'),
                    'state_handler' => array(
                        'icon_type[icon]' => array('show'),
                        '_else[icon_type]' => array('hide'),
                    ),
                ),


                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        "class" => array(
                            "type" => "text",
                            "description" => __("The CSS class name for the button element.", 'mm_sow'),
                            "label" => __("Class", 'mm_sow'),
                            "default" => "",
                            "optional" => "true"
                        ),
                        "style" => array(
                            "type" => "text",
                            "description" => __("Inline CSS styling for the button element.", 'mm_sow'),
                            "label" => __("Style", 'mm_sow'),
                            "optional" => "true"
                        ),
                        "color" => array(
                            "type" => "select",
                            "description" => __("The color of the button.", 'mm_sow'),
                            "label" => __("Color", 'mm_sow'),
                            "options" => array(
                                "default" => __("Default", 'mm_sow'),
                                "custom" => __("Custom", 'mm_sow'),
                                "black" => __("Black", 'mm_sow'),
                                "blue" => __("Blue", 'mm_sow'),
                                "cyan" => __("Cyan", 'mm_sow'),
                                "green" => __("Green", 'mm_sow'),
                                "orange" => __("Orange", 'mm_sow'),
                                "pink" => __("Pink", 'mm_sow'),
                                "red" => __("Red", 'mm_sow'),
                                "teal" => __("Teal", 'mm_sow'),
                                "trans" => __("Transparent", 'mm_sow'),
                                "semitrans" => __("Semi Transparent", 'mm_sow'),
                            ),
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('color')
                            ),
                        ),
                        "custom_color" => array(
                            "type" => "color",
                            "description" => __("Custom color of the button.", 'mm_sow'),
                            "label" => __("Custom button color", 'mm_sow'),
                            'state_handler' => array(
                                'color[custom]' => array('show'),
                                '_else[color]' => array('hide'),
                            ),
                        ),
                        "hover_color" => array(
                            "type" => "color",
                            "description" => __("Hover color of the button.", 'mm_sow'),
                            "label" => __("Custom button hover color", 'mm_sow'),
                            "optional" => "true"
                        ),
                        "type" => array(
                            "type" => "select",
                            "label" => __("Button Size", 'mm_sow'),
                            "options" => array(
                                "medium" => __("Medium", 'mm_sow'),
                                "large" => __("Large", 'mm_sow'),
                                "small" => __("Small", 'mm_sow'),
                            )
                        ),

                        'rounded' => array(
                            'type' => 'checkbox',
                            'label' => __('Display rounded button?', 'mm_sow'),
                            'default' => false
                        ),
                        "target" => array(
                            "type" => "checkbox",
                            "label" => __("Open the link in new window", 'mm_sow'),
                            "default" => true,
                        ),
                        "align" => array(
                            "type" => "select",
                            "description" => __("Alignment of the button displayed.", 'mm_sow'),
                            "label" => __("Align", 'mm_sow'),
                            "options" => array(
                                "none" => __("None", 'mm_sow'),
                                "center" => __("Center", 'mm_sow'),
                                "left" => __("Left", 'mm_sow'),
                                "right" => __("Right", 'mm_sow'),
                            ),
                            'default' => 'none'
                        ),
                    )
                ),
            )
        );
    }

    function enqueue_frontend_scripts($instance) {

        wp_enqueue_style('mm_sow-button', siteorigin_widget_get_plugin_dir_url('mm_sow-button') . 'css/style.css', array(), MM_SOW_VERSION);

        $custom_css = $this->custom_css($instance);
        if (!empty($custom_css))
            wp_add_inline_style('mm_sow-button', $custom_css);

        parent::enqueue_frontend_scripts($instance);
    }

    /**
     * Generate the custom layout CSS required
     */
    protected function custom_css($instance) {

        $custom_css = '';

        $this->element_id = uniqid('mm_sow-button-');

        $id_selector = '#' . $this->element_id;

        $button_color = $instance['settings']["color"];

        $custom_color = $instance['settings']["custom_color"];

        $hover_color = $instance['settings']["hover_color"];

        if ($button_color == "custom") {
            if (!empty($custom_color)) {

                $custom_css .= $id_selector . '.mm_sow-button { background-color:' . $custom_color . '; }' . "\n";

                // Automatically set a hover color for custom color if none specified by user
                if (empty($hover_color)) {
                    $hover_color = mm_sow_color_luminance($custom_color, 0.05);
                }
            }
        }

        // Apply the hover color for button of any color provided one is specified
        if (!empty($hover_color)) {
            $custom_css .= $id_selector . '.mm_sow-button:hover { background-color:' . $hover_color . '; }';
        }

        return $custom_css;
    }

    function get_template_variables($instance, $args) {
        return array(
            "id" => $this->element_id,
            "style" => $instance['settings']["style"],
            "class" => $instance['settings']["class"],
            "color" => $instance['settings']["color"],
            "custom_color" => $instance['settings']["custom_color"],
            "hover_color" => $instance['settings']["hover_color"],
            "type" => $instance['settings']["type"],
            "align" => $instance['settings']["align"],
            "target" => $instance['settings']["target"],
            "rounded" => $instance['settings']["rounded"],
            "href" => (!empty($instance['href'])) ? sow_esc_url($instance['href']) : '',
            "text" => $instance["text"],
            'icon_type' => $instance['icon_type'],
            'icon_image' => $instance['icon_image'],
            'icon' => $instance['icon'],
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register("mm_sow-button", __FILE__, "MM_SOW_Button_Widget");