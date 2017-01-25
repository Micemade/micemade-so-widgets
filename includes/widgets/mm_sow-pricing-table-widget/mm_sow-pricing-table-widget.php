<?php

/*
Widget Name: Micemade Pricing Table
Description: Display pricing plans in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Pricing_Table_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-pricing-plans',
            __('Micemade Pricing Table', 'mm_sow'),
            array(
                'description' => __('Display pricing table in a multi-column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#pricing-table'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

                'pricing-plans' => array(
                    'type' => 'repeater',
                    'label' => __('Pricing Table', 'mm_sow'),
                    'item_name' => __('Pricing Plan', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='pricing-plans-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'pricing_title' => array(
                            'type' => 'text',
                            'label' => __('Pricing Plan Title', 'mm_sow'),
                            'description' => __('The title for the pricing plan', 'mm_sow'),
                        ),

                        'tagline' => array(
                            'type' => 'text',
                            'label' => __('Tagline Text', 'mm_sow'),
                            'description' => __('Provide any subtitle or taglines like "Most Popular", "Best Value", "Best Selling", "Most Flexible" etc. that you would like to use for this pricing plan.', 'mm_sow'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Image', 'mm_sow'),
                        ),

                        'price_tag' => array(
                            'type' => 'text',
                            'label' => __('Price Tag', 'mm_sow'),
                            'description' => __('Enter the price tag for the pricing plan. HTML is accepted.', 'mm_sow'),
                        ),

                        'button_text' => array(
                            'type' => 'text',
                            'label' => __('Text for Pricing Link/Button', 'mm_sow'),
                            'description' => __('Provide the text for the link or the button shown for this pricing plan.', 'mm_sow'),
                        ),

                        'url' => array(
                            'type' => 'link',
                            'label' => __('URL for the Pricing link/button', 'mm_sow'),
                            'description' => __('Provide the target URL for the link or the button shown for this pricing plan.', 'mm_sow'),
                        ),

                        'button_new_window' => array(
                            'type' => 'checkbox',
                            'label' => __('Open Button URL in a new window', 'mm_sow'),
                        ),

                        'highlight' => array(
                            'type' => 'checkbox',
                            'label' => __('Highlight Pricing Plan', 'mm_sow'),
                            'description' => __('Specify if you want to highlight the pricing plan.', 'mm_sow'),
                        ),

                        'items' => array(
                            'type' => 'repeater',
                            'label' => __('Pricing Plan Details', 'mm_sow'),
                            'item_name' => __('Pricing Item', 'mm_sow'),
                            'item_label' => array(
                                'selector' => "[id*='pricing-plans-items-text']",
                                'update_event' => 'change',
                                'value_method' => 'val'
                            ),
                            'fields' => array(
                                'title' => array(
                                    'type' => 'text',
                                    'label' => __('Title', 'mm_sow'),
                                ),
                                'value' => array(
                                    'type' => 'text',
                                    'label' => __('Value', 'mm_sow'),
                                ),
                                'icon_new' => array(
                                    'type' => 'icon',
                                    'label' => __('Icon', 'mm_sow'),
                                ),
                            ),
                        ),


                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Pricing Columns per row', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
                        ),
                    )
                ),

            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'mm_sow-pricing-plans',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'pricing_plans' => !empty($instance['pricing-plans']) ? $instance['pricing-plans'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-pricing-plans', __FILE__, 'MM_SOW_Pricing_Table_Widget');