<?php
/**
 * @var $style
 * @var $wc_cats
 * @var $settings
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = mm_sow_get_column_class( intval($settings['per_line'] ) ); ?>

<div class="mm_sow-wc-cats mm_sow-<?php echo $style; ?> mm_sow-container">

    <?php echo ( $style == "style4" ) ? '<ul class="product_cat-list">' : ''; ?>

    <?php
    
	foreach ( $wc_cats as $wc_cat ) { ?>

        <?php
        $term_obj	= get_term_by( 'slug', $wc_cat['term'], 'product_cat' );
        if( is_wp_error($term_obj) ) continue;
        // Get term ID, name, link and WC term meta for thumbnail
        $term_id		= $term_obj->term_id;
        $term_title     = $term_obj->name;
        $term_link      = get_term_link( $term_obj->slug, 'product_cat' );
        $meta			= get_term_meta( $term_id );
        $thumbnail_id	= $meta['thumbnail_id'][0];
        
		// Additionals:
        $featured   = $wc_cat['featured'];
        $add_args   = $wc_cat['additional_args'];

        $missing_image_of_icon = false;
		
		if( $image_type == 'image' ) {
            // Override WC category image with custom
			if( $wc_cat['custom_image'] ) {
                $thumbnail_id = $wc_cat['custom_image'];
            }

            $img_format = ( $style == "style4" ) ? "shop_thumbnail" : $img_format;
            $image_atts = wp_get_attachment_image_src( $thumbnail_id, $img_format );
            $image_url	= $image_atts[0];
			
			$missing_image_of_icon = !$thumbnail_id ? true : false;
			
        }elseif( $image_type == 'icon' ) {
			
			$missing_image_of_icon = !$wc_cat['icon'] ? true : false;
		}
		
		// If there's no image or icon set
		$no_image = ($image_type == 'none' || $missing_image_of_icon) ? true : false;
        ?>

        <?php if( $style == "style4" ) { // simple list with title and link ?>

        <li>
            <a href="<?php echo esc_url($term_link) . ( $add_args ? esc_url($add_args) : '' ); ?>">
            <?php if ( $image_type == 'image' && $thumbnail_id ) {
                
				echo '<img src="'. esc_url( $image_url ) .'" alt="'. esc_html( $term_title ) .'">';
            
			}elseif( $image_type == 'icon' ) { ?>

                <div class="mm_sow-icon-wrapper">
					<?php echo siteorigin_widget_get_icon($wc_cat['icon']); ?>
                </div>
				
            <?php } ?>

                <p class="product_cat-title">
                    <?php echo ( $featured ? '<strong>' : '' ); ?>
                    <?php echo esc_html( $term_title ); ?>
                    <?php echo ( $featured ? '</strong>' : '' ); ?>
                </p>
				
            </a>
						
        </li>

      <?php }elseif( $style !== "style5" ){ ?>

        <div class="mm_sow-wc-cat-wrapper <?php echo $column_style; ?> mm_sow-zero-margin">

            <div class="mm_sow-wc-cat">

				<div class="mm_sow-wc-cat-image">


					<?php if ( $style == "style1" ) { ?>
					<div class="mm_sow-wc-cat-text <?php echo ( $no_image ) ? 'no-image' : ''?>">
						<div class="mm_sow-title-wrap ">

							<h3 class="mm_sow-title">
                                <a href="<?php echo esc_url($term_link) . ( $add_args ? esc_url($add_args) : '' ); ?>">
                                    <?php echo ( $featured ? '<strong>' : '' ); ?>
                                        <?php echo esc_html( $term_title ); ?>
                                    <?php echo ( $featured ? '</strong>' : '' ); ?>
                                </a>
                            </h3>

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
				<div class="mm_sow-wc-cat-text <?php echo ( $no_image) ? 'no-image' : ''?>">

					<div class="mm_sow-title-wrap">

						<h3 class="mm_sow-title">
                            <a href="<?php echo esc_url($term_link) . ( $add_args ? esc_url($add_args) : '' ); ?>">
                                <?php echo ( $featured ? '<strong>' : '' ); ?>
                                <?php echo esc_html( $term_title ); ?>
                                <?php echo ( $featured ? '</strong>' : '' ); ?>
                            </a>
                        </h3>

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

      } // end if

    } // end foreach

    ?>

    <?php echo ( $style == "style4" ) ? '</ul>' : ''; ?>
	
	<?php 
	// Style 5 - List all product categories:
	if( $style == "style5" ) { ?>
	
		<?php 
		
		$wlc_args = array(
			'hide_empty'		=> false,
			'hierarchical'		=> true,
			'order_by'			=> 'menu_order ID',
			'order'				=> 'ASC',
			'taxonomy'			=> 'product_cat',
			'title_li'			=> '',
			'show_option_none'	=> '<p class="no_prod_cats">'. esc_html__('No product categories exist', 'mm_sow') .'.</p>',
		);
		
		
		echo '<ul class="product_cat-list">';
			wp_list_categories( apply_filters( 'mm_sow_woocommerce_product_categories_args', $wlc_args ) );
		echo '</ul>';
		?>

	
	<?php } ?>

</div>
