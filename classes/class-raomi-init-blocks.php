<?php
/**
 * RAOMI Blocks Initializer
 *
 * Register block here.
 *
 * @since   1.0.0
 * @package RAOMI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * RAOMI_Init_Blocks.
 *
 * @package RAOMI
 */
class RAOMI_Init_Blocks {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'raomi_register_block' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'raomi_register_block_assets' ) );
	}

	public function raomi_register_block_assets(){
		
		// Register block styles for both frontend + backend.
		wp_register_style(
			'raomi-block-style',
			RAOMI_URL . 'build/index.css',
			is_admin() ? array( 'wp-editor' ) : null,
			RAOMI_VER 
		);

		// Register block editor script for backend.
		wp_register_script(
			'raomi-block-editor-script',
			RAOMI_URL . 'build/index.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
			RAOMI_VER,
			true
		);

		// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
		wp_localize_script(
			'raomi-block-editor-script',
			'raomi', // Array containing dynamic data for a JS Global.
			[
				'plugin_path' => RAOMI_DIR,
				'plugin_url'  => RAOMI_URL,
				'nonce' => wp_create_nonce( 'raomi_fetch_data_nonce' ),
				'date_format' => get_option('date_format')
			]
		);

	}

	public function raomi_register_block(){
		register_block_type( 'raomi/demotable', [
			'render_callback' => array( $this, 'raomi_demotable_render' ),
			'attributes'      => [
				'hideId' => [ 'type'    => 'boolean' ],
				'hideFirstName' => [ 'type'    => 'boolean' ],
				'hideLastName' => [ 'type'    => 'boolean' ],
				'hideEmail' => [ 'type'    => 'boolean' ],
				'hideDate' => [ 'type'    => 'boolean' ],
			],
			'editor_script'   => 'raomi-block-editor-script',
			'style'           => 'raomi-block-style',
		] );
	}

	// Dynamic block rendering
	public function raomi_demotable_render( $block_attributes, $content ) {

		// get data response from server
		$response = get_transient( '_raomiusage_data' );
		$response_array = (array) $response->data->rows;
		$rows = array_values($response_array);

		$hide_id = isset($block_attributes['hideId']) ? $block_attributes['hideId'] : false;
		$hide_fname = isset($block_attributes['hideFirstName']) ? $block_attributes['hideFirstName'] : false;
		$hide_lname = isset($block_attributes['hideLastName']) ? $block_attributes['hideLastName'] : false;
		$hide_email = isset($block_attributes['hideEmail']) ? $block_attributes['hideEmail'] : false;
		$hide_date = isset($block_attributes['hideDate']) ? $block_attributes['hihideDatedeId'] : false;
		$class_name = isset($block_attributes['className']) ? $block_attributes['className'] : '';
		
		ob_start();
		?>
		<div class="<?php echo esc_attr($class_name); ?>">
			<div class='raomi-table'>
				<table cellPadding="5" cellSpacing="10">
					<tr>
						<?php if( !$hide_id ) printf( '<td><strong>%s</strong></td>', __( 'ID', 'raomi' ) );?>
						<?php if( !$hide_fname ) printf( '<td><strong>%s</strong></td>', __( 'First Name', 'raomi' ) );?>
						<?php if( !$hide_lname ) printf( '<td><strong>%s</strong></td>', __( 'Last Name', 'raomi' ) );?>
						<?php if( !$hide_email ) printf( '<td><strong>%s</strong></td>', __( 'Email', 'raomi' ) );?>
						<?php if( !$hide_date ) printf( '<td><strong>%s</strong></td>', __( 'Date', 'raomi' ) );?>
					</tr>
					<?php 
					// setting date format
					$date_format = get_option('date_format');
					foreach ($rows as $index => $row) :
						printf( '<tr>' );
						if( !$hide_id ) printf( '<td>%s</td>', esc_html($row->id) );
						if( !$hide_fname ) printf( '<td>%s</td>', esc_html($row->fname) );
						if( !$hide_lname ) printf( '<td>%s</td>', esc_html($row->lname) );
						if( !$hide_email ) printf( '<td>%s</td>', esc_html($row->email) );
						if( !$hide_date ) printf( '<td>%s</td>', date( $date_format, esc_html($row->date) ) );
						printf( '</tr>' );
					endforeach;
					?>
				</table>
			</div>
		</div>
		<?php return ob_get_clean();
	}
	
}

/**
 *  Prepare if class 'RAOMI_Init_Blocks' exist.
 *  Kicking this off by calling 'get_instance()' method
 */
new RAOMI_Init_Blocks;
