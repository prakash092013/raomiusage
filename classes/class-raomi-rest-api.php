<?php
/**
 * RAOMI REST API Initializer
 *
 * All Rest APIs and WP AJAX hooks for the block.
 *
 * @since   1.0.0
 * @package RAOMI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * RAOMI_REST_API.
 *
 * @package RAOMI
 */
class RAOMI_REST_API {


	/**
	 * Constructor
	 */
	public function __construct() {

		// WP Ajax to fetch remote data
        add_action( 'wp_ajax_raomi_fetch_data', array( $this, 'raomi_fetch_data_callback' ) );
        add_action( 'wp_ajax_nopriv_raomi_fetch_data', array( $this, 'raomi_fetch_data_callback' ) );

        add_action( 'rest_api_init', array( $this, 'raomi_fetch_data_rest_callback' ) );

        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::add_command( 'raomirefresh', array( $this, 'raomi_refresh_data_cli' ) );
        }

	}

    public function raomi_fetch_data_rest_callback(){
        register_rest_route(
            'raomi/v1',
            '/usage',
            array(
                'methods' => 'GET',
                'callback' => array( $this, 'raomi_fetch_data_callback' ),
                'permission_callback' => '__return_true',
            )
        );
    } 

    public function raomi_refresh_data_cli(){

        $response = $this->call_remote_api();
        if( $response['success'] ){
            set_transient( '_raomiusage_data', json_decode($response['data']), HOUR_IN_SECONDS );
            WP_CLI::success( __( 'Data refresh success.', 'raomi' ) );
        } else{
            WP_CLI::error(
                sprintf(
                    __( 'Data refresh failed. %s', 'raomi' ),
                    esc_html($response['msg'])
                )
            );
        }
    }

    public function raomi_fetch_data_callback(){

        // Sanitizing data
        if( isset($_REQUEST['force_refresh']) ){
            $force_refresh = sanitize_text_field($_REQUEST['force_refresh']);
        } else{
            $force_refresh = false;
        }
        
        if( $force_refresh ):
            // verify nonce
            check_ajax_referer( 'raomi_fetch_data_nonce' );
        endif;
        

        // check for the cached data
        $api_data = get_transient( '_raomiusage_data' );

        if( !$api_data || $force_refresh ){
            $response = $this->call_remote_api();
            if( $response['success'] ){
                set_transient( '_raomiusage_data', json_decode($response['data']), HOUR_IN_SECONDS );
            } else{
                wp_send_json_error( $response['msg'] );
            }
            
        }

        if( $force_refresh ) {
                wp_send_json_success(
                    sprintf(
                        __( 'Data refreshed successfully. <a href="%s">Reload</a> to view the changes.', 'raomi' ),
                        esc_url( menu_page_url('rao-miusage-data-refresh') )
                    )
                );
        } else{
            // Gutenberg Block Response
            $response = get_transient( '_raomiusage_data' );
            $response_array = (array) $response->data->rows;
            $response_array = array_values($response_array);
            wp_send_json_success( $response_array );
        }
        
    
    }

    public function call_remote_api(){

        // Fetch from Remote API
        $response = wp_remote_get( 'https://miusage.com/v1/challenge/1/' );

        if ( is_array( $response ) && ! is_wp_error( $response ) ) {
            return array(
                'success' => true,
                'data' => wp_remote_retrieve_body( $response ),
                'msg' => ''
            );
        } else{
            return array(
                'success' => false,
                'data' => [],
                'msg' => $response->get_error_message()
            );
        }
        
    }
	
}

/**
 *  Initiate call to Class constructor
 */
new RAOMI_REST_API;
