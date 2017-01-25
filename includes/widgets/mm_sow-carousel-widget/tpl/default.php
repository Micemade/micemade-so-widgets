<?php
/**
 * @var $carousel_settings
 * @var $settings
 * @var $elements
 */

if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

// Loop through the elements and do something with them.

if (!empty($elements)) : ?>

    <div class="mm_sow-carousel mm_sow-container" <?php foreach ($carousel_settings as $key => $val) { ?>

        <?php if (!empty($val)) { ?>
            data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
		<?php } ?>

    <?php } ?>>

        <?php foreach ($elements as $element) { ?>
			
			<div class="mm_sow-carousel-item">
			
				<?php if( $element['back_image'] ) { ?>
            
					<?php 
					$img_atts	= wp_get_attachment_image_src( $element['back_image'], 'full' );
					$img_url	= $img_atts[0];
					?>
					
					<div class="back_image" style="background-image: url( <?php echo esc_url($img_url);?> );"></div>
		
				<?php } ?>

                <?php echo ( $element['text'] ? ('<div class="editor-content ">' . do_shortcode( wp_kses_post($element['text']) ) .'</div>') : '' ); ?>

            </div><!--.mm_sow-carousel-item -->

        <?php } ?>

    </div> <!-- .mm_sow-carousel -->

<?php endif; ?>