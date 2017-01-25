<?php

/*
Widget Name: Micemade Team Members
Description: Display a list of your team members optionally in a multi-column grid.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Team_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-team-members',
            __('Micemade Team Members', 'mm_sow'),
            array(
                'description' => __('Create team members to display in a column grid.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#team-members'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'mm_sow'),
                ),

				'hide_title' => array(
                    'type'			=> 'checkbox',
                    'label'			=> __('Hide title', 'mm_sow'),
					'default'		=> 0,
					'description'	=> __('Hide title on frontend (make visible only in PB admin - easier to identify widgets)','mm_sow')
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

                'team-members' => array(
                    'type' => 'repeater',
                    'label' => __('Team Members', 'mm_sow'),
                    'item_name' => __('Team Member', 'mm_sow'),
                    'item_label' => array(
                        'selector' => "[id*='team-members-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'mm_sow'),
                            'description' => __('Name of the team member.', 'mm_sow'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Team member image.', 'mm_sow'),
                        ),

						
                        'position' => array(
                            'type' => 'text',
                            'label' => __('Position', 'mm_sow'),
                            'description' => __('Specify the position/title of the team member.', 'mm_sow'),
                        ),

                        'details' => array(
                            'type' => 'textarea',
                            'label' => __('Short details', 'mm_sow'),
                            'description' => __('Provide a short writeup for the team member', 'mm_sow'),
                        ),


                        'social_profile' => array(
                            'type' => 'section',
                            'label' => __('Social profile', 'mm_sow'),
                            'fields' => array(
                                'email_address' => array(
                                    'type' => 'text',
                                    'label' => __('Email Address', 'mm_sow'),
                                    'description' => __('Enter the email address of the team member.', 'mm_sow'),
                                ),

                                'facebook' => array(
                                    'type' => 'text',
                                    'label' => __('Facebook Page URL', 'mm_sow'),
                                    'description' => __('URL of the Facebook page of the team member.', 'mm_sow'),
                                ),

                                'twitter' => array(
                                    'type' => 'text',
                                    'label' => __('Twitter Profile URL', 'mm_sow'),
                                    'description' => __('URL of the Twitter page of the team member.', 'mm_sow'),
                                ),

                                'linkedin' => array(
                                    'type' => 'text',
                                    'label' => __('LinkedIn Page URL', 'mm_sow'),
                                    'description' => __('URL of the LinkedIn profile of the team member.', 'mm_sow'),
                                ),

                                'pinterest' => array(
                                    'type' => 'text',
                                    'label' => __('Pinterest Page URL', 'mm_sow'),
                                    'description' => __('URL of the Pinterest page for the team member.', 'mm_sow'),
                                ),

                                'dribbble' => array(
                                    'type' => 'text',
                                    'label' => __('Dribbble Profile URL', 'mm_sow'),
                                    'description' => __('URL of the Dribbble profile of the team member.', 'mm_sow'),
                                ),

                                'google_plus' => array(
                                    'type' => 'text',
                                    'label' => __('GooglePlus Page URL', 'mm_sow'),
                                    'description' => __('URL of the Google Plus page of the team member.', 'mm_sow'),
                                ),

                                'instagram' => array(
                                    'type' => 'text',
                                    'label' => __('Instagram Page URL', 'mm_sow'),
                                    'description' => __('URL of the Instagram feed for the team member.', 'mm_sow'),
                                ),

                            )
                        ),

                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'mm_sow'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3,
							'state_handler' => array(
								'style[style1]' => array('show'),
								'style[style2]' => array('hide'),
								'style[style3]' => array('show'),
							),
                        ),
						'img_format' => array(
                            'type' => 'select',
                            'label' => __('Choose post image format', 'mm_sow'),
                            'default' => 'thumbnail',
                            'options' => apply_filters("mm_sow_image_sizes","")
                        ),
                    )
                ), // section "settings"
				
				
            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'mm_sow-team-members',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_style_name($instance) {
        if ($instance['style'] == 'style2')
            return false; // no stylesheet required for style 2 template
        return $instance['style'];
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'team_members' => !empty($instance['team-members']) ? $instance['team-members'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-team-members', __FILE__, 'MM_SOW_Team_Widget');