<?php
/**
 * MC4WP_Form Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Forms;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MC4WP_Form extends Recaptcha_Form {

	/**
	 * Add reCAPTCHA block to MC4WP form
	 *
	 * @param string $content MC4WP form
	 *
	 * @return string
	 */
	public function display_recaptcha( string $content ): string {
		$recaptcha = $this->recaptcha_service->display( true );
		$content   = $this->process_mc4wp_form( $content, $recaptcha );

		return $content;
	}

	/**
	 * @param string $subject
	 * @param string $recaptcha
	 *
	 * @return string
	 */
	private function process_mc4wp_form( string $subject, string $recaptcha ): string {
		$search  = '<input type="submit"';
		$replace = $recaptcha . '<input type="submit"';

		$processed_string = str_replace( $search, $replace, $subject );

		return $processed_string;
	}

	/**
	 * Registers an additional MailChimp for WP error message
	 *
	 * @param array $messages
	 *
	 * @return array
	 */
	public function add_error_messages( array $messages ): array {

		$missed_response_error_message = sprintf( '<strong>%1$s</strong>: %2$s',
			esc_html__( 'Error', 'sargas-recaptcha' ),
			esc_html__( 'The reCAPTCHA response is missed. Please try again.', 'sargas-recaptcha' )
		);

		$messages['response_is_failed'] = [
			'type' => 'error',
			'text' => $this->error_message
		];

		$messages['response_is_missed'] = [
			'type' => 'error',
			'text' => $missed_response_error_message
		];

		return $messages;
	}

	public function validate(array $errors): array {
		if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
			if ( true !== $this->recaptcha_service->validate() ) {
				$errors[] = 'response_is_failed';
				return $errors;
			}
		} else {
			$errors[] = 'response_is_missed';
			return $errors;
		}

		return $errors;
	}

	public function register_add_action() {
		add_action( 'mc4wp_form_after_fields', [ $this, 'enqueue_styles' ] );
		add_action( 'mc4wp_form_after_fields', [ $this, 'enqueue_scripts' ] );
	}

	public function register_add_filter() {
		add_filter( 'mc4wp_form_errors', [ $this, 'validate' ], 10, 1 );
		add_filter( 'mc4wp_form_messages', [ $this, 'add_error_messages' ] );
		add_filter( 'mc4wp_form_content', [ $this, 'display_recaptcha' ] );
	}

}