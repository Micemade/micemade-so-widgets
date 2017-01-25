<?php
/**
 *	QUICK VIEW - Products popup
 *
 */
add_action( 'wp_ajax_nopriv_load-quick-view', 'mm_sow_quick_view' );// for NOT logged in users
add_action( 'wp_ajax_load-quick-view', 'mm_sow_quick_view' );// for logged in users

function mm_sow_quick_view () {

	global $post;
	
	$productID		= $_POST[ 'productID' ];
	$lang 			= isset($_POST[ 'lang' ]) ? $_POST[ 'lang' ] : '';
	$qv_img_format 	= isset($_POST[ 'qv_img_format' ]) ? $_POST[ 'qv_img_format' ] : 'thumbnail';
		
	$prodID = $lang ? icl_object_id( $productID, 'product', false, $lang ) : $productID;
	
	$display_args = array(
			'no_found_rows'		=> 1,
			'post_status'		=> 'publish',
			'post_type'			=> 'product',
			'post_parent'		=> 0,
			'suppress_filters'	=> false,
			'numberposts'		=> 1,
			'include'			=> $prodID
		);
			
	$content = get_posts($display_args);
	
	ob_start ();
	
	foreach ( $content as $post ) {
			
		setup_postdata( $post );
	
		global $post, $product, $woocommerce, $wp_query;
		
		$postClassarr	= get_post_class();
		$postClassarr[] = "mm_sow-qv-wrapper";
		$postClass = implode(" ", $postClassarr );
		
		echo '<div itemscope itemtype="http://schema.org/Product" id="product-'. esc_attr($productID) .'" class="'. esc_attr($postClass) .' product">';
			
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		// do_action( 'woocommerce_before_single_product_summary' ); // discarded
		
		do_action( 'mm_sow_quick_view_images', $qv_img_format );
	

		echo '<div class="summary entry-summary">';
		
		echo '<div class="inner-wrap">';
		
		echo '<h4><a href="' . esc_attr(get_permalink()) . '" title="'. the_title_attribute(array('echo' => 0)).'"><span>' . wp_kses_post(get_the_title()) .'</span></a></h4>';
		
		/**
		 * woocommerce_single_product_summary hook
		 *
		 * @hooked woocommerce_template_single_title - 5 // REMOVED
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50// REMOVED
		 */
		 
		// REMOVE SOME ACTIONS
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		
		do_action( 'woocommerce_single_product_summary' );
		
		echo '</div>'; // end .summary

		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		//do_action( 'woocommerce_after_single_product_summary' );


	echo '</div>'; // .inner-wrap
	echo '</div>'; // div itemscope

	}
	?>
	<script>
	(function($) {
		"use strict";
		
		$(document).ready(function () {
			// First - the MAIN var, that is - OBJECT
			var qv_holder	= $('#mm_sow-qv-holder-<?php echo esc_js($productID) ?>'),
				qv_overlay	= $('.mm_sow-qv-overlay');
					
			/* Get those variations forms to work ;) : */
			$( function() {
				if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
					$( '.variations_form' ).each( function() {
						var select_elm = $( this ).wc_variation_form().find('.variations select:eq(0)');
						select_elm.change();
						select_elm.on("change", function() { 
							setTimeout( function() {
							$(window).trigger('resize');
							} ,200 );

						})
					});
				}
			});
			
			/* Animate and display after images are loaded */
			
			qv_holder.imagesLoaded()
			.always( function( instance ) {
				
				/* LOAD SLICK SLIDER */
				var images = qv_holder.find('.images')
				if( images.hasClass("productslides") ) {
					images.slick();
				}
								
				
				var qv_wrap			= qv_holder.find(".mm_sow-qv-wrapper"),
					qv_wrap_h		= qv_wrap.outerHeight(),
					qv_overlay_H	= qv_overlay.outerHeight(true);

				var	qv_top		= (qv_overlay_H / 2) - (qv_wrap_h/2);
				
				if ( qv_top <=  55 ) { // if modal goes off the top
					qv_top = 75;
				}
				
				qv_holder.stop(true,false).animate({'top': qv_top },{ duration:300, easing: 'easeOutQuart', complete: 
					function() {						
						
						qv_wrap.stop(true,false).animate({'opacity': 1 },{ duration:300 });
						qv_holder.stop(true,false).delay(150).animate({'height': qv_wrap_h },
						{	duration: 300, 
							easing: 'easeOutQuart',
							complete: function() { 
								
								
							}
						});
					}
				});				
			})


			
			/*	QUICK VIEW WINDOW VERTICAL CENTER POSITION :	*/
			$(window).resize(function() {
				
				var qv_height = qv_overlay_H = '';

				var qv_wrap			= qv_holder.find(".mm_sow-qv-wrapper"),
					qv_height		= qv_wrap.outerHeight(true),
					qv_overlay_H	= qv_overlay.outerHeight(true);
				
							
					var	qv_top		= (qv_overlay_H / 2) - (qv_height/2);
					
					if ( qv_top <=  55 ) { // if modal goes off the top
						qv_top = 75;
					}
					
					qv_holder.css("height",qv_height );
					qv_holder.stop(true,false).delay(200).animate({'top': qv_top },{ duration:400, easing: 'easeOutQuart'} );
					

			});

			/* Images Loaded examples:
			qv_holder.imagesLoaded()
			.always( function( instance ) {
				console.log('all images loaded');
			})
			.done( function( instance ) {
				console.log('all images successfully loaded');

			})
			.fail( function() {
				console.log('all images loaded, at least one is broken');
			})
			.progress( function( instance, image ) {
				var result = image.isLoaded ? 'loaded' : 'broken';
				console.log( 'image is ' + result + ' for ' + image.img.src );
			});
			 */
			
		});
	
	})(jQuery);
	</script>
	<?php 
	
	
	/* reset, clean buffer and respond with content */
	wp_reset_postdata();
	$response = ob_get_contents();
	ob_flush();

	// do_action( 'mm_sow_ajax_response', $response );
	
	die(1);
	
} // QUICK VIEW - Products popup
?>