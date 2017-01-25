<?php
/**
 * Add to wishlist button template
 *
 * @author Micemade / Your Inspiration Themes
 * @package Micemade SO Widgets  / YITH WooCommerce Wishlist
 * @version 1.0.0 - Micemade SO Widgets
 * @version 2.0.8 - YITH WooCommerce Wishlist
 */

global $product ;
$icon 		= '<span class="fa fa-heart-o"></span>';
$classes	= 'add_to_wishlist';
$title_add	= __('Add to wishlist','mm_sow');
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->id ) ); ?>" data-product-id="<?php esc_attr_e($product->id); ?>" data-product-type="<?php esc_attr_e($product->product_type); ?>" class="<?php esc_attr_e($classes); ?>" title="<?php echo esc_attr($title_add); ?>">
    <?php echo wp_kses_post($icon); ?> 
    <?php //echo wp_kses_post($label) ?>
</a>

<i class="fa fa-spinner ajax-loading" aria-hidden="true" style="visibility:hidden"></i>