<?php
/**
 * @var $carousel_settings
 * @var $settings
 * @var $posts
 */
 

if( !empty( $instance['title'] ) && !$instance['hide_title'] ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

// settings array to vars:
$style			= $settings['style'];

$taxonomy		= $settings['taxonomy_chosen'];
$display_tax	= $settings['display_taxonomy'];
$img_format		= $settings['img_format'];
$title_hover	= $settings['title_on_hover'];

$display_title	= $settings['display_title'];
$display_summary= $settings['display_summary'];
$meta_date		= $settings['post_meta']['display_post_date'];
$meta_author 	= $settings['post_meta']['display_author'];


$query_args = siteorigin_widget_post_selector_process_query($posts);

// Use the processed post selector query to find posts.
$loop = new WP_Query($query_args);

// Loop through the posts and do something with them.
if ( $loop->have_posts()) { ?>

	<?php $unique_class = apply_filters( 'mm_sow_randomString',10 ); ?>

    <div class="<?php echo esc_attr($unique_class); ?> mm_sow-posts-carousel mm_sow-container <?php echo esc_attr( $style )?>" <?php foreach ($carousel_settings as $key => $val) { ?>
        <?php if (!empty($val)) { ?>
            data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
        <?php } ?>
	<?php } ?>>


        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
		
			<?php $post_type = get_post_type(); ?>

            <div data-id="id-<?php the_ID(); ?>" class="mm_sow-posts-carousel-item">

                <article <?php post_class(); ?>>

					<?php do_action( 'mm_sow_item_image', $img_format, $title_hover, $display_tax, $taxonomy ); ?>

                    <?php do_action( 'mm_sow_item_text',  $display_title, $display_summary, $meta_author, $meta_date ); ?>

                </article>
                <!-- .hentry -->

            </div><!--.mm_sow-posts-carousel-item -->

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>
		
        <?php wp_reset_query(); ?>

    </div> <!-- .mm_sow-posts-carousel -->
	
<?php } ?>