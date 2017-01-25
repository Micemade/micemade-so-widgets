<?php
/**
 * @var $odometers
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = mm_sow_get_column_class(intval($settings['per_line'])); ?>

<div class="mm_sow-odometers mm_sow-container <?php echo esc_attr( $settings['numbers_size']); ?>">

    <?php foreach ($odometers as $odometer): ?>

        <?php

        $prefix = (!empty ($odometer['prefix'])) ? '<span class="prefix">' . $odometer['prefix'] . '</span>' : '';
        $suffix = (!empty ($odometer['suffix'])) ? '<span class="suffix">' . $odometer['suffix'] . '</span>' : '';

        ?>

        <div class="mm_sow-odometer <?php echo $column_style; ?>">

            <div class="mm_sow-odometer-wrap">

			   <?php echo (!empty ($odometer['prefix'])) ? '<span class="mm_sow-prefix">' . $odometer['prefix'] . '</span>' : ''; ?>

				<div class="mm_sow-number odometer" data-stop="<?php echo intval($odometer['stop_value']); ?>">

					<?php echo intval($odometer['start_value']); ?>

				</div>

				<?php echo (!empty ($odometer['suffix'])) ? '<span class="mm_sow-suffix">' . $odometer['suffix'] . '</span>' : ''; ?>

            </div>
			
			<?php $icon_type = esc_html($odometer['icon_type']); ?>

            <?php if ($icon_type == 'icon_image') : ?>

                <?php $icon_html = '<span class="mm_sow-image-wrapper">' . wp_get_attachment_image($odometer['icon_image'], 'full', false, array('class' => 'mm_sow-image full')) . '</span>'; ?>

            <?php else : ?>

                <?php $icon_html = '<span class="mm_sow-title-icon">' . siteorigin_widget_get_icon($odometer['icon']) . '</span>'; ?>

            <?php endif; ?>

            <div class="mm_sow-stats-title-wrap">

                <div class="mm_sow-stats-title"><?php echo $icon_html . '<span class="mm_sow-title-text">' .esc_html( $odometer['stats_title'] ) .'</span>'; ?></div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>