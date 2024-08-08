<?php
/**
 * WooCommerce Login_Form Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Forms\Woocommerce;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;
use Sargas\Recaptcha\Services\Recaptcha as Recaptcha_Service;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Login_Form extends Recaptcha_Form {

	public function __construct(Recaptcha_Service $recaptcha_service) {
		parent::__construct( $recaptcha_service );
		$this->error_message = esc_html__( 'Invalid reCAPTCHA. Please try again.', 'sargas-recaptcha' );

	}

	/**
	 * @param WP_Error $errors
	 *
	 * @return WP_Error
	 */
	public function validate( WP_Error $errors ): WP_Error {
		if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
			if ( true !== $this->recaptcha_service->validate() ) {
				$errors->add( 'sargas_recaptcha_error', $this->error_message );
			}
		} else {
			$errors->add( 'sargas_recaptcha_error', $this->error_message );
		}

		return $errors;
	}

	public function register_add_action() {
		add_action( 'woocommerce_login_form', [ $this, 'display' ] );

		add_action( 'woocommerce_before_customer_login_form', [ $this, 'enqueue_styles' ] );
		add_action( 'woocommerce_after_customer_login_form', [ $this, 'enqueue_scripts' ] );
	}

	public function register_add_filter() {
		add_filter( 'woocommerce_process_login_errors', [ $this, 'validate' ], 20 );
	}

}