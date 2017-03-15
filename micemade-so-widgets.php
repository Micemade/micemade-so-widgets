<?php
/**
 * Plugin Name: Micemade SO Widgets
 * Plugin URI: http://micemade.com/micemade-so-widgets
 * Description: A collection of high quality widgets for use SiteOrigin page builder or in any widgetized area. SiteOrigin Widgets Bundle is required. Forked from LiveMesh SiteOrigin Widgets.
 * Author: Micemade
 * Author URI: http://micemade.com/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 * Version: 0.9.3
 * Text Domain: mm_sow
 * Domain Path: languages
 *
 * Micemade SO Widgets is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Micemade SO Widgets is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Micemade SiteOrigin Widgets. If not, see <http://www.gnu.org/licenses/>.
 *
 */

// Exit if accessed directly
if ( !defined('ABSPATH') )
    exit;

if ( !class_exists('Micemade_SO_widgets') ) :

    /**
     * Main Micemade_SO_widgets Class
     *
     */
    final class Micemade_SO_widgets {

        /** Singleton *************************************************************/

        private static $instance;

        /**
         * Main Micemade_SO_widgets Instance
         *
         * Insures that only one instance of Micemade_SO_widgets exists in memory at any one
         * time. Also prevents needing to define globals all over the place.
         */
        public static function instance() {
            
			if (!isset(self::$instance) && !(self::$instance instanceof Micemade_SO_widgets)) {
               
			   self::$instance = new Micemade_SO_widgets;
				
				if( self::$instance->SOWB_plugin_activation_check() ) {
					
					self::$instance->setup_constants();

					add_action('plugins_loaded', array(self::$instance, 'load_plugin_textdomain'));
					
					add_action('plugins_loaded', array(self::$instance, 'mm_sow_inline_css'));	

					self::$instance->includes();

					self::$instance->hooks();
					
					self::$instance->updater();
					
					// Ajax script URL (wp admin ajax), for frontend
					add_action('wp_head', array( self::$instance, 'ajax_url_var') );
					
				}else{
					add_action( 'admin_notices', array( self::$instance ,'mm_sow_dependency_notice') ); 
				}

            }
			
            return self::$instance;
        }
		
		private function SOWB_plugin_activation_check() {
		
			$sowb_is_active = false;
			
			if ( in_array( 'so-widgets-bundle/so-widgets-bundle.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
				
				$sowb_is_active = true; 
						
			}
			
			return $sowb_is_active;
			
		}
		public function mm_sow_dependency_notice() {
		
			$class = "error updated settings-error notice is-dismissible";
			$message = __("\"Micemade SO Widgets\" is not effective without \"SiteOrigin Widgets Bundle\" plugin installed and activated. Either install and activate \"SiteOrigin Widgets Bundle\" or deactivate \"Micemade SO Widgets\" plugin. ","mm_sow");
			echo"<div class=\"$class\"> <p>$message</p></div>"; 
			
		}
		
		/**
         * Setup plugin constants
         *
         */
        private function setup_constants() {

            // Plugin version
            if (!defined('MM_SOW_VERSION')) {
                define('MM_SOW_VERSION', '0.9.3');
            }

            // Plugin Folder Path
            if (!defined('MM_SOW_PLUGIN_DIR')) {
                define('MM_SOW_PLUGIN_DIR', plugin_dir_path(__FILE__));
            }

            // Plugin Folder URL
            if (!defined('MM_SOW_PLUGIN_URL')) {
                define('MM_SOW_PLUGIN_URL', plugin_dir_url(__FILE__));
            }

            // Plugin Root File
            if (!defined('MM_SOW_PLUGIN_FILE')) {
                define('MM_SOW_PLUGIN_FILE', __FILE__);
            }

            // Plugin Help Page URL
            if (!defined('MM_SOW_PLUGIN_HELP_URL')) {
                define('MM_SOW_PLUGIN_HELP_URL', admin_url() . 'admin.php?page=micemade_so_widgets_documentation');
            }


            $this->activation_checks();
			
            $this->setup_debug_constants();
        }
		
		
		public function mm_sow_inline_css() {
			
			remove_action('wp_footer', 'siteorigin_panels_print_inline_css');
			
			add_action( 'wp_footer', array(self::$instance, 'generate_inline_style') );
		}
		
		public function generate_inline_style() {
			
			global $siteorigin_panels_inline_css;
			
			if( empty( $siteorigin_panels_inline_css ) ) return;
			
			$inline_css = $inline_css_id = '';
			
			foreach( $siteorigin_panels_inline_css as $post_id => $css ) {
				if( empty($css) ) continue;
				
				$inline_css		.= $css;
				$inline_css_id	.= $post_id;
				
				$siteorigin_panels_inline_css[$post_id] = '';
			}
			
			if( $inline_css ) {
				$uploads = wp_upload_dir();
				$mm_sow_uploads_dir	= trailingslashit( $uploads['basedir'] ) . 'micemade_so_widgets'; // "wp-content/uploads" DIR
				$mm_sow_uploads_url	= trailingslashit( $uploads['baseurl']) . 'micemade_so_widgets'; // "wp-content/uploads" URL
				
				global $wp_filesystem;
				if ( empty( $wp_filesystem ) ) {
					require_once ( ABSPATH . '/wp-admin/includes/file.php' );
					WP_Filesystem();
				}
				
				$target_dir = $wp_filesystem->is_dir( $mm_sow_uploads_dir );
				if( !$target_dir ) {
					wp_mkdir_p( $mm_sow_uploads_dir );
				}
				
				$mm_sow_uploads_dir_exists = is_dir( $mm_sow_uploads_dir );
				// TO DO: reduce file writing for cases when not needed
				// $file_exists	= file_exists( $mm_sow_uploads_dir . '/inline-styles-'.esc_attr( $inline_css_id ).'.css' );
				// $is_preview		= ( isset( $_GET['preview'] ) && $_GET['preview'] == "true" ) ? true : false;

				
				if( $mm_sow_uploads_dir_exists  ) {
					// create files in wp-content/uploads dir
					$wp_filesystem->put_contents( $mm_sow_uploads_dir . '/inline-styles-'.esc_attr( $inline_css_id ).'.css', $inline_css, 0644 );
					
				}
				
				echo '<link rel="stylesheet" id="mm_sow_inline_css-'.esc_attr($inline_css_id).'" href="'.esc_url( $mm_sow_uploads_url . '/inline-styles-'.esc_attr( $inline_css_id ).'.css' ).'" type="text/css" media="all">';
				
			}
						
		}

        /**
         * Throw error on object clone
         *
         * The whole idea of the singleton design pattern is that there is a single
         * object therefore, we don't want the object to be cloned.
         */
        public function __clone() {
            // Cloning instances of the class is forbidden
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'mm_sow'), '1.6');
        }

        /**
         * Disable unserializing of the class
         *
         */
        public function __wakeup() {
            // Unserializing instances of the class is forbidden
            _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'mm_sow'), '1.6');
        }        

        private function setup_debug_constants() {

            $enable_debug = false;

            $settings = get_option('mm_sow_settings');

            if ($settings && isset($settings['mm_sow_enable_debug']) && $settings['mm_sow_enable_debug'] == "true")
                $enable_debug = true;

            // Enable script debugging
            if (!defined('MM_SOW_SCRIPT_DEBUG')) {
                define('MM_SOW_SCRIPT_DEBUG', $enable_debug);
            }

            // Minified JS file name prefix - adds prefix to access "lib" folder with unminified js files for debugging
            if (!defined('MM_SOW_JS_PREFIX')) {
                if ($enable_debug)
                    define('MM_SOW_JS_PREFIX', 'lib/');
                else
                    define('MM_SOW_JS_PREFIX', '');
            }
			
            // Minified JS file name suffix - adds ".min" suffix (before ".js") to enqueue minified files
            if (!defined('MM_SOW_JS_SUFFIX')) {
                if ($enable_debug)
                    define('MM_SOW_JS_SUFFIX', '');
                else
                    define('MM_SOW_JS_SUFFIX', '.min');
            }
			
        }

        /**
         * Include required files
         *
         */
        private function includes() {

            require_once MM_SOW_PLUGIN_DIR . 'includes/class-mm_sow-setup.php';
            require_once MM_SOW_PLUGIN_DIR . 'includes/helper-functions.php';
            require_once MM_SOW_PLUGIN_DIR . 'includes/wc-functions.php';
            require_once MM_SOW_PLUGIN_DIR . 'includes/ajax-functions.php';
            require_once MM_SOW_PLUGIN_DIR . 'includes/animations.php';

            if (is_admin()) {
                require_once MM_SOW_PLUGIN_DIR . 'admin/admin-init.php';
            }

        }

        /**
         * Load Plugin Text Domain
         *
         * Looks for the plugin translation files in certain directories and loads
         * them to allow the plugin to be localised
         */
        public function load_plugin_textdomain() {
						
			$lang_dir = apply_filters('mm_sow_so_widgets_lang_dir', trailingslashit(MM_SOW_PLUGIN_DIR . 'languages'));

            // Traditional WordPress plugin locale filter
            $locale = apply_filters('plugin_locale', get_locale(), 'mm_sow');
            $mofile = sprintf('%1$s-%2$s.mo', 'mm_sow', $locale);

            // Setup paths to current locale file
            $mofile_local = $lang_dir . $mofile;

            if (file_exists($mofile_local)) {
                // Look in the /wp-content/plugins/micemade-so-widgets/languages/ folder
                load_textdomain('mm_sow', $mofile_local);
            }
            else {
                // Load the default language files
                load_plugin_textdomain('mm_sow', false, $lang_dir);
            }

            return false;
        }

        /**
         * Setup the default hooks and actions
         */
        private function hooks() {

            add_action('wp_enqueue_scripts', array($this, 'load_frontend_scripts'), 10);
        }

        /**
         * Load Frontend Scripts/Styles
         *
         */
        public function load_frontend_scripts() {

            // Use minified libraries if MM_SOW_SCRIPT_DEBUG is turned off
            $suffix = (defined('MM_SOW_SCRIPT_DEBUG') && MM_SOW_SCRIPT_DEBUG) ? '' : '.min';
            $prefix = (defined('MM_SOW_SCRIPT_DEBUG') && MM_SOW_SCRIPT_DEBUG) ? 'lib/' : '';

            wp_register_style('mm_sow-frontend-styles', MM_SOW_PLUGIN_URL . 'assets/css/mm_sow-frontend.css', array(), MM_SOW_VERSION);
            wp_enqueue_style('mm_sow-frontend-styles');

            wp_register_style('mm_sow-fontawesome-styles', MM_SOW_PLUGIN_URL . 'assets/css/font-awesome.min.css', array(), MM_SOW_VERSION);
            wp_enqueue_style('mm_sow-fontawesome-styles');

            wp_register_script('mm_sow-modernizr', MM_SOW_PLUGIN_URL . 'assets/js/'.$prefix.'modernizr-custom' . $suffix . '.js', array(), MM_SOW_VERSION, true);
            wp_enqueue_script('mm_sow-modernizr');

            wp_register_script('mm_sow-waypoints', MM_SOW_PLUGIN_URL . 'assets/js/'.$prefix.'jquery.waypoints' . $suffix . '.js', array('jquery'), MM_SOW_VERSION, true);
            wp_enqueue_script('mm_sow-waypoints');

            wp_register_script('mm_sow-imagesloaded', MM_SOW_PLUGIN_URL . 'assets/js/'.$prefix.'imagesloaded.pkgd' . $suffix . '.js', array('jquery'), MM_SOW_VERSION, true);
            wp_enqueue_script('mm_sow-imagesloaded');
			
            wp_register_script('mm_sow-frontend-scripts', MM_SOW_PLUGIN_URL . 'assets/js/'.$prefix.'mm_sow-frontend' . $suffix . '.js', array('jquery'), MM_SOW_VERSION, true);
            wp_enqueue_script('mm_sow-frontend-scripts');

			
			
			add_action('wp_enqueue_scripts', array($this, 'localize_scripts'), 999999);

        }

        public function localize_scripts() {

            $panels_mobile_width = 780; // default

            if (function_exists('siteorigin_panels_setting')) {

                $settings = siteorigin_panels_setting();

                $panels_mobile_width = $settings['mobile-width'];

            }

            $custom_css = mm_sow_get_option('mm_sow_custom_css', '');
			
			$to_localize = array(
				'mobile_width'	=> $panels_mobile_width, 
				'custom_css'	=> $custom_css,
				'loading_qv'	=> __( 'Loading quick view','mm_sow' )
				);

            wp_localize_script('mm_sow-frontend-scripts', 'mm_sow_settings', $to_localize );

        }
		private function activation_checks() {
		
			// PLUGINS:
			// if WOOCOMMERCE activated:
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
				define('MM_SOW_WOO_ACTIVE',true );								
			}else{
				define('MM_SOW_WOO_ACTIVE',false );	
			}
			// if YITH WC WISHLIST activated:
			if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
				define('MM_SOW_WISHLIST_ACTIVE',true );
			}else{
				define('MM_SOW_WISHLIST_ACTIVE',false );
			}
			
			// if WPML activated:
			if ( in_array( 'sitepress-multilingual-cms/sitepress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )  {
				define('VC_ASE_WPML_ON',true );										
			}else{
				define('VC_ASE_WPML_ON',false );	
			}
			
		} // activation_checks()
		
		
		public function ajax_url_var() {
			echo '<script type="text/javascript">var mm_sow_ajaxurl = "'. admin_url("admin-ajax.php") .'"</script>';
		}
		
		function updater() {
			
			require_once( plugin_dir_path( __FILE__ ) . 'github_updater.php' );
			if ( is_admin() ) {
				new Micemade_GitHub_Plugin_Updater( __FILE__, 'Micemade', "micemade-so-widgets" );
			}
		}
		
		
    } // end ClASS
	

endif; // End if class_exists check


/**
 * The main function responsible for returning the one true Micemade_SO_widgets
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $mm_sow = MM_SOW(); ?>
 */
function MM_SOW() {
    return Micemade_SO_widgets::instance();
}

// Get MM_SOW Running
MM_SOW();