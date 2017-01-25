<?php
/**
 * @var $style
 * @var $settings
 * @var $team_members
 */

?>

<?php if( !empty( $instance['title'] ) && !$instance['hide_title'] ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title']; ?>


<?php $column_style = ''; ?>

<?php if ( $style == 'style1' || $style == 'style3' ) { ?>

    <?php $column_style = mm_sow_get_column_class( intval($settings['per_line'] ) ); ?>

<?php } ?>

<div class="mm_sow-team-members mm_sow-<?php echo $style; ?> mm_sow-container">

    <?php foreach ($team_members as $team_member): ?>

        <div class="mm_sow-team-member-wrapper <?php echo $column_style; ?>">

            <div class="mm_sow-team-member">

                <div class="mm_sow-image-wrapper">
					
					<div class="content">
					
						<?php echo wp_get_attachment_image( $team_member['image'], $settings['img_format'], false, array('class' => 'mm_sow-image full')); ?>

						<?php if ( $style == 'style1' ) { ?>

							<?php include 'social-profile.php'; ?>

						<?php } ?>
					
					</div>

                </div>

                <div class="mm_sow-team-member-text">

                    <h3 class="mm_sow-title"><?php echo esc_html( $team_member['name'] ) ?></h3>

                    <div class="mm_sow-team-member-position">

                        <?php echo esc_html($team_member['position']) ?>

                    </div>

                    <div class="mm_sow-team-member-details">

                        <?php echo wp_kses_post($team_member['details']) ?>

                    </div>

                    <?php if ($style == 'style2' || $style == 'style3' ) { ?>

                        <?php include 'social-profile.php'; ?>

                    <?php } ?>

                </div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>