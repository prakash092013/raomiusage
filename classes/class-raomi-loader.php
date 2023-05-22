<?php
/**
 * RAOMI Loader.
 *
 * @package RAOMI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'RAOMI_Loader' ) ) {

	/**
	 * Class RAOMI_Loader.
	 */
	final class RAOMI_Loader {

		/**
		 * Member Variable
		 *
		 * @var instance
		 */
		private static $instance;

		/**
		 *  Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
            }
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {

			$this->define_constants();
            
            add_action( 'plugins_loaded', array( $this, 'load_plugin' ) );
        }

		/**
		 * Defines all constants
		 *
		 * @since 0.1.0
		 */
		public function define_constants() {
			define( 'RAOMI_BASE', plugin_basename( RAOMI_FILE ) );
			define( 'RAOMI_DIR', plugin_dir_path( RAOMI_FILE ) );
			define( 'RAOMI_URL', plugins_url( '/', RAOMI_FILE ) );
			define( 'RAOMI_VER', '0.1.0' );
			define( 'RAOMI_SLUG', 'raomi' );
			
            if ( ! defined( 'RAOMI_UPLOAD_DIR_NAME' ) ) {
				define( 'RAOMI_UPLOAD_DIR_NAME', 'raomi-plugin' );
			}

			$upload_dir = wp_upload_dir( null, false );

			if ( ! defined( 'RAOMI_UPLOAD_DIR' ) ) {
				define( 'RAOMI_UPLOAD_DIR', $upload_dir['basedir'] . '/' . RAOMI_UPLOAD_DIR_NAME . '/' );
			}

			if ( ! defined( 'RAOMI_UPLOAD_URL' ) ) {
				define( 'RAOMI_UPLOAD_URL', $upload_dir['baseurl'] . '/' . RAOMI_UPLOAD_DIR_NAME . '/' );
			}

		}

		/**
		 * Loads plugin files.
		 *
		 * @since 0.1.0
		 *
		 * @return void
		 */
		public function load_plugin() {
            
            // load textdomain
			$this->load_textdomain();
            
            require_once RAOMI_DIR . 'classes/class-raomi-init-blocks.php';
			require_once RAOMI_DIR . 'classes/class-raomi-rest-api.php';
            require_once RAOMI_DIR . 'classes/class-raomi-admin.php';
        
		}

		/**
		 * Load RAOMI Text Domain.
		 * This will load the translation textdomain depending on the file priorities.
		 *      1. Global Languages /wp-content/languages/prakash-miusage/ folder
		 *      2. Local directory /wp-content/plugins/prakash-miusage/languages/ folder
		 *
		 * @since  0.1.0
		 * @return void
		 */
		public function load_textdomain() {

			/**
			 * Filters the languages directory path to use for RAOMI.
			 *
			 * @param string $lang_dir The languages directory path.
			 */
			$lang_dir = apply_filters( 'raomi_languages_directory', RAOMI_ROOT . '/languages/' );

			load_plugin_textdomain( 'raomi', false, $lang_dir );
		}
    }
}

/**
 *  Prepare if class 'RAOMI_Loader' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
RAOMI_Loader::get_instance();

/**
 * Load main object
 *
 * @since 0.1.0
 *
 * @return object
 */
function raomi() {
	return RAOMI_Loader::get_instance();
}