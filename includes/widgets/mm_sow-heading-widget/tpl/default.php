<?php
/**
 * @var $style
 * @var $align
 * @var $heading
 * @var $heading_size
 * @var $heading_color
 * @var $heading_font 
 * @var $image_id
 * @var $subtitle
 * @var $subheading_size
 * @var $subheading_color
 * @var $subheading_font
 * @var $short_text
 */

// URL for css for divider image:
$image_url	= "";
if( $image_id  ) {
	$image_atts =  wp_get_attachment_image_src( $image_id, 'full' );
	$image_url	= $image_atts[0];
}

// Customizing heading and subheading size and color:
$hs	= 100 + intval( $heading_size );
$shs	= 100 + intval( $subheading_size );
$h_color = $heading_color ? 'color:' .$heading_color .';' : '';
$sh_color = $subheading_color ? 'color:' . $subheading_color .';' : '';
?>

<div class="mm_sow-heading mm_sow-<?php echo $style; ?> mm_sow-align<?php echo $align; ?>">

    <?php if ( $style == 'style2' && !empty( $subtitle ) ): ?>

        <div class="mm_sow-subtitle">
			<span style="font-size: <?php echo esc_attr( $shs ) .'%;'; ?><?php echo wp_kses_post( $sh_color ); ?> ">
				<?php echo esc_html($subtitle); ?>
			</span>
		</div>

    <?php endif; ?>

    <?php echo '<' . esc_attr( $heading_tag ) . ' class="mm_sow-title">'; ?> 
		<span style="font-size: <?php echo esc_attr( $hs ) .'%;'; ?><?php echo wp_kses_post( $h_color ); ?> ">
			<?php echo wp_kses_post( $heading ); ?>
		</span>
	<?php echo '</' . esc_attr( $heading_tag ) . '>' ?>
	
	<?php if( $image_id ) { ?>
	
	<div class="mm_sow-heading-image" <?php echo ( $image_id ? 'style="background-image: url('.$image_url.')"' : '' );?>></div>
	
	<?php } ?>

    <?php if ($style != 'style3' && !empty($short_text)): ?>

        <p class="mm_sow-text"><?php echo wp_kses_post($short_text); ?></p>

    <?php endif; ?>

</div>