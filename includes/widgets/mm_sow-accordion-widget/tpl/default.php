<?php
/**
 * @var $accordion
 * @var $toggle
 * @var $style
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="mm_sow-accordion <?php echo $style; ?>" data-toggle="<?php echo ($toggle ? "true" : "false"); ?>">

    <?php foreach ($accordion as $panel) : ?>

        <div class="mm_sow-panel">

            <div class="mm_sow-panel-title"><?php echo esc_html($panel['title']); ?></div>

            <div class="mm_sow-panel-content"><?php echo do_shortcode($panel['panel_content']); ?></div>

        </div>

        <?php

    endforeach;

    ?>

</div>