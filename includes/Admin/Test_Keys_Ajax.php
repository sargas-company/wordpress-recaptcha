<?php
/**
 * Test_Keys_Ajax Handler
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.2
 */

namespace Sargas\Recaptcha\Admin;

use Sargas\Recaptcha\Abstracts\Ajax;
use Sargas\Recaptcha\Traits\Utility;
use Sargas\Recaptcha\Services\Recaptcha;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Test_Keys_Ajax extends Ajax {

	use Utility;

	private Recaptcha $recaptcha;

	private array $options;

	public function __construct( string $action, Recaptcha $recaptcha ) {
		parent::__construct( $action );

		$this->recaptcha = $recaptcha;
		$this->options   = get_option( 'sargas-recaptcha-options' );
	}

	public function handle() {
		check_ajax_referer( 'sargas_recaptcha_ajax_nonce', '_sargas_nonce' );

		if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
			if ( true !== $this->recaptcha->validate() ) {
				$this->send_error(
					new WP_Error( 'sargas_recaptcha_error', __( 'Error', 'sargas-recaptcha' ) . ' : ' . __( 'Invalid reCAPTCHA.', 'sargas-recaptcha' ) ),
					400
				);
			}
		} else {
			$this->send_error(
				new WP_Error( 'sargas_recaptcha_error', __( 'Error', 'sargas-recaptcha' ) . ' : ' . __( 'Missed reCAPTCHA response.', 'sargas-recaptcha' ) ),
				400
			);
		}

		wp_send_json( __( 'reCAPTCHA works correctly.', 'sargas-recaptcha' ) );

		exit();
	}

	public function register_script() {

		//Enqueue script for plugin settings page
		if ( 'toplevel_page_' . SARGAS_RECAPTCHA_NAME === get_current_screen()->base ) {
			wp_enqueue_script(
				'sargas-recaptcha-api',
				$this->recaptcha->get_api_url(),
				[],
				SARGAS_RECAPTCHA_VERSION,
				true
			);

			wp_enqueue_script(
				SARGAS_RECAPTCHA_NAME . '-admin-test-keys',
				SARGAS_RECAPTCHA_ADMIN_JS_SRC . 'sargas-recaptcha-admin-test-keys.js',
				array( 'jquery', 'sargas-recaptcha-api' ),
				SARGAS_RECAPTCHA_VERSION,
				true
			);

			wp_localize_script(
				SARGAS_RECAPTCHA_NAME . '-admin-test-keys',
				'sargasTestKeysData',
				$this->ajax_data()
			);
		}
	}

	public function ajax_data(): array {
		$data = array(
			'ajax_url'     => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'   => wp_create_nonce( 'sargas_recaptcha_ajax_nonce' ),
			'type'         => esc_attr( $this->options['recaptcha_type'] ),
			'siteKey'      => esc_attr( $this->options['site_key'] ),
			'translations' => [
				'successfully_displayed' => esc_html__( 'reCAPTCHA is displayed correctly.', 'sargas-recaptcha' ),
				'keys_type_error'        => esc_html__( 'Incorrect reCAPTCHA keys type.', 'sargas-recaptcha' ),
				'verification_failed'    => esc_html__( 'reCAPTCHA keys verification failed', 'sargas-recaptcha' )
			]
		);

		return $data;
	}
}