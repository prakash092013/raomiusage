<?php
/**
 * Plugin Name:       Prakash Rao
 * Description:       A simple plugin to fetch data from remote API and show in block editor.
 * Requires at least: 5.6
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Prakash Rao
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       raomi
 */

define( 'RAOMI_FILE', __FILE__ );
define( 'RAOMI_ROOT', dirname( plugin_basename( RAOMI_FILE ) ) );
define( 'RAOMI_PLUGIN_NAME', 'RAOMI' );
define( 'RAOMI_PLUGIN_SHORT_NAME', 'RAOMI' );

if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
	add_action( 'admin_notices', 'raomi_fail_php_version' );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {
	add_action( 'admin_notices', 'raomi_fail_wp_version' );
} else {
	require_once 'classes/class-raomi-loader.php';
}

/**
 * RAOMI admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 0.1.0
 *
 * @return void
 */
function raomi_fail_php_version() {
	/* translators: %s: PHP version */
	$message      = sprintf( esc_html__( 'RAOMI requires PHP version %s+, plugin is currently NOT RUNNING.', 'raomi' ), '5.6' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}


/**
 * RAOMI admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since 0.1.0
 *
 * @return void
 */
function raomi_fail_wp_version() {
	/* translators: %s: WordPress version */
	$message      = sprintf( esc_html__( 'RAOMI requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'raomi' ), '4.7' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}