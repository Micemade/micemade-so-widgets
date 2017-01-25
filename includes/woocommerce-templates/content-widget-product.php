<?php
/**
 * The template for displaying product widget entries
 *
 * This template overrides WooCommerce template from plugins/woocommerce/templates/content-widget-product.php.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes / Micemade
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<li>
	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		
		<!--<span class="product-image"><?php //echo $product->get_image('thumbnail'); ?></span> -->
		<div class="product-image">
			<?php 
			$thumbnail_exists = has_post_thumbnail();
			if ( $thumbnail_exists ) {
				
				the_post_thumbnail( 'thumbnail' );
			
			}else{
			
				echo '<img src="'. esc_url( apply_filters('mm_sow_placholder_image','') ).'" class="placeholder-image" alt="'. esc_attr__( 'No image','mm_sow' ).'">';
			
			}?>
		
		</div>
		
		<div class="product-info">
		
			<h5 class="product-title"><?php echo $product->get_title(); ?></h5>
		
			<?php if ( ! empty( $show_rating ) ) { ?>
				<?php echo $product->get_rating_html(); ?>
			<?php } ?>
			
			<span class="price">
				<?php echo $product->get_price_html(); ?>
			</span>
			
		</div>
	
	</a>
	
</li>
