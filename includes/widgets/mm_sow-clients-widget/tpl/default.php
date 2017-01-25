<?php
/**
 * @var $clients
 * @var $settings
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $num_of_columns = intval($settings['per_line']); ?>

<?php $column_style = mm_sow_get_column_class($num_of_columns); ?>

<div class="mm_sow-clients mm_sow-container">

    <?php $column_count = 0; ?>

    <?php foreach ($clients as $client): ?>

        <div class="mm_sow-client <?php echo $column_style; ?> mm_sow-zero-margin">

            <?php echo wp_get_attachment_image($client['image'], 'full', false, array('class' => 'mm_sow-image full', 'alt' => $client['name'])); ?>

            <div class="mm_sow-client-name">

                <?php if (!empty($client['link'])): ?>

                    <a href="<?php echo sow_esc_url($client['link']); ?>" title="<?php echo esc_html($client['name']); ?>" target="_blank"><?php echo esc_html($client['name']); ?></a>

                <?php else: ?>

                    <?php echo esc_html($client['name']); ?>

                <?php endif; ?>

            </div>

            <div class="mm_sow-image-overlay"></div>

        </div>

    <?php

    endforeach;

    ?>

</div>