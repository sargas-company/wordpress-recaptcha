<?php
/**
 * Register_Form Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Forms;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Register_Form extends Recaptcha_Form {

	/**
	 * @param WP_Error $errors
	 *
	 * @return WP_Error
	 */
	public function validate( WP_Error $errors ): WP_Error {
		if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
			if ( true !== $this->recaptcha_service->validate() ) {
				$errors = new WP_Error(
					'sargas_recaptcha_error',
					$this->error_message
				);
			}
		} else {
			$errors = new WP_Error(
				'sargas_recaptcha_error',
				$this->error_message
			);
		}

		return $errors;
	}

	public function register_add_action() {
		add_action( 'register_form', [ $this, 'display' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

	public function register_add_filter() {
		add_filter( 'registration_errors', [ $this, 'validate' ] );
	}

}