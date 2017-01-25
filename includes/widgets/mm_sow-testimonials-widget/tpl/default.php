<?php
/**
 * @var $settings
 * @var $testimonials
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = mm_sow_get_column_class(intval($settings['per_line'])); ?>

<div class="mm_sow-testimonials mm_sow-container">

    <?php foreach ($testimonials as $testimonial) : ?>

        <div class="mm_sow-testimonial <?php echo $column_style; ?>">

            <div class="mm_sow-testimonial-text">
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

    <?php

    endforeach;

    ?>

</div>