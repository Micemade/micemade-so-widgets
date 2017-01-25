<?php
/**
 * @var $stats_bars
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="mm_sow-stats-bars">

    <?php foreach ($stats_bars as $stats_bar) :

        $color_style = '';
        $color = $stats_bar['color'];
        if ($color)
            $color_style = ' style="background:' . esc_attr($color) . ';"';

        ?>

        <div class="mm_sow-stats-bar">

            <div class="mm_sow-stats-title">
                <?php echo esc_html($stats_bar['title']) ?><span><?php echo esc_attr($stats_bar['value']); ?>%</span>
            </div>

            <div class="mm_sow-stats-bar-wrap">

                <div <?php echo $color_style; ?> class="mm_sow-stats-bar-content"
                                                 data-perc="<?php echo esc_attr($stats_bar['value']); ?>"></div>

                <div class="mm_sow-stats-bar-bg"></div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>