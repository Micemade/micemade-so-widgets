<?php
/**
 * @var $icon_type
 * @var $icon_list
 * @var $settings
 */

if (!empty($settings['target']))
    $target = '_blank';
else
    $target = '_self';

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="mm_sow-icon-list mm_sow-align<?php echo esc_attr( $settings['align'] .' '. $settings['orientation'] ); ?>">

    <?php foreach ($icon_list as $icon_item): ?>

        <?php $icon_type = esc_html($icon_type); ?>

        <?php $icon_title = esc_html($icon_item['title']); ?>

        <?php $icon_url = sow_esc_url($icon_item['href']); ?>

        <div class="mm_sow-icon-list-item" title="<?php echo esc_attr( $icon_title ); ?>">

            
			<?php echo ( $icon_url ? ( '<a href="'. esc_url( $icon_url ) .'" target="'. esc_attr( $target ) .'">' ) : '') ; ?>
			
			
				<?php if ($icon_type == 'icon_image') { ?>

						<div class="mm_sow-image-wrapper">

							<?php echo wp_get_attachment_image( $icon_item['icon_image'], 'full', false, array('class' => 'mm_sow-image full', 'alt' => $icon_title)); ?>

						</div>


				<?php }else{ ?>


						<div class="mm_sow-icon-wrapper">

							<?php echo siteorigin_widget_get_icon( $icon_item['icon'] ); ?>

						</div>


				<?php } // end if else $icon_type == 'icon_image' ?>
				
				
				<?php if( $icon_title ) { ?>
				
				<span class="icon-title"><?php echo esc_html( $icon_title ); ?></span>
				
				<?php } ?>
				

			<?php echo ( $icon_url ? '</a>' : '');  ?>
			
        </div>

        <?php

    endforeach;

    ?>

</div>