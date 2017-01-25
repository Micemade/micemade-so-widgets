<?php
/**
 * @var $piecharts
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = mm_sow_get_column_class(intval($settings['per_line'])); ?>

<?php

$bar_color = ' data-bar-color="' . esc_attr($settings['bar_color']) . '"';
$track_color = ' data-track-color="' . esc_attr($settings['track_color']) . '"';

?>

<div class="mm_sow-piecharts mm_sow-container">

    <?php foreach ($piecharts as $piechart): ?>

        <div class="mm_sow-piechart <?php echo $column_style; ?>">

            <div class="mm_sow-percentage" <?php echo $bar_color; ?> <?php echo $track_color; ?>
                 data-percent="<?php echo intval($piechart['percentage']); ?>">

                <span><?php echo intval($piechart['percentage']); ?><sup>%</sup></span>

            </div>

            <div class="mm_sow-label"><?php echo esc_html($piechart['stats_title']); ?></div>

        </div>

    <?php

    endforeach;

    ?>

</div>