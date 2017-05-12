<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class MM_SOW_Admin {


    protected $plugin_slug = 'micemade_so_widgets';

    public function __construct() {

        $this->includes();
        $this->init_hooks();

    }

    public function includes() {
		// load wp_filesystem wrapper class
		require_once MM_SOW_PLUGIN_DIR . 'includes/wp-filesystem.php';
		// load class admin ajax function
        require_once MM_SOW_PLUGIN_DIR . 'admin/admin-ajax.php';

    }

    public function init_hooks() {

        // Build admin menu/pages
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));

        // Load admin style sheet and JavaScript.
        add_action('admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts') );

        add_action('current_screen', array( $this, 'remove_admin_notices') );
		
		add_action('admin_init', array( $this, 'remove_deprecated_templates') );

    }

    public function remove_admin_notices($screen) {

        // If this screen is Micemade SiteOrigin Widgets plugin options page, remove annoying admin notices
        if (strpos($screen->id, $this->plugin_slug) !== false) {
            add_action('admin_notices', array(&$this, 'remove_notices_start'));
            add_action('admin_notices', array(&$this, 'remove_notices_end'), 999);
        }
    }

    public function remove_notices_start() {

        // Turn on output buffering
        ob_start();

    }

    public function remove_notices_end() {

        // Get current buffer contents and delete current output buffer
        $content = ob_get_contents();
        ob_clean();

    }

    public function add_plugin_admin_menu() {

        add_menu_page(
            'Micemade SiteOrigin Widgets',
            __('MM SO Widgets', 'mm_sow'),
            'manage_options',
            $this->plugin_slug,
            array($this, 'display_settings_page'),
            MM_SOW_PLUGIN_URL . 'admin/assets/images/micemade-icon-16.png',
			66
        );

        // add plugin settings submenu page
        add_submenu_page(
            $this->plugin_slug,
            'Widgets Settings',
            __('Settings', 'mm_sow'),
            'manage_options',
            $this->plugin_slug,
            array($this, 'display_settings_page')
        );

        // add import/export submenu page
        add_submenu_page(
            $this->plugin_slug,
            'Widgets Documentation',
            __('Documentation', 'mm_sow'),
            'manage_options',
            $this->plugin_slug . '_documentation',
            array($this, 'display_plugin_documentation')
        );

    }

    public function display_settings_page() {

        require_once('views/admin-header.php');
        require_once('views/admin-banner2.php');
        require_once('views/settings.php');
        require_once('views/admin-footer.php');

    }

    public function display_plugin_documentation() {


        require_once('views/admin-header.php');
        require_once('views/admin-banner1.php');
        require_once('views/documentation.php');
        require_once('views/admin-footer.php');

    }


    public function enqueue_admin_scripts() {

        // Use minified libraries if MM_SOW_SCRIPT_DEBUG is turned off
        $suffix = (defined('MM_SOW_SCRIPT_DEBUG') && MM_SOW_SCRIPT_DEBUG) ? '' : '.min';

        // get current admin screen
        $screen = get_current_screen();
		
        // If screen is a part of Micemade SiteOrigin Widgets plugin options page
        if (strpos($screen->id, $this->plugin_slug) !== false) {

            wp_enqueue_script('jquery-ui-datepicker');

            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');

            wp_register_style('mm_sow-admin-styles', MM_SOW_PLUGIN_URL . 'admin/assets/css/mm_sow-admin.css', array(), MM_SOW_VERSION);
            wp_enqueue_style('mm_sow-admin-styles');

            wp_register_script('mm_sow-admin-scripts', MM_SOW_PLUGIN_URL . 'admin/assets/js/mm_sow-admin' . $suffix . '.js', array(), MM_SOW_VERSION, true);
            wp_enqueue_script('mm_sow-admin-scripts');

            wp_register_style('mm_sow-admin-page-styles', MM_SOW_PLUGIN_URL . 'admin/assets/css/mm_sow-admin-page.css', array(), MM_SOW_VERSION);
            wp_enqueue_style('mm_sow-admin-page-styles');
        }

        if (strpos($screen->id, $this->plugin_slug . '_documentation') !== false ) {

            // Load scripts and styles for documentation
            wp_register_script('mm_sow-doc-scripts', MM_SOW_PLUGIN_URL . 'admin/assets/js/documentation' . $suffix . '.js', array(), MM_SOW_VERSION, true);
            wp_enqueue_script('mm_sow-doc-scripts');

            wp_register_style('mm_sow-doc-styles', MM_SOW_PLUGIN_URL . 'admin/assets/css/documentation.css', array(), MM_SOW_VERSION);
            wp_enqueue_style('mm_sow-doc-styles');

            // Thickbox
            add_thickbox();

        }

		if ( $screen->base == "post" ) {
			wp_register_style('mm_sow-admin-builder-styles', MM_SOW_PLUGIN_URL . 'admin/assets/css/mm_sow-admin-builder.css', array(), MM_SOW_VERSION);
            wp_enqueue_style('mm_sow-admin-builder-styles');
		}
		
    }
	
	/**
	 *  REMOVE DEPRECATED FILES
	 *   
	 *  @details delete files (mostly WC templates) not needed anymore (reducing WC templates)
	 *  for easier WC / theme compatiblity and maintenance
	 */
	function remove_deprecated_templates() {
		
		$files_to_remove = array( 
			'includes/woocommerce-templates/content-widget-product.php',	// since MM SOW 0.9.6
		);
		
		if( empty( $files_to_remove ) ) return;
		
		$wpfilesys = new DBI_Filesystem();
		
		foreach( $files_to_remove as $file_to_remove ) {
			
			$file =  MM_SOW_PLUGIN_DIR . $file_to_remove;
			if( $wpfilesys->file_exists( $file ) ) {
				$wpfilesys->unlink( $file );
			}
		}
		
	}

}

new MM_SOW_Admin;