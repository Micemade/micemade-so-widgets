<?php
/**
 * @var $settings
 * @var $style
 * @var $services
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php
$column_style	= mm_sow_get_column_class( intval($settings['per_line']) ); 
$title_tag		= isset( $settings['title_tag'] ) ? $settings['title_tag'] : 'h3';
?>

<div class="mm_sow-services mm_sow-<?php echo $style; ?> mm_sow-container">

    <?php foreach ($services as $service): ?>

        <?php 
		$icon_type	= esc_html( $service['icon_type'] );
		$url		= $service['url'];
		
		?>

        <div class="mm_sow-service-wrapper <?php echo $column_style; ?>">
			
			<<?php echo ( $url ? ('a href="'. esc_url($url) .'"') : 'div' ); ?> class="mm_sow-service">

                <?php if ( $icon_type == 'icon_image' && isset($service['icon_image']) ) { ?>

                    <div class="mm_sow-image-wrapper">

                        <?php echo wp_get_attachment_image($service['icon_image'], 'full', false, array('class' => 'mm_sow-image full')); ?>

                    </div>

                <?php }elseif( $icon_type == 'icon' && !empty($service['icon']) ) { ?>

                    <div class="mm_sow-icon-wrapper">

                        <?php echo siteorigin_widget_get_icon($service['icon']); ?>

                    </div>

                <?php } //endif ?>

                <div class="mm_sow-service-text">

                    <<?php echo esc_attr($title_tag); ?> class="mm_sow-title">
						<span><?php echo wp_kses_post($service['heading']) ?></span>
					</<?php echo esc_attr($title_tag); ?>>

                    <div class="mm_sow-service-details"><?php echo wp_kses_post($service['excerpt']) ?></div>

                </div>

            </<?php echo ( $url ? 'a' : 'div' ); ?>>

        </div>

    <?php

    endforeach;

    ?>

</div>