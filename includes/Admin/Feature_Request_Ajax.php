<?php
/**
 * Feature_Request_Ajax Handler
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.2
 */

namespace Sargas\Recaptcha\Admin;

use JsonException;
use Sargas\Recaptcha\Abstracts\Ajax;
use Sargas\Recaptcha\Traits\Utility;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Feature_Request_Ajax extends Ajax {

	use Utility;

	/**
	 * Max feature request message length
	 */
	public const MAX_MESSAGE_LENGTH = 400;

	public function handle() {
		$this->validate_request();

		$message = stripslashes( sanitize_text_field( $_POST['message'] ) );

		$is_anonymously = isset ( $_POST['isAnonymously'] )
			? filter_var( $_POST['isAnonymously'], FILTER_VALIDATE_BOOLEAN )
			: false;

		$params = array(
			'product' => SARGAS_RECAPTCHA_NAME,
			'token'   => SARGAS_API_TOKEN,
			'message' => $message,
		);

		if ( false === $is_anonymously ) {
			$params['email']          = self::get_current_user_email();
			$params['wp_version']     = $GLOBALS['wp_version'];
			$params['plugin_version'] = SARGAS_RECAPTCHA_VERSION;
		}

		$response = $this->send_request( $params );

		$response_code = (int) wp_remote_retrieve_response_code( $response );

		switch ( $response_code ) {
			case 201:
			case 200:
			case 204:
				wp_send_json( 'Success' );
				break;
			default:
				$this->send_error(
					new WP_Error( 'api-error', esc_html__( 'Error', 'sargas-recaptcha' ) . ': ' . esc_html__( 'Something went wrong. Please, try again later.', 'sargas-recaptcha' ) ),
					400
				);
				break;
		}

		exit();
	}

	private function validate_request() {
		check_ajax_referer( 'sargas_recaptcha_ajax_nonce', '_sargas_nonce' );

		if ( empty( $_POST['message'] ) ) {
			$this->send_error(
				new WP_Error( 'validation-error', esc_html__( 'This field is required.', 'sargas-recaptcha' ) ),
				400
			);
		}

		if ( strlen( (string) $_POST['message'] ) > self::MAX_MESSAGE_LENGTH ) {
			$this->send_error(
				new WP_Error( 'validation-error', esc_html__( 'Maximum message length exceeded.', 'sargas-recaptcha' ) ),
				400
			);
		}
	}

	/**
	 * @return array|WP_Error
	 * @throws JsonException
	 */
	private function send_request( $body ) {
		$request = array(
			'headers' => array(
				'Accept'       => 'application/json',
				'Content-Type' => 'application/json',
			),
			'body'    => json_encode( $body, JSON_THROW_ON_ERROR ),
		);

		$response = wp_remote_post( SARGAS_API_URL . '/feature-request', $request );

		return $response;
	}

	public function register_script() {
		wp_enqueue_script(
			SARGAS_RECAPTCHA_NAME . '-feature-request',
			SARGAS_RECAPTCHA_ADMIN_JS_SRC . 'sargas-recaptcha-feature-request.js',
			array( 'jquery' ),
			SARGAS_RECAPTCHA_VERSION,
			true
		);

		wp_localize_script(
			SARGAS_RECAPTCHA_NAME . '-feature-request',
			'sargasFeatureRequestData',
			$this->ajax_data()
		);
	}

	public function ajax_data(): array {
		$data = array(
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'sargas_recaptcha_ajax_nonce' ),
			'validation' => array(
				'max_length'  => array(
					'value' => esc_attr( self::MAX_MESSAGE_LENGTH ),
					'error' => esc_html__( 'Maximum message length exceeded.', 'sargas-recaptcha' )
				),
				'empty_field' => array(
					'error' => esc_html__( 'This field is required.', 'sargas-recaptcha' )
				)

			)
		);

		return $data;
	}
}