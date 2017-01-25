<?php
/**
 * @var $header_type
 * @var $custom_header
 * @var $standard_header
 * @var $scroll_to_row
 * @var $background
 * @var $settings
 */

$youtube_markup = '';
if ($background['bg_type'] == 'youtube') {
    $youtube_markup = ' data-property="{mute:true,autoPlay:true,opacity:1,loop:true, ' . 'videoURL:\'' . esc_url($background['youtube_video']['youtube_url']) . '\',' . 'quality:\'' . esc_attr($background['youtube_video']['quality']) . '\',' . 'ratio:\'' . esc_attr($background['youtube_video']['ratio']) . '\'}"';
}

?>

<?php if( !empty( $instance['title'] ) && !$instance['hide_title'] ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title']; ?>

<div class="mm_sow-hero-header mm_sow-section-bg-<?php echo $background['bg_type']; ?>" <?php echo $youtube_markup; ?>>

    <div class="mm_sow-background">

        <?php if ($background['bg_type'] == 'html5video'): ?>

            <div class="mm_sow-html5-video-bg">

                <video poster="<?php echo wp_get_attachment_url($background['bg_image']['image']); ?>" preload="auto"
                       autoplay loop muted>

                    <source src="<?php echo wp_get_attachment_url($background['html5_videos']['mp4_file']); ?>"
                            type="video/mp4">
                    <source src="<?php echo wp_get_attachment_url($background['html5_videos']['webm_file']); ?>"
                            type="video/ogg">
                    <source src="<?php echo wp_get_attachment_url($background['html5_videos']['ogg_file']); ?>"
                            type="video/webm">

                </video>

            </div><!-- .mm_sow-html5-video-bg -->

        <?php else: ?>

            <?php $attachment = wp_get_attachment_image_src(intval($background['bg_image']['image']), 'full'); ?>

            <?php if (!empty($attachment)): ?>

                <?php if ($background['bg_type'] == 'parallax'): ?>

                    <div class="mm_sow-parallax-bg"
                         style="background-image: url(<?php echo $attachment[0]; ?>);"></div>

                <?php elseif ($background['bg_type'] == 'cover' || $background['bg_type'] == 'youtube'): ?>

                    <div class="mm_sow-image-bg"
                         style="background-image: url(<?php echo $attachment[0]; ?>);"></div>

                <?php endif; ?>

            <?php endif; ?>

        <?php endif; ?>

    </div><!-- .mm_sow-background -->

    <?php

    $overlay = $background['overlay'];

    if (!empty($overlay['overlay_color'])) :

        $hex = $overlay['overlay_color'];
        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        $overlay_opacity = $overlay['overlay_opacity'] / 100;

        $bg_color = empty($overlay['overlay_color']) ? "" : "background-color: rgba(" . "$r, $g, $b, $overlay_opacity);";
        ?>

        <div class="mm_sow-overlay" style="<?php echo($bg_color); ?>"></div>

    <?php

    endif;

    ?>

    <div class="mm_sow-header-content">

        <?php if ( $header_type == 'standard' ) : ?>

            <?php
			// Customizing heading and subheading size and color
			$heading_size = $standard_header['heading_size'];
			$hs	= 100 + intval( $heading_size );
			$subheading_size = $standard_header['subheading_size'];
			$shs	= 100 + intval( $subheading_size );
			$h_color = $standard_header['heading_color'] ? 'color:' .$standard_header['heading_color'] .';' : '';
			$sh_color = $standard_header['subheading_color'] ? 'color:' . $standard_header['subheading_color'].';' : '';
			?>
			
			<div class="mm_sow-standard-header">

                <?php echo empty($standard_header['subheading']) ? '' : '<div class="mm_sow-subheading"><span style="font-size:'.$shs.'%; '.$sh_color.'">' . htmlspecialchars_decode($standard_header['subheading']) . '</span></div>'; ?>

                <?php echo empty($standard_header['heading']) ? '' : '<h3 class="mm_sow-heading"><span style="font-size:'.$hs.'%; '.$h_color.'">' . $standard_header['heading'] . '</span></h3>'; ?>

                <?php if (!empty($standard_header['button_url'])) : ?>

                    <a class="mm_sow-button mm_sow-trans"
                       href="<?php echo sow_esc_url($standard_header['button_url']); ?>"
                        <?php echo (empty($standard_header['new_window'])) ? '' : 'target="_blank"'; ?>><?php echo $standard_header['button_text']; ?></a>

                <?php endif; ?>

            </div>

        <?php elseif ($header_type == 'custom'): ?>

            <div class="mm_sow-custom-header">

                <?php echo $custom_header['custom']; ?>

            </div>

        <?php endif; ?>


    </div>

    <?php if ( !empty( $scroll_to_row ) ) { ?>

        <a href="#" data-scrollto="<?php echo esc_attr( $scroll_to_row ); ?>" class="fa fa-chevron-down mm_sow-pointer-down"></a>

    <?php } ?>

</div>