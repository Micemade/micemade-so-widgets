<?php
/**
 * @var $settings
 * @var $style
 * @var $wc_cats
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = mm_sow_get_column_class( intval($settings['per_line'] ) ); ?>

<div class="mm_sow-wc-cats mm_sow-<?php echo $style; ?> mm_sow-container">

    <?php foreach ( $wc_cats as $wc_cat ) { ?>

       <?php 
	   $term_obj	= get_term_by( 'slug', $wc_cat['term'], 'product_cat' );
		if( is_wp_error($term_obj) ) continue;
	   $term_id		= $term_obj->term_id;
	   ?>


	   <?php $image_type = esc_html($wc_cat['image_type']); ?>

        <div class="mm_sow-wc-cat-wrapper <?php echo $column_style; ?> mm_sow-zero-margin">

            <div class="mm_sow-wc-cat">
				
				<div class="mm_sow-wc-cat-image">
				
					<?php
					// Get term name, link and WC term meta for thumbnail
					
					$term_title		= $term_obj->name;
					$term_link		= get_term_link( $term_obj->slug, 'product_cat' );
					$meta			= get_term_meta( $term_id );
					$thumbnail_id	= $meta['thumbnail_id'][0];
					//$thumbnail_id	= get_woocommerce_term_meta( $term_obj->term_id, 'thumbnail_id' );
					
					// Override WC category image with custom
					if( $wc_cat['custom_image'] ) {
						$thumbnail_id = $wc_cat['custom_image'];
					}
					elseif( $thumbnail_id ) {
						$image_atts = wp_get_attachment_image_src( $thumbnail_id, 'full');
						$image_url	= $image_atts[0];
					}
					?>
					
					<?php if ( $style == "style1" ) { ?>
					<div class="mm_sow-wc-cat-text <?php echo ( $image_type == 'none' || !$thumbnail_id ) ? 'no-image' : ''?>">
						<div class="mm_sow-title-wrap ">
						
							<h3 class="mm_sow-title"><a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html( $term_title ); ?></a></h3>
							
							<?php echo mm_sow_wc_product_count( $term_id ); ?>
						
						</div>
					</div>
					<?php } ?>
					
					<?php if ( $image_type == 'image' && $thumbnail_id ) { ?>

						<div class="mm_sow-image-wrapper" style="background-image:url( <?php echo esc_url($image_url)?>);"></div>

					<?php }elseif( $image_type == 'icon' ) { ?>

						<div class="mm_sow-icon-wrapper">

							<?php echo siteorigin_widget_get_icon($wc_cat['icon']); ?>

						</div>

					<?php } ?>
					
					<div class="mm_sow-image-overlay"></div>

				</div>
				
				<?php if( $style != "style1" ) { ?>
				<div class="mm_sow-wc-cat-text <?php echo ( $image_type == 'none' || !$thumbnail_id ) ? 'no-image' : ''?>">

					<div class="mm_sow-title-wrap">
					
						<h3 class="mm_sow-title"><a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html( $term_title ); ?></a></h3>
						
						<?php echo mm_sow_wc_product_count( $term_id ); ?>
					
					</div>

				</div>
				<?php } ?>
			
			</div>
			
			<?php if( $wc_cat['excerpt']) { ?>
			
				<div class="mm_sow-wc-cat-details"><?php echo wp_kses_post( $wc_cat['excerpt'] ) ?></div>
			
			<?php } ?>
			
        </div>

    <?php

    }

    ?>

</div>