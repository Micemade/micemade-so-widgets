<?php
/**
 *  WC VERSION CONTROL
 *  
 *  @param [string] $vers_to_check - WC version to check
 *  @return $version_is_higher
 *  
 */
function mm_sow_wc_version_f( $vers_to_check ) {
	
	if( ! MM_SOW_WOO_ACTIVE ) return;
	
	$version_is_higher = false;
	if ( version_compare( WOOCOMMERCE_VERSION, $vers_to_check ) >= 0 ) {
		$version_is_higher = true;
	}
	return $version_is_higher;
}
add_filter( 'mm_sow_wc_version','mm_sow_wc_version_f', 10, 1 );
/**
 * MM_SOW_PRODUCT_BUTTONS
 *
 * echo shop action buttons - quick view, add to cart, wishlist
 * 
 * @return <type>
 */
add_action( 'mm_sow_product_buttons', 'mm_sow_product_buttons_func' );
function mm_sow_product_buttons_func() {
		
	if( ! MM_SOW_WOO_ACTIVE  ) return;
	
	if( defined('WPML_ON') ) { // if WPML plugin is active
		$id			= icl_object_id( get_the_ID(), 'product', false, ICL_LANGUAGE_CODE ); 
		$lang_code	= ICL_LANGUAGE_CODE;
	}else{
		$id			= get_the_ID();
		$lang_code	= '';
	}
	
	$shop_buy_action = 	$shop_quick =  $shop_wishlist = true;
	
	echo '<div class="mm_sow-buttons-holder">';
	
	// ADD TO CART BUTTON
	if( $shop_buy_action ) {
		echo '<div class="button-cell">';
			do_action( 'mm_sow_shop_button' ); // do_action( 'woocommerce_after_shop_loop_item' ) replacement
		echo '</div>'; // button-cell
	}
	// QUICK BUY BUTTON
	if( $shop_quick ) {
		
		echo '<div class="button-cell">';
		echo '<a href="#qv-holder-'.esc_attr($id).'" class="mm_sow-quick-view tip-top products-loop-button" data-id="'.esc_attr($id).'"'. ($lang_code ? ' data-lang="'. esc_attr($lang_code) .'"' : '') .' title="'. esc_attr__( 'Quick view','natura' ) .'"><span class="fa fa-eye"></span></a>';
		echo '</div>'; // button-cell
		
		if ( !wp_script_is( 'wc-add-to-cart-variation', 'enqueued' )) {
		
			wp_register_script( 'wc-add-to-cart-variation', WP_PLUGIN_DIR . '/woocommerce/assets/frontend/add-to-cart-variation.min.js');
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			
		}
		
	}
	// WISHLIST BUTTON
	if( MM_SOW_WISHLIST_ACTIVE && $shop_wishlist ) {
		echo '<div class="button-cell">';
			do_action('mm_sow_wishlist_button'); // Wishlist button
		echo '</div>'; // button-cell
	}

	echo '</div>'; // .table.tablerow

} // end mm_sow_product_buttons_func()

/**
 *  SHOP LOOP BUTTON (Add to cart, Select options...)
 *  
 *  @return echo button html
 *  
 *  function is edit of WC template "add-to-cart.php" ( "loop/add-to-cart.php ) 
 *  
 */
add_action( 'mm_sow_shop_button','mm_sow_shop_button_func' );
	function mm_sow_shop_button_func() {
	
	global $product;

	$product_type = $product->product_type;
	$class = "";
	if( $product_type == 'simple' ) {
		$class = 'product_type_simple add_to_cart_button ajax_add_to_cart';
	}elseif( $product_type == 'variable' ) {
		$class = 'product_type_variable add_to_cart_button';
	}

	echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		sprintf( '<div class="add-to-cart-holder"><a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="tip-top %s" title="%s"><span class="fa fa-shopping-cart"></span></a></div>',
			// attributes and title:
			esc_url( $product->add_to_cart_url() ),			// href
			esc_attr( isset( $quantity ) ? $quantity : 1 ),	// data-quantity
			esc_attr( $product->id ),						// data-product_id
			esc_attr( $product->get_sku() ),				// data-product_sku
			esc_attr( $class ),								// class
			esc_html( $product->add_to_cart_text() )		// title
		),
	$product );
}


/**
 *	Quick view images
 *
 */
add_action( 'mm_sow_quick_view_images', 'mm_sow_quick_view_images_func', 25, 1 );
function mm_sow_quick_view_images_func( $qv_img_format = "thumbnail" ) {
	
	global $post, $woocommerce, $product ;
		
	$attachment_ids = $product->get_gallery_attachment_ids();
	
	echo '<div class="images'. ( $attachment_ids ? ' productslides'  : '') .'">';
		
	// MAIN PRODUCT IMAGE - POST THUMBNAIL (FEATURED IMAGE ETC.) 
	if ( has_post_thumbnail() ) {
		
		$image_title 		= esc_attr( strip_tags( get_the_title( get_post_thumbnail_id() ) ) );
		$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
		$image       		= get_the_post_thumbnail( $post->ID,  $qv_img_format , array('title' => $image_title ) ); 
		$attachment_count   = count( $product->get_gallery_attachment_ids() );
		$product_link		= esc_attr( get_permalink() );

		echo apply_filters( 'woocommerce_single_product_image_html',sprintf('<div class="item-img" itemscope><a href="%1$s" class="woocommerce-main-image zoom" itemprop="image" alt="%2$s">%3$s</a></div>',
			 $image_link,		// 1
			 $image_title,		// 2
			 $image				// 3
		 ),  $post->ID );
		 
	} else {

		echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', apply_filters( 'mm_sow_placholder_image','' ) ) );

	}
	
	// PRODUCT GALLERY IMAGES 
	if ( $attachment_ids ) {

		$loop = 0;
		$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop == 0 || $loop % $columns == 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';

			$image_link = wp_get_attachment_url( $attachment_id );

			if ( ! $image_link )
			
				continue;
			$image_title = esc_attr( strip_tags( get_the_title( $attachment_id ) ) );
			$image       = wp_get_attachment_image( $attachment_id,  $qv_img_format , array(
				'title' => $image_title
				));
			$image_class = esc_attr( implode( ' ', $classes ) );
			

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="item-img">
%4$s</div>', 
			$image_link, 
			$image_class, 
			$image_title, 
			$image ), $attachment_id, $post->ID, $image_class );
			
			$loop++;
		}

	}
	echo '</div>';//. images
}
/**
 *  MM SOW WC PRODUCT COUNT
 *  
 *  @param [int] $term_id
 *  
 */
function mm_sow_wc_product_count( $term_id ) {
	
	$no_of_prods	= get_woocommerce_term_meta( intval($term_id),'product_count_product_cat' );

	$term_color		= mm_sow_get_term_color( $term_id, true );
	$text_color		= $term_color ? mm_sow_contrast( $term_color ) : '#333333';
	$back_color		= $term_color ? $term_color : '#ffffff';
	$style			= ' style="background-color: '. $back_color .'; color: '.$text_color.'"';
	
	$term_link		= get_term_link( intval($term_id), 'product_cat' );
		
	if ( is_wp_error( $term_link ) || !$no_of_prods ) return;
	
	$prod_count = '<span class="mm_sow-product-count posted_in">';
	
	$prod_count .= '<a href="' . esc_url( $term_link ) . '" rel="tag" tabindex="0"'.$style.'>' . sprintf( _n( '%s product', '%s products', $no_of_prods, 'mm_sow' ), $no_of_prods ) . '</a>';
	
	$prod_count .= '</span>';
	
	return $prod_count;
}
/**
 *  YITH WC WISHLIST FUNCTIONS
 *  
 */
if( MM_SOW_WISHLIST_ACTIVE ) {
	
	/**
	 * 	FUNCTIONS TO CREATE "ADD TO WISHLIST" BUTTON:
	 *	mm_sow_wishlist_locate_template()
	 *	mm_sow_wishlist_get_template() / dependency - mm_sow_wishlist_locate_template
	 *	mm_sow_wishlist_button_func() / dependency - mm_sow_wishlist_get_template and mm_sow_wishlist_locate_template
	 * 
	 */
	
	if( !function_exists( 'mm_sow_wishlist_locate_template' ) ) {
		/**
		 * Locate the templates and return the path of the file found
		 *
		 * @param string $path
		 * @param array $var
		 * @return void
		 * @since 1.0.0
		 */
		function mm_sow_wishlist_locate_template( $path, $var = NULL ){
			global $woocommerce;

			if( function_exists( 'WC' ) ){
				$woocommerce_base = WC()->template_path();
			}
			elseif( defined( 'WC_TEMPLATE_PATH' ) ){
				$woocommerce_base = WC_TEMPLATE_PATH;
			}
			else{
				$woocommerce_base = $woocommerce->plugin_path() . '/templates/';
			}

			$template_woocommerce_path	=  $woocommerce_base . $path;
			$template_path				= '/' . $path;
			$mm_sow_plugin_path			= MM_SOW_PLUGIN_DIR . 'includes/woocommerce-templates/' . $path;
			$plugin_path				= YITH_WCWL_DIR . 'templates/' . $path;
			
			$located = locate_template( array(
				$template_woocommerce_path, // Search in <theme>/woocommerce/
				$template_path,             // Search in <theme>/
			) );

			if( ! $located && file_exists( $mm_sow_plugin_path ) ){

				return apply_filters( 'mm_sow_wishlist_locate_template', $mm_sow_plugin_path, $path );
			}		
			
			if( ! $located && file_exists( $plugin_path ) ){
				
				return apply_filters( 'mm_sow_wishlist_locate_template', $plugin_path, $path );
			}
	 

			return apply_filters( 'mm_sow_wishlist_locate_template', $located, $path );
		}
		
	}

	if( !function_exists( 'mm_sow_wishlist_get_template' ) ) {
		/**
		 * Retrieve a template file.
		 * 
		 * @param string $path
		 * @param mixed $var
		 * @param bool $return
		 * @return void
		 * @since 1.0.0
		 */
		function mm_sow_wishlist_get_template( $path, $var = null, $return = false ) {
			$located = mm_sow_wishlist_locate_template( $path, $var );      
			
			if ( $var && is_array( $var ) ) 
				extract( $var );
								   
			if( $return )
				{ ob_start(); }   
																		 
			// include file located
			include( $located );
			
			if( $return )
				{ return ob_get_clean(); }
		}
	}
	/**
	 *	YITH WC Wishlist template - a template for add to Wishlist
	 *  
	 *  @return mm_sow_wishlist_get_template()
	 *  mm_sow_wishlist_get_template() is dependent on mm_sow_wishlist_locate_template()
	 */

	add_action('mm_sow_wishlist_button','mm_sow_wishlist_button_func', 10);
	function mm_sow_wishlist_button_func() {
		mm_sow_wishlist_get_template( 'add-to-wishlist.php' );
	}
}

?>