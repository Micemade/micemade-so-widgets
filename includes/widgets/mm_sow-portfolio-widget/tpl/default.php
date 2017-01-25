<?php
/**
 * @var $settings
 * @var $heading
 * @var $taxonomy_filter
 * @var $posts
 */

if( !empty( $instance['title'] ) && !$instance['hide_title'] ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

// Vars for item image display ( do_action('mm_sow_item_image') ) :
$img_format		= $settings['img_format'];
$title_hover	= $settings['title_on_hover'];
$display_tax	= $settings['display_taxonomy'];
// Vars for item text & info display ( do_action('mm_sow_item_text') ) :
$display_title	= $settings['display_title'];
$display_summary= $settings['display_summary'];
$meta_date		= $settings['post_meta']['display_post_date'];
$meta_author 	= $settings['post_meta']['display_author'];

$current_page = get_queried_object_id();

$query_args = siteorigin_widget_post_selector_process_query($posts);

// Use the processed post selector query to find posts.
$loop = new WP_Query( $query_args );

// Loop through the posts and do something with them.
if ($loop->have_posts()) : ?>

    <div class="mm_sow-portfolio-wrap mm_sow-container">

        <?php $column_style = mm_sow_get_column_class(intval($settings['per_line'])); ?>

        <?php
        // Check if any taxonomy filter has been applied
        list( $chosen_terms, $taxonomy ) = mm_sow_get_chosen_terms( $posts );
        if ( empty($chosen_terms) ) {
			 $taxonomy = $taxonomy_filter;
		}
        ?>

        <div class="mm_sow-portfolio-header <?php echo esc_attr( $tax_heading_align ); ?>">

            <?php
            if ( $settings['filterable'] && $tax_heading_align == "align_right" ) {
                echo mm_sow_get_taxonomy_terms_filter( $taxonomy, $chosen_terms );
			}
            ?>
			
			<?php if ( !empty( $heading ) ) { ?>

            <h3 class="mm_sow-heading"><?php echo wp_kses_post($heading); ?></h3>

            <?php } ?>
			
			<?php
            if ( $settings['filterable'] && $tax_heading_align != "align_right") {
                echo mm_sow_get_taxonomy_terms_filter( $taxonomy, $chosen_terms );
			}
			
			?>

        </div>

        <div class="mm_sow-portfolio js-isotope mm_sow-<?php echo $settings['layout_mode']; ?>"
             data-isotope-options='{ "itemSelector": ".mm_sow-portfolio-item", "layoutMode": "<?php echo esc_attr($settings['layout_mode']); ?>" }'>

            <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                <?php $post_type = get_post_type(); ?>
				
				<?php
                if ( get_the_ID() === $current_page )
                    continue; // skip the current page since they can run into infinite loop when users choose All option in build query
                ?>

                <?php
                $style = '';
                $terms = get_the_terms(get_the_ID(), $taxonomy);
                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $style .= ' term-' . $term->term_id;
                    }
                }
                ?>

                <div data-id="id-<?php the_ID(); ?>" class="mm_sow-portfolio-item <?php echo $style; ?> <?php echo $column_style; ?> mm_sow-zero-margin">

                    <article <?php post_class(); ?>>

						<?php do_action( 'mm_sow_item_image', $img_format, $title_hover, $display_tax, $taxonomy ); ?>

                        <?php do_action( 'mm_sow_item_text',  $display_title, $display_summary, $meta_author, $meta_date ); ?>

                    </article>
                    <!-- .hentry -->

                </div><!--Isotope element -->

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        </div>
        <!-- Isotope items -->

    </div>

<?php endif; ?>