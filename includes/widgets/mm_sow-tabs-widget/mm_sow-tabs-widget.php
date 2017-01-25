<?php

/*
Widget Name: Micemade Tabs
Description: Display tabbed content in variety of styles.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Tabs_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-tabs',
            __('Micemade Tabs', 'mm_sow'),
            array(
                'description' => __('Display tabbed content in variety of styles.', 'mm_sow'),
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
                    'label' => __('Choose Tab Style', 'mm_sow'),
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('style')
                    ),
                    'default' => 'style1',
                    'options' => array(
                        'style1' => __('Tab Style 1', 'mm_sow'),
                        'style2' => __('Tab Style 2', 'mm_sow'),
                        'style3' => __('Tab Style 3', 'mm_sow'),
                        'style4' => __('Tab Style 4', 'mm_sow'),
                        'style5' => __('Tab Style 5', 'mm_sow'),
                        'style6' => __('Tab Style 6', 'mm_sow'),
                        'style7' => __('Vertical Tab Style 1', 'mm_sow'),
                        'style8' => __('Vertical Tab Style 2', 'mm_sow'),
                        'style9' => __('Vertical Tab Style 3', 'mm_sow'),
                        'style10' => __('Vertical Tab Style 4', 'mm_sow'),
                    )
                ),

                'color' => array(
                    'type' => 'color',
                    'label' => __('Tab highlight color', 'mm_sow'),
                    'state_handler' => array(
                        'style[style4,style6,style7,style8]' => array('show'),
                        '_else[style]' => array('hide'),
                    ),
                    'default' => '#f94213',
                ),

                'mobile_width' => array(
                    'type' => 'text',
                    'label' => __('Mobile Resolution', 'mm_sow'),
                    'description' => __('The resolution to treat as a mobile resolution for invoking responsive tabs.', 'mm_sow'),
                    'default' => 767,
                    'sanitize' => 'intval',
                ),

                'icon_type' => array(
                    'type' => 'select',
                    'label' => __('Choose Icon Type', 'mm_sow'),
                    'description' => __('Some styles may ignore icons chosen.', 'mm_sow'),
                    'default' => 'none',
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('icon_type')
                    ),
                    'state_handler' => array(
                        'style[style2]' => array('hide'),
                        '_else[style]' => array('show'),
                    ),
                    'options' => array(
                        'none' => __('None', 'mm_sow'),
                        'icon' => __('Icon', 'mm_sow'),
                        'icon_image' => __('Icon Image', 'mm_sow'),
                    ),
                ),

                'tabs' => array(
                    'type' => 'repeater',
                    'label' => __('Tabs', 'mm_sow'),
                    'item_name' => __('Single Tab', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='tabs-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Tab Title', 'mm_sow'),
                            'description' => __('The title for the tab shown as name for tab navigation.', 'mm_sow'),
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => __('Tab Image.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array('show'),
                                'icon_type[icon]' => array('hide'),
                                'icon_type[none]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Tab Icon.', 'mm_sow'),
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                                'icon_type[none]' => array('hide'),
                            ),
                        ),

                        'tab_content' => array(
                            'type' => 'tinymce',
                            'label' => __('Tab Content', 'mm_sow'),
                            'description' => __('The content of the tab.', 'mm_sow'),
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
                    'mm_sow-tabs',
                    plugin_dir_url(__FILE__) . 'js/' . MM_SOW_JS_PREFIX . 'tabs' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery')
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'mm_sow-tabs',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_less_variables($instance) {
        return array(
            'color' => $instance['color']
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'icon_type' => $instance['icon_type'],
            'mobile_width' => $instance['mobile_width'],
            'tabs' => !empty($instance['tabs']) ? $instance['tabs'] : array()
        );
    }

}

siteorigin_widget_register('mm_sow-tabs', __FILE__, 'MM_SOW_Tabs_Widget');