<?php

// Exit if accessed directly
if ( !defined('ABSPATH') ) {
    exit;	
}

function mm_sow_get_terms( $taxonomy ) {

    global $wpdb;

    $term_coll = array();

    $args = array(
		'hierarchical'	=> 1,
		'taxonomy'		=> $taxonomy,
		'hide_empty'	=> false,
	);
	
	if ( taxonomy_exists( $taxonomy ) ) {
        $terms = get_terms( $args ); // Get all terms of a taxonomy

        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $term_coll[$term->slug] = $term->name;
            }
        }
    }
    else {

        $qt = 'SELECT * FROM ' . $wpdb->terms . ' AS t INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy =  "' . $taxonomy . '" AND tt.count > 0 ORDER BY  t.term_id DESC LIMIT 0 , 30';

        $terms = $wpdb->get_results($qt, ARRAY_A);

        if ( $terms && !is_wp_error($terms) ) {
            foreach ($terms as $term) {
                $term_coll[$term['slug']] = $term['name'];
            }
        }
    }

    return $term_coll;
}
/**
 *  Check if taxonomy is assigned to the right post type
 *  
 *  @param [in] $post_type
 *  @param [in] $taxonomy 
 *  @return boolean
 *  
 */
function mm_sow_is_taxonomy_assigned_to_post_type( $post_type, $taxonomy = null ) {	
	if ( is_object( $post_type ) )
		$post_type = $post_type->post_type;
	if ( empty( $post_type ) )
		return false;
	$taxonomies = get_object_taxonomies( $post_type );
	if ( empty( $taxonomy ) )
		$taxonomy = get_query_var( 'taxonomy' );
	return in_array( $taxonomy, $taxonomies );
}
/**
 *  GET CHOSEN TERMS FOR THE TAXONOMY / POST TYPE
 *  
 *  @param [in] $query_args
 *  @return array or terms
 *  
 */
function mm_sow_get_chosen_terms($query_args) {

    $chosen_terms = array();
    $taxonomy_filter = '';

    $query_args = wp_parse_args($query_args);

    if (!empty($query_args) && !empty($query_args['tax_query'])) {
        $terms_query = explode(',', $query_args['tax_query']);
        foreach ($terms_query as $term_query) {
            list($taxonomy, $term_slug) = explode(':', $term_query);

            if (empty($taxonomy) || empty($term_slug))
                continue;
            $chosen_terms[] = get_term_by('slug', $term_slug, $taxonomy);
            $taxonomy_filter = $taxonomy;
        }
    }
    return array($chosen_terms, $taxonomy_filter);
}

function mm_sow_entry_terms_list($taxonomy = 'category', $separator = ', ', $before = ' ', $after = ' ') {
    global $post;

    $output = '<span class="mm_sow-' . $taxonomy . '-list">';
    $output .= get_the_term_list($post->ID, $taxonomy, $before, $separator, $after);
    $output .= '</span>';

    return $output;
}

function mm_sow_get_posts() {

    $list = array();

    $args = $args = array(
        'posts_per_page' => -1,
        'offset' => 0,
        'category' => '',
        'category_name' => '',
        'orderby' => 'date',
        'order' => 'DESC',
        'include' => '',
        'exclude' => '',
        'meta_key' => '',
        'meta_value' => '',
        'post_type' => 'post',
        'post_mime_type' => '',
        'post_parent' => '',
        'author' => '',
        'post_status' => 'publish',
        'suppress_filters' => true
    );

    $posts = get_posts($args);

    if (!empty ($posts)) {
        foreach ($posts as $post) {
            $list[$post->ID] = $post->post_title;
        }
    }

    return $list;
}

/**
 *  POSTED IN
 *  
 *  @param [string] $taxonomy Parameter_Description
 *  @return $posted_in string with term links list for current post/taxonomy, html formatted
 *  
 */
function mm_sow_posted_in($taxonomy) {
    
	$terms		= get_the_terms( get_the_ID(), $taxonomy );
	$posted_in	= "";
	
	if ( $terms && ! is_wp_error( $terms ) ) {
	 
		$posted_in = '<span class="posted_in mm_sow-terms">';
		
		$posted_in_terms = array();
		$lastTerm	= end($terms);
		foreach ( $terms as $term ) {
			
			$term_color		= mm_sow_get_term_color( $term->term_id, true );
			$text_color		= $term_color ? mm_sow_contrast( $term_color ) : '#333333';
			$back_color		= $term_color ? $term_color : '#ffffff';
			$style			= ' style="background-color: '. $back_color .'; color: '.$text_color.'"'; 
			
			$separator = ( $term == $lastTerm ) ? '' : '<span class="separator"></span>';
			$posted_in .= '<a href="' . esc_url( get_term_link( $term->slug, $taxonomy ) ) . '" rel="tag" tabindex="0"'.$style.'>' . esc_html( $term->name .' ' . $term->ID ) . '</a>' . wp_kses_post( $separator );
			
		}
		
		$posted_in .= '</span>';
		
	 }
	
	return $posted_in;
	
}


function mm_sow_entry_published() {

    $published = '<span class="published"><time datetime="' . sprintf(get_the_time(esc_html__('Y-m-d', 'mm_sow'))) . '">' . sprintf(get_the_time(get_option('date_format',"M d, Y" ))) . '</time></span>';

    return $published;

}

function mm_sow_entry_author() {
    $author = '<span class="author vcard">' . esc_html__('By ', 'mm_sow') . '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author_meta('display_name')) . '">' . esc_html(get_the_author_meta('display_name')) . '</a></span>';
    return $author;
}

/** Isotope filtering support for Portfolio pages * */

function mm_sow_get_taxonomy_terms_filter($taxonomy, $chosen_terms = array()) {

    $output = '';

    if (empty($chosen_terms))
        $terms = get_terms($taxonomy);
    else
        $terms = $chosen_terms;

    if (!empty($terms) && !is_wp_error($terms)) {

        $output .= '<div class="mm_sow-taxonomy-filter">';

        $output .= '<div class="mm_sow-filter-item segment-0 mm_sow-active"><a data-value="*" href="#">' . esc_html__('All', 'mm_sow') . '</a></div>';

        $segment_count = 1;
        foreach ($terms as $term) {

            $output .= '<div class="mm_sow-filter-item segment-' . intval($segment_count) . '"><a href="#" data-value=".term-' . intval($term->term_id) . '" title="' . esc_html__('View all items from ', 'mm_sow') . esc_attr($term->name) . '">' . esc_html($term->name) . '</a></div>';

            $segment_count++;
        }

        $output .= '</div>';

    }

    return $output;
}

/* Return the css class name to help achieve the number of columns specified */

function mm_sow_get_column_class($column_size = 3, $no_margin = false) {

    $style_class = 'mm_sow-threecol';

    $no_margin = mm_sow_to_boolean($no_margin); // make sure it is not string

    $column_styles = array(
        1 => 'mm_sow-twelvecol',
        2 => 'mm_sow-sixcol',
        3 => 'mm_sow-fourcol',
        4 => 'mm_sow-threecol',
        5 => 'mm_sow-onefifthcol',
        6 => 'mm_sow-twocol',
        12 => 'mm_sow-onecol'
    );

    if (array_key_exists($column_size, $column_styles) && !empty($column_styles[$column_size])) {
        $style_class = $column_styles[$column_size];
    }

    $style_class = $no_margin ? ($style_class . ' mm_sow-zero-margin') : $style_class;

    return $style_class;
}

/*
* Converting string to boolean is a big one in PHP
*/
function mm_sow_to_boolean($value) {
    if (!isset($value))
        return false;
    if ($value == 'true' || $value == '1')
        $value = true;
    elseif ($value == 'false' || $value == '0')
        $value = false;
    return (bool)$value; // Make sure you do not touch the value if the value is not a string
}


/**
 * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
 * @param str $hex Colour as hexadecimal (with or without hash);
 * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
 * @return str Lightened/Darkend colour as hexadecimal (with hash);
 */
function mm_sow_color_luminance($hex, $percent) {

    // validate hex string

    $hex = preg_replace('/[^0-9a-f]/i', '', $hex);
    $new_hex = '#';

    if (strlen($hex) < 6) {
        $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
    }

    // convert to decimal and change luminosity
    for ($i = 0; $i < 3; $i++) {
        $dec = hexdec(substr($hex, $i * 2, 2));
        $dec = min(max(0, $dec + $dec * $percent), 255);
        $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
    }

    return $new_hex;
}

function mm_sow_get_option($option_name, $default = null) {

    $settings = get_option('mm_sow_settings');

    if (!empty($settings) && isset($settings[$option_name]))
        $option_value = $settings[$option_name];
    else
        $option_value = $default;

    return $option_value;
}

function mm_sow_update_option($option_name, $option_value) {

    $settings = get_option('mm_sow_settings');

    if (empty($settings))
        $settings = array();

    $settings[$option_name] = $option_value;

    update_option('mm_sow_settings', $settings);
}

/**
 * Update multiple options in one go
 * @param array $setting_data An collection of settings key value pairs;
 */
function mm_sow_update_options($setting_data) {

    $settings = get_option('mm_sow_settings');

    if (empty($settings))
        $settings = array();

    foreach ($setting_data as $setting => $value) {
        // because of get_magic_quotes_gpc()
        $value = stripslashes($value);
        $settings[$setting] = $value;
    }

    update_option('mm_sow_settings', $settings);
}

/**
 * Get system info
 *
 */
function mm_sow_get_sysinfo() {
    global $wpdb;

    // Get theme info
    $theme_data = wp_get_theme();
    $theme = $theme_data->Name . ' ' . $theme_data->Version;

    $return = '### <strong>Begin System Info</strong> ###' . "\n\n";

    // Start with the basics...
    $return .= '-- Site Info' . "\n\n";
    $return .= 'Site URL:                 ' . site_url() . "\n";
    $return .= 'Home URL:                 ' . home_url() . "\n";
    $return .= 'Multisite:                ' . (is_multisite() ? 'Yes' : 'No') . "\n";

    // Theme info
    $plugin = get_plugin_data(MM_SOW_PLUGIN_FILE);


    // Plugin configuration
    $return .= "\n" . '-- Plugin Configuration' . "\n\n";
    $return .= 'Name:                     ' . $plugin['Name'] . "\n";
    $return .= 'Version:                  ' . $plugin['Version'] . "\n";

    // WordPress configuration
    $return .= "\n" . '-- WordPress Configuration' . "\n\n";
    $return .= 'Version:                  ' . get_bloginfo('version') . "\n";
    $return .= 'Language:                 ' . (defined('WPLANG') && WPLANG ? WPLANG : 'en_US') . "\n";
    $return .= 'Permalink Structure:      ' . (get_option('permalink_structure') ? get_option('permalink_structure') : 'Default') . "\n";
    $return .= 'Active Theme:             ' . $theme . "\n";
    $return .= 'Show On Front:            ' . get_option('show_on_front') . "\n";

    // Only show page specs if frontpage is set to 'page'
    if (get_option('show_on_front') == 'page') {
        $front_page_id = get_option('page_on_front');
        $blog_page_id = get_option('page_for_posts');

        $return .= 'Page On Front:            ' . ($front_page_id != 0 ? get_the_title($front_page_id) . ' (#' . $front_page_id . ')' : 'Unset') . "\n";
        $return .= 'Page For Posts:           ' . ($blog_page_id != 0 ? get_the_title($blog_page_id) . ' (#' . $blog_page_id . ')' : 'Unset') . "\n";
    }

    $return .= 'ABSPATH:                  ' . ABSPATH . "\n";


    $return .= 'WP_DEBUG:                 ' . (defined('WP_DEBUG') ? WP_DEBUG ? 'Enabled' : 'Disabled' : 'Not set') . "\n";
    $return .= 'Memory Limit:             ' . WP_MEMORY_LIMIT . "\n";
    $return .= 'Registered Post Stati:    ' . implode(', ', get_post_stati()) . "\n";

    // Get plugins that have an update
    $updates = get_plugin_updates();

    // WordPress active plugins
    $return .= "\n" . '-- WordPress Active Plugins' . "\n\n";

    $plugins = get_plugins();
    $active_plugins = get_option('active_plugins', array());

    foreach ($plugins as $plugin_path => $plugin) {
        if (!in_array($plugin_path, $active_plugins))
            continue;

        $update = (array_key_exists($plugin_path, $updates)) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
        $return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
    }

    // WordPress inactive plugins
    $return .= "\n" . '-- WordPress Inactive Plugins' . "\n\n";

    foreach ($plugins as $plugin_path => $plugin) {
        if (in_array($plugin_path, $active_plugins))
            continue;

        $update = (array_key_exists($plugin_path, $updates)) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
        $return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
    }

    if (is_multisite()) {
        // WordPress Multisite active plugins
        $return .= "\n" . '-- Network Active Plugins' . "\n\n";

        $plugins = wp_get_active_network_plugins();
        $active_plugins = get_site_option('active_sitewide_plugins', array());

        foreach ($plugins as $plugin_path) {
            $plugin_base = plugin_basename($plugin_path);

            if (!array_key_exists($plugin_base, $active_plugins))
                continue;

            $update = (array_key_exists($plugin_path, $updates)) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
            $plugin = get_plugin_data($plugin_path);
            $return .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . "\n";
        }
    }

    // Server configuration (really just versioning)
    $return .= "\n" . '-- Webserver Configuration' . "\n\n";
    $return .= 'PHP Version:              ' . PHP_VERSION . "\n";
    $return .= 'MySQL Version:            ' . $wpdb->db_version() . "\n";
    $return .= 'Webserver Info:           ' . $_SERVER['SERVER_SOFTWARE'] . "\n";

    // PHP configs... now we're getting to the important stuff
    $return .= "\n" . '-- PHP Configuration' . "\n\n";
    $return .= 'Safe Mode:                ' . (ini_get('safe_mode') ? 'Enabled' : 'Disabled' . "\n");
    $return .= 'Memory Limit:             ' . ini_get('memory_limit') . "\n";
    $return .= 'Upload Max Size:          ' . ini_get('upload_max_filesize') . "\n";
    $return .= 'Post Max Size:            ' . ini_get('post_max_size') . "\n";
    $return .= 'Upload Max Filesize:      ' . ini_get('upload_max_filesize') . "\n";
    $return .= 'Time Limit:               ' . ini_get('max_execution_time') . "\n";
    $return .= 'Max Input Vars:           ' . ini_get('max_input_vars') . "\n";
    $return .= 'Display Errors:           ' . (ini_get('display_errors') ? 'On (' . ini_get('display_errors') . ')' : 'N/A') . "\n";

    $return = apply_filters('edd_sysinfo_after_php_config', $return);

    // PHP extensions and such
    $return .= "\n" . '-- PHP Extensions' . "\n\n";
    $return .= 'cURL:                     ' . (function_exists('curl_init') ? 'Supported' : 'Not Supported') . "\n";
    $return .= 'fsockopen:                ' . (function_exists('fsockopen') ? 'Supported' : 'Not Supported') . "\n";
    $return .= 'SOAP Client:              ' . (class_exists('SoapClient') ? 'Installed' : 'Not Installed') . "\n";
    $return .= 'Suhosin:                  ' . (extension_loaded('suhosin') ? 'Installed' : 'Not Installed') . "\n";

    $return .= "\n" . '### End System Info ###';

    return $return;
}
/**
 *  GENERATE RANDOM STRING
 *  
 *  @param [in] $length how much random letters/numbers
 *  @return $randomString
 *  
 */
function mm_sow_generateRandomString($length = 10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
add_filter('mm_sow_randomString','mm_sow_generateRandomString',10,1);
/**
 *	HEX TO RGB - NEEDED FOR CSS BACKGROUND COLOR STYLES
 *
 */
function mm_sow_hex2rgb_func( $colour ) {
	
	if( !isset($colour[0]) )
		return;
	if ( $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
	}
	if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
	} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
	} else {
			return false;
	}
	$r = hexdec( $r );
	$g = hexdec( $g );
	$b = hexdec( $b );
	//return array( 'red' => $r, 'green' => $g, 'blue' => $b );
	return $rgb = $r.', '. $g .', ' . $b ;	    
} 
add_filter( 'mm_sow_hex2rgb','mm_sow_hex2rgb_func', 10, 1 );
/**
 *  Get term meta - color and sanitize it
 */
function mm_sow_sanitize_hex( $color ) {
    $color = ltrim( $color, '#' );
    return preg_match( '/([A-Fa-f0-9]{3}){1,2}$/', $color ) ? $color : '';
}

function mm_sow_get_term_color( $term_id, $hash = false ) {

    $color = get_term_meta( $term_id, 'color', true );
    $color = mm_sow_sanitize_hex( $color );

    return $hash && $color ? "#{$color}" : $color;
}
function mm_sow_contrast( $hexcolor ){
   // return ( hexdec($hexcolor) > 0xffffff/2 ) ? 'black':'white'; // simple version, different b/w returns.
	$hexcolor  = '#'. $hexcolor;
	$r = hexdec( substr( $hexcolor,0,2 ) );
	$g = hexdec( substr( $hexcolor,2,2 ) );
	$b = hexdec( substr( $hexcolor,4,2 ) );
	$yiq = ( ($r*299)+($g*587)+($b*114) )/1000;
	return ($yiq >= 128) ? 'black' : 'white';
}
/**
 *	MM_SOW_IMAGE_SIZES hook
 *	- create array of all registered image sizes
 *	- dependency - helper function mm_sow_title_it() - create title from slug
 */
add_filter('mm_sow_image_sizes','mm_sow_image_sizes_arr',10,1);
function mm_sow_image_sizes_arr( $default = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array();
	$intermediate_image_sizes = get_intermediate_image_sizes();
	$additional_image_sizes = array_keys( $_wp_additional_image_sizes );
	
	$sizes_arr = array_merge( $intermediate_image_sizes, $additional_image_sizes, array("full") );
	
	foreach( $sizes_arr as $size ) {
		
		$title = mm_sow_title_it( $size );
		$sizes[ $size ] = $title;
	}
	
	return $sizes;
}
function mm_sow_title_it( $slug ) {
	$title = ucfirst( $slug );
	$title = str_replace("_"," ", $title);
	$title = str_replace("-"," ", $title);
	return $title;
}
/**
 *  end MM_SOW_IMAGE_SIZES
 */
/**
 *  PLACEHOLDER IMAGE
 */
add_filter( 'mm_sow_placholder_image','mm_sow_placholder_image_f' );
function mm_sow_placholder_image_f( $placeholder_img_url ) {
	
	$placeholder_img_url = MM_SOW_PLUGIN_URL .'assets/images/no-image.svg';
	
	return $placeholder_img_url;
}

/**
 *  MM_SOW_WOOCOMMERCE_LOCATE_TEMPLATE
 *  - override widget WC products
 */

add_filter( 'woocommerce_locate_template', 'mm_sow_woocommerce_locate_template', 10, 3 );
function mm_sow_woocommerce_locate_template( $template, $template_name, $template_path ) {
 
	global $woocommerce;

	$_template = $template;

	if ( ! $template_path ) $template_path = $woocommerce->template_url;

	$plugin_path  = MM_SOW_PLUGIN_DIR . 'includes/woocommerce-templates/';

	// Look within passed path within the theme - this is priority

	$template = locate_template(
		array(
			$template_path . $template_name,
			$template_name
		)
	);

	// Modification: Get the template from this plugin, if it exists
	if ( ! $template && file_exists( $plugin_path . $template_name ) )
		$template = $plugin_path . $template_name;

	// Use default template

	if ( ! $template )
		$template = $_template;

	// Return what we found
	return $template;
	 
}

/**
 *  @brief Brief
 *  
 *  @param [int]		$postID Parameter_Description
 *  @param [boolean]	$more Parameter_Description
 *  @param [int]		$length Parameter_Description
 *  @param [boolean]	$hellip Parameter_Description
 *  @return Return_Description
 *  
 *  @details
 *	Use this instead of the_excerpt(); and get_the_excerpt(); so we can have better control over the excerpt.
 *	Several ways to implement this:
 *	Inside the loop (or outside the loop for current post/page): mm_sow_excerpt('Read more &raquo;', 20, 1);
 *	Outside the loop: mm_sow_excerpt(572, 'Read more &raquo;', 20, 1);
 */
function mm_sow_excerpt( $postID=0, $more=0, $length=55, $hellip=0 ) {
	if ( $postID && is_int($postID) ) {
		$the_post = get_post($postID);
	} else {
		if ( $postID != 0 || is_string($postID) ) {
			if ( $length == 0 || $length == 1 ) {
				$hellip = $length;
			} else {
				$hellip = false;
			}
			
			if ( is_int($more) ) {
				$length = $more;
			} else {
				$length = 55;
			}
			
			$more = $postID;
		}
		$postID = get_the_ID();
		$the_post = get_post($postID);
	}
	
	if ( $the_post->post_excerpt ) {
		$string = strip_tags(strip_shortcodes($the_post->post_excerpt), '');
	} else {
		$string = strip_tags(strip_shortcodes($the_post->post_content), '');
	}
	
	$string = mm_sow_string_limit_words($string, $length);
	
	if ( $hellip ) {
		if ( $string[1] == 1 ) {
			$string[0] .= '&hellip; ';
		}
	}
		
	if ( isset($more) && $more != '' ) {
		$string[0] .= ' <a class="nebula_the_excerpt" href="' . get_permalink($postID) . '">' . $more . '</a>';
	}
	
	return $string[0];
}

//Text limiter by words
function mm_sow_string_limit_words($string, $word_limit){
	$limited[0] = $string;
	$limited[1] = 0;
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit){
		array_pop($words);
		$limited[0] = implode(' ', $words);
		$limited[1] = 1;
	}
	return $limited;
}
/**
 * GET WIDGET AREAS
 * 
 * @return <array> $sidebar_options
 */
function mm_sow_get_widgets_after_init() {
		
	$sidebar_options["select-widget-area"] = esc_html__( 'Select widget area', 'mm_sow' );
	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ){
		$sidebar_options[$sidebar['id']] = $sidebar['name'];
	}
	
	return $sidebar_options;
}
add_filter( 'mm_sow_get_widgets', 'mm_sow_get_widgets_after_init' , 10 );
/**
 * POST ITEMS IMAGE
 * 
 * @return <html>
 */
function mm_sow_item_image_func ( $img_format, $title_hover, $display_tax, $taxonomy ) {
	?>
	<div class="mm_sow-item-image">

		<?php 
		$thumbnail_exists = has_post_thumbnail();
		if ( $thumbnail_exists ) { 
			the_post_thumbnail( $img_format ); 
		}else{ 
		?>
			<img src="<?php echo esc_url( apply_filters('mm_sow_placholder_image','') );?>" class="placeholder-image" alt="<?php esc_attr_e( 'No image','mm_sow' ); ?>">
		
		<?php } ?>

		<div class="mm_sow-image-info">

			<div class="mm_sow-entry-info">

				<?php if ( $title_hover ) { ?>
				
					<small><?php esc_html_e("View details about","mm_sow"); ?></small>
					
					<?php the_title('<h4 class="mm_sow-post-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( "echo=0" ) . '" rel="bookmark">', '</a></h4>'); ?>
				
				<?php } ?>
				
				<?php if ( $display_tax ) { ?>

					<?php if ( ! $title_hover ) { ?>
					<small><?php esc_html_e("Posted in","mm_sow"); ?></small>
					<?php } ?>
				
					<?php echo mm_sow_posted_in($taxonomy); ?>

				<?php } ?>

			</div>

		</div>

		<div class="mm_sow-image-overlay"></div>

	</div>
	<?php
}
add_action( 'mm_sow_item_image', 'mm_sow_item_image_func', 10, 4 );
/**
 * POST ITEMS TEXT
 * 
 * @return <html>
 */
function mm_sow_item_text_func ( $display_title, $display_summary, $meta_author, $meta_date ) {
	 
	 $thumbnail_exists	= has_post_thumbnail();
	 $post_type			= get_post_type();
	 
	 if ( $display_title || $display_summary ) { ?>

		<div class="mm_sow-entry-text-wrap <?php echo( $thumbnail_exists ? '' : ' nothumbnail' ); ?>">

			<?php if ( $display_title ) { ?>
				<?php the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' .  the_title_attribute( "echo=0" ) . '" rel="bookmark">', '</a></h3>'); ?>
			<?php } ?>

			<?php if( $meta_author || $meta_date )  { ?>
				<div class="mm_sow-entry-meta">

					<?php 
					if( $meta_author ) { 
						echo mm_sow_entry_author(); 
					} 
					if ( $meta_date ) {
						echo mm_sow_entry_published();
					} 
					?>

				</div>
			<?php } ?>

			<?php 
			if( $post_type == "product" ) {
						
				woocommerce_template_loop_price();
				
				do_action( 'mm_sow_product_buttons' );
				
			}
			?>

			<?php if ( $display_summary && $post_type != "product") { ?>
				<div class="entry-summary">

					<p><?php echo get_the_excerpt(); ?></p>

				</div>
			<?php } ?>

		</div>

	<?php }
}
add_action( 'mm_sow_item_text', 'mm_sow_item_text_func', 10, 4 );