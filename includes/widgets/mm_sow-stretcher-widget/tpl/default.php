<?php
/**
 * @var $stretcher_settings
 * @var $settings
 * @var $posts
 */

if( !empty( $instance['title'] ) && !$instance['hide_title'] ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

$query_args = siteorigin_widget_post_selector_process_query($posts);

// Use the processed post selector query to find posts.
$loop = new WP_Query($query_args);

$numslides = !empty( $query_args['posts_per_page'] ) ? $query_args['posts_per_page'] : 3;

// Loop through the posts and do something with them.
if ( $loop->have_posts()) { ?>

    <div class="mm_sow-stretcher mm_sow-container cont" data-numslides="<?php echo esc_attr($numslides ); ?>" data-title="<?php echo  $instance['title']?>">

        <?php $taxonomy = $settings['taxonomy_chosen']; ?>

        <?php 
		$i = 1;
		while ($loop->have_posts()) : $loop->the_post(); ?>
		
			<?php 
			$post_type	= get_post_type(); 
			$img_atts	= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID()), $settings['img_format'] );
			$img_url	= $img_atts[0];
			if( !$img_url ){
				$img_url = apply_filters('mm_sow_placholder_image','');
			} 
			?>

            <div class="mm_sow-stretcher-item slide slide--<?php echo esc_attr($i);?>" data-id="id-<?php the_ID(); ?>" data-target="<?php echo esc_attr($i);?>" >

				<div class="slide__title slide__title--<?php echo esc_attr($i);?>">
					
					<div class="slide__close"></div>
					
					<small><?php esc_html_e("View details about","mm_sow"); ?></small>
					
					<?php $size = 100 + intval( $settings['title_size'] ) . '%' ; ?>
					
					<?php the_title('<h2 class="mm_sow-post-title"><span style="font-size:'. $size .'">', '</span></h2>'); ?>
					
					<?php
					if( $post_type == "product" ) {			
						woocommerce_template_loop_price();
					}else{
						
						if ($settings['post_meta']['display_post_date'] || $settings['post_meta']['display_author'] ) {

						echo '<div class="mm_sow-entry-meta">';

							if ($settings['post_meta']['display_author']) {
								echo mm_sow_entry_author();
							} 

							if ($settings['post_meta']['display_post_date']) {
								echo mm_sow_entry_published();
							 } 

						echo '</div>';
						
						}
						if( $post_type == "attachment" ){
							$permalink	= wp_get_attachment_url( get_post_thumbnail_id() );							
							echo '<a href="'. esc_url($permalink).'" class="button image-zoom"><i class="fa fa-search-plus" aria-hidden="true"></i></a>';
						}
					}
					?>
				
				</div>
				
				<div class="slide__bg"></div>
				
				<div class="slide__img">
					
					<div class="slide__img-wrapper" style="background-image: url( <?php echo esc_url( $img_url );?> )"></div>
				</div>
				
				<div class="slide__bg-dark"></div>
				
				<a href="<?php the_permalink();?>" target="_blank" class="more-button button">Read more</a>
				
			

				<?php if ( $settings['display_summary'] && $post_type != 'attachment' ) { ?>
				<div class="slide__postcontent-wrap<?php echo ($post_type != 'product' ? ' no-product' : ''); ?>">
					
					<?php if ( $settings['display_summary'] ) { ?>

						<div class="entry-summary">

							<p><?php echo mm_sow_excerpt( '', 30, 1); ?></p>

							
						</div>

					<?php } ?>	
					
					<?php 
					if( $post_type == "product" ) {
						do_action( 'mm_sow_product_buttons' );
					}
					
					$readmore 	= ( $post_type == "product" ) ? __( 'View product details &raquo;','mm_sow') : __( 'Read more &raquo;','mm_sow'); ?>
					<a href="<?php echo the_permalink(); ?>" class="button readmore"><?php echo esc_html( $readmore ); ?></a>
					
					<?php if ( $settings['display_taxonomy'] ) { ?>
					
						<?php echo mm_sow_posted_in($taxonomy); ?>

					<?php } ?>

					

				</div>
				
				<?php } ?>
					

            </div><!--.slide -->
			
			<?php $i++; ?>
			
        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>
		
        <?php wp_reset_query(); ?>

    </div> <!-- .mm_sow-stretcher -->

<?php } ?>