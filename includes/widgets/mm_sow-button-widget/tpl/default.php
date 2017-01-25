<?php
/**
 * @var $id
 * @var $style
 * @var $class
 * @var $color
 * @var $custom_color
 * @var $hover_color
 * @var $type
 * @var $rounded
 * @var $href
 * @var $align
 * @var $target
 * @var $text
 * @var $icon_type
 * @var $icon_image
 * @var $icon
 * @var $settings
 */

$icon_html = '';

$id = (!empty($id)) ? ' id="' . $id . '"' : '';

$class = (!empty($class)) ? ' ' . $class : '';

$color_class = ' mm_sow-' . esc_attr($color);
if (!empty($type))
    $type = ' mm_sow-' . esc_attr($type);

$rounded = (!empty($rounded)) ? ' mm_sow-rounded' : '';

if (!empty($target))
    $target = ' target="_blank"';
else
    $target = '';

if ($color == 'default' || ($color == 'custom' && empty($custom_color))) {
    
    $custom_color = '#f94213'; // default button color if none set in theme options

}

$style = ($style) ? ' style="' . esc_attr($style) . '"' : '';

// Use the custom color only if user wants to use the custom color set
$color_attr = ($color == 'custom') ? ' data-color=' . esc_html($custom_color) : '';

$hover_color_attr = ($hover_color) ? ' data-hover-color=' . esc_html($hover_color) : '';

if ($icon_type == 'icon_image')
    $icon_html = wp_get_attachment_image($icon_image, 'thumbnail', false, array('class' => 'mm_sow-image mm_sow-thumbnail'));
elseif ($icon_type == 'icon')
    $icon_html = siteorigin_widget_get_icon($icon);

$button_content = '<a' . $id . ' class= "mm_sow-button ' . ((!empty($icon_html)) ? ' mm_sow-with-icon' : '') . esc_attr($class) . $color_class . $type . $rounded . '"' . $style . $color_attr . $hover_color_attr . ' href="' . sow_esc_url($href) . '"' . esc_html($target) . '>' . $icon_html . esc_html($text) . '</a>';

if ($align != 'none')
    $button_content = '<div class="mm_sow-button-wrap" style="text-align:' . esc_attr($align) . ';float:' . esc_attr($align) . ';">' . $button_content . '</div>';

echo $button_content;