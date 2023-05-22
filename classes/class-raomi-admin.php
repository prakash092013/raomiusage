<?php
/**
 * RAOMI ADMIN Initializer
 *
 * All Admin pages defined here.
 *
 * @since   1.0.0
 * @package RAOMI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * RAOMI_ADMIN.
 *
 * @package RAOMI
 */
class RAOMI_ADMIN {

    /**
	 * Constructor
	 */
	public function __construct() {

        // admin menu pages
        add_action( 'admin_menu', array( $this, 'raomiusage_init_menu' ) );
        
        // admin enqueue scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'raomiusage_admin_enqueue_scripts' ), 10, 1 );

    }

    public function raomiusage_init_menu() {
        add_menu_page(
            __( 'RAO Miusage Settings', 'raomi'),
            __( 'RAO Miusage Settings', 'raomi'),
            'manage_options',
            'rao-miusage-data-refresh',
            array( $this, 'raomiusage_admin_page' ),
            'dashicons-admin-post',
            '2.1'
        );
    }

    public function raomiusage_admin_page() {
        require_once RAOMI_DIR . 'templates/admin-display.php';
    }

    

    public function raomiusage_admin_enqueue_scripts( $hook ) {
        
        if( $hook != "toplevel_page_rao-miusage-data-refresh" ) return;

        wp_enqueue_style( 'raomiusage-style', RAOMI_URL . 'assets/raomi.css' );
        wp_enqueue_script( 'raomiusage-script', RAOMI_URL . 'assets/raomi.js', array( 'jquery' ), RAOMI_VER, true );

        wp_localize_script(
			'raomiusage-script',
			'raomi',
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'siteurl' => site_url(),
			)
		);
    }

    
}

/**
 *  Initiate call to Class constructor
 */
new RAOMI_ADMIN;
