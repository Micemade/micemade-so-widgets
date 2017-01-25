<?php
/**
 * @var $id
 * @var $widget_area
 */

$icon_html = '';

$id = (!empty($id)) ? ' id="' . $id . '"' : '';
?>

<div class="widget-area mm_sow-widget-area">

<?php 
if ( is_active_sidebar( $widget_area ) ) {
	
	dynamic_sidebar( $widget_area );
	
}
?>

</div>