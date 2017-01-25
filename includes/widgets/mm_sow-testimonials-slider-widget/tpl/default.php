<?php
/**
 * @var $settings
 * @var $testimonials
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="mm_sow-testimonials-wrapper">

<div class="mm_sow-testimonials-slider mm_sow-container" <?php foreach ($settings as $key => $val) : ?>
    <?php if (!empty($val)) : ?>
        data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
    <?php endif ?>
<?php endforeach; ?>>

        <?php foreach ($testimonials as $testimonial) : ?>

            <div class="mm_sow-slide mm_sow-testimonial-wrapper">

                <div class="mm_sow-testimonial">

                    <div class="mm_sow-testimonial-text">

                        <i class="fa fa-quote-right" aria-hidden="true"></i>

                        <?php echo wp_kses_post($testimonial['text']) ?>

                    </div>

                    <div class="mm_sow-testimonial-user">

                        <div class="mm_sow-image-wrapper">
                            <?php echo wp_get_attachment_image($testimonial['image'], 'thumbnail', false, array('class' => 'mm_sow-image full')); ?>
                        </div>

                        <div class="mm_sow-text">
                            <h4 class="mm_sow-author-name"><?php echo esc_html($testimonial['name']) ?></h4>
                            <div class="mm_sow-author-credentials"><?php echo wp_kses_post($testimonial['credentials']); ?></div>
                        </div>

                    </div>

                </div>

            </div>

        <?php

        endforeach;

        ?>

</div>
	
</div>