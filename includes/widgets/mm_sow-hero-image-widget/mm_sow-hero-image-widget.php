<?php

/*
Widget Name: Micemade Hero Header
Description: Display custom header content with option to set HTML5/YouTube video or parallax image background.
Author: Micemade
Author URI: http://micemade.com
*/

class MM_SOW_Hero_Image_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'mm_sow-hero-image',
            __('Micemade Hero Header', 'mm_sow'),
            array(
                'description' => __('Display a hero background with video or image background.', 'mm_sow'),
                'panels_icon' => 'mm-widgets-icon',
                'help' => MM_SOW_PLUGIN_HELP_URL. '#hero-header'
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
					'default'		=> 1,
					'description'	=> __('Hide title on frontend (make visible only in PB admin - easier to identify widgets)','mm_sow')
                ),
				
                'header_type' => array(
                    'type' => 'radio',
                    'label' => __('Header Type', 'mm_sow'),
                    'default' => 'standard',
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('header_type')
                    ),
                    'options' => array(
                        'standard' => __('Standard', 'mm_sow'),
                        'custom' => __('Custom', 'mm_sow'),
                    )
                ),

                'custom_header' => array(
                    'type' => 'section',
                    'label' => __('Custom Header', 'mm_sow'),
                    'state_handler' => array(
                        'header_type[custom]' => array('show'),
                        '_else[header_type]' => array('hide'),
                    ),
                    'fields' => array(
                        'custom' => array(
                            'type' => 'tinymce',
                            'label' => __('Custom text', 'mm_sow'),
                        ),

                        'custom_css' => array(
                            'type' => 'textarea',
                            'label' => __('Custom CSS for presentation of the Custom header elements. Will be embedded inline with the page.', 'mm_sow'),
                            'rows' => 20
                        ),
                    )
                ),


                'standard_header' => array(
                    'type' => 'section',
                    'label' => __('Standard Header', 'mm_sow'),
                    'state_handler' => array(
                        'header_type[standard]' => array('show'),
                        '_else[header_type]' => array('hide'),
                    ),
                    'fields' => array(
                        'heading' => array(
                            'type' => 'text',
                            'label' => __('Header text', 'mm_sow'),
                        ),

						'heading_size' => array(
							'type' => 'slider',
							'label' => __( 'Header custom text size', 'mm_sow' ),
							'default' => 0,
							'min' => -100,
							'max' => 100,
							'integer' => true
						),
						'heading_color' => array(
							'type' => 'color',
							'label' => __('Header custom font color', 'mm_sow'),
							'default' => '',
						),
                        'subheading' => array(
                            'type' => 'text',
                            'label' => __('Sub-heading text', 'mm_sow'),
                            'optional' => 'true',
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
                        'button_text' => array(
                            'type' => 'text',
                            'label' => __('Button text', 'mm_sow'),
                        ),

                        'button_url' => array(
                            'type' => 'link',
                            'label' => __('Button URL', 'mm_sow'),
                        ),

                        'new_window' => array(
                            'type' => 'checkbox',
                            'label' => __('Open URL in a new window', 'mm_sow'),
                        ),
                    )
                ),

                'scroll_to_row' => array(
                    'type' => 'text',
                    'label' => __('Scroll to row', 'mm_sow'),
                    'description' => __('Enter unique row idendifier ( set identifier in Row settings > Attributes > "Row unique identifier") to smooth scroll the page to that identified row.', 'mm_sow'),
                ),

                'background' => array(
                    'type' => 'section',
                    'label' => __('Background', 'mm_sow'),
                    'fields' => array(

                        'bg_type' => array(
                            'type' => 'radio',
                            'label' => __('Background Type', 'mm_sow'),
                            'default' => 'parallax',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('bg_type')
                            ),
                            'options' => array(
                                'cover' => __('Cover Image', 'mm_sow'),
                                'parallax' => __('Parallax Image', 'mm_sow'),
                                'youtube' => __('YouTube Video', 'mm_sow'),
                                'html5video' => __('HTML5 Video', 'mm_sow'),
                            )
                        ),

                        'youtube_video' => array(
                            'type' => 'section',
                            'label' => __('YouTube Background Video', 'mm_sow'),
                            'state_handler' => array(
                                'bg_type[youtube]' => array('show'),
                                '_else[bg_type]' => array('hide'),
                            ),
                            'fields' => array(

                                'youtube_url' => array(
                                    'type' => 'text',
                                    'sanitize' => 'url',
                                    'label' => __('YouTube URL', 'mm_sow'),
                                    'description' => __('An URL of the YouTube video that will act as background video for this section.', 'mm_sow'),
                                ),

                                'quality' => array(
                                    'type' => 'select',
                                    'label' => __('Choose the YouTube video quality', 'mm_sow'),
                                    'default' => 'highres',
                                    'options' => array(
                                        'highres' => __('High Resolution', 'mm_sow'),
                                        'default' => __('Default', 'mm_sow'),
                                        'small' => __('Small', 'mm_sow'),
                                        'medium' => __('Medium', 'mm_sow'),
                                        'large' => __('Large', 'mm_sow'),
                                        'hd720' => __('HD 720p', 'mm_sow'),
                                        'hd1080' => __('HD 1080p', 'mm_sow'),
                                    )
                                ),

                                'ratio' => array(
                                    'type' => 'select',
                                    'label' => __('Aspect ratio of the YouTube video', 'mm_sow'),
                                    'default' => '16/9',
                                    'options' => array(
                                        '16/9' => __('16/9', 'mm_sow'),
                                        'auto' => __('Auto', 'mm_sow'),
                                        '4/3' => __('4/3', 'mm_sow'),
                                    )
                                ),

                            ),
                        ),

                        'html5_videos' => array(
                            'type' => 'section',
                            'label' => __('HTML5 Background videos', 'mm_sow'),
                            'state_handler' => array(
                                'bg_type[html5video]' => array('show'),
                                '_else[bg_type]' => array('hide'),
                            ),
                            'fields' => array(

                                'mp4_file' => array(
                                    'type' => 'media',
                                    'library' => 'video',
                                    'label' => __('MP4 Video file', 'mm_sow'),
                                ),
                                'webm_file' => array(
                                    'type' => 'media',
                                    'library' => 'video',
                                    'label' => __('WebM Video file', 'mm_sow'),
                                ),
                                'ogg_file' => array(
                                    'type' => 'media',
                                    'library' => 'video',
                                    'label' => __('Ogg Video file', 'mm_sow'),
                                ),

                            ),
                        ),

                        'bg_image' => array(
                            'type' => 'section',
                            'label' => __('Background Image', 'mm_sow'),
                            'fields' => array(

                                'image' => array(
                                    'type' => 'media',
                                    'label' => __('Background Image', 'mm_sow'),
                                    'description' => __('This background image will be used as a placeholder image if YouTube or HTML5 video background option is chosen.', 'mm_sow'),
                                    'library' => 'image',
                                    'fallback' => true,
                                ),
                            ),
                        ),

                        'overlay' => array(
                            'type' => 'section',
                            'label' => __('Background Overlay', 'mm_sow'),
                            'fields' => array(

                                'overlay_color' => array(
                                    'type' => 'color',
                                    'label' => __('Overlay color', 'mm_sow'),
                                    'default' => '#333333',
                                ),

                                'overlay_opacity' => array(
                                    'label' => __('Overlay opacity', 'mm_sow'),
                                    'type' => 'slider',
                                    'min' => 0,
                                    'max' => 100,
                                    'default' => 30,
                                ),

                            ),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'mm_sow'),
                    'fields' => array(

                        'top_padding' => array(
                            'type' => 'number',
                            'label' => __('Top padding', 'mm_sow'),
                            'default' => 100,
                        ),

                        'bottom_padding' => array(
                            'type' => 'number',
                            'label' => __('Bottom padding', 'mm_sow'),
                            'default' => 100,
                        ),


                        'responsive' => array(
                            'type' => 'section',
                            'label' => __('Responsive', 'mm_sow'),
                            'hide' => true,
                            'fields' => array(
                                'tablet' => array(
                                    'type' => 'section',
                                    'label' => __('Tablet', 'mm_sow'),
                                    'fields' => array(
                                        'top_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Top padding', 'mm_sow'),
                                            'default' => 80,
                                        ),

                                        'bottom_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Bottom padding', 'mm_sow'),
                                            'default' => 80,
                                        ),

                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'mm_sow'),
                                            'description' => __('The resolution to treat as a tablet resolution.', 'mm_sow'),
                                            'default' => 800,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                ),
                                'mobile' => array(
                                    'type' => 'section',
                                    'label' => __('Mobile Phone', 'mm_sow'),
                                    'fields' => array(
                                        'top_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Top padding', 'mm_sow'),
                                            'default' => 50,
                                        ),

                                        'bottom_padding' => array(
                                            'type' => 'number',
                                            'label' => __('Bottom padding', 'mm_sow'),
                                            'default' => 50,
                                        ),

                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'mm_sow'),
                                            'description' => __('The resolution to treat as a mobile resolution.', 'mm_sow'),
                                            'default' => 400,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                )

                            )
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
                    'mm_sow-ytp',
                    MM_SOW_PLUGIN_URL . 'assets/js/'. MM_SOW_JS_PREFIX .'jquery.mb.YTPlayer' . MM_SOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    MM_SOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(array(
            array(
                'mm_sow-hero-image',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));


        add_action('wp_enqueue_scripts', array($this, 'init_custom_css'), 15); // load as late as possible

    }

    function init_custom_css() {

        if (!is_active_widget(false, false, $this->id_base)) {
            return;
        }

        $custom_css = '';

        $instances = $this->get_settings();

        if (array_key_exists($this->number, $instances)) {
            $instance = $instances[$this->number];
            if (!empty($instance) && isset( $instance['header_type'] )) {
                $header_type = $instance['header_type'];
                if ($header_type == 'custom')
                    $custom_css = $instance['custom_header']['custom_css'];
            }
        }

        if ($custom_css <> '') {
            $custom_css = $custom_css . "\n";
            wp_add_inline_style('mm_sow-hero-image', $custom_css); // after custom.css file
        }

    }


    function get_less_variables($instance) {
        
		if( ! isset( $instance['settings'] ) ) return;
		
		return array(
            'top_padding' => intval($instance['settings']['top_padding']) . 'px',
            'bottom_padding' => intval($instance['settings']['bottom_padding']) . 'px',

            'tablet_width' => intval($instance['settings']['responsive']['tablet']['width']) . 'px',
            'mobile_width' => intval($instance['settings']['responsive']['mobile']['width']) . 'px',

            'tablet_top_padding' => intval($instance['settings']['responsive']['tablet']['top_padding']) . 'px',
            'tablet_bottom_padding' => intval($instance['settings']['responsive']['tablet']['bottom_padding']) . 'px',

            'mobile_top_padding' => intval($instance['settings']['responsive']['mobile']['top_padding']) . 'px',
            'mobile_bottom_padding' => intval($instance['settings']['responsive']['mobile']['bottom_padding']) . 'px',
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'header_type'		=> $instance['header_type'],
            'custom_header'		=> $instance['custom_header'],
            'standard_header'	=> $instance['standard_header'],
            'scroll_to_row'		=> $instance['scroll_to_row'],
            'background'		=> $instance['background'],
            'settings'			=> $instance['settings']
        );
    }

}

siteorigin_widget_register('mm_sow-hero-image', __FILE__, 'MM_SOW_Hero_Image_Widget');