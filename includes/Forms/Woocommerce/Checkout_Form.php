<?php
/**
 * WooCommerce Checkout_Form Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Forms\Woocommerce;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;
use Sargas\Recaptcha\Services\Recaptcha as Recaptcha_Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Checkout_Form extends Recaptcha_Form {

	public function __construct(Recaptcha_Service $recaptcha_service) {
		parent::__construct( $recaptcha_service );
		$this->error_message = esc_html__( 'Invalid reCAPTCHA. Please try again.', 'sargas-recaptcha' );

	}

	public function validate() {
		if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
			if ( true !== $this->recaptcha_service->validate() ) {
				wc_add_notice( $this->error_message, 'error' );
			}
		} else {
			wc_add_notice( $this->error_message, 'error' );
		}
	}

	public function register_add_action() {
		add_action( 'woocommerce_review_order_before_payment', [ $this, 'display' ] );
		add_action( 'woocommerce_checkout_process', [ $this, 'validate' ] );

		add_action( 'woocommerce_after_checkout_form', [ $this, 'enqueue_scripts' ] );
		add_action( 'woocommerce_before_checkout_form', [ $this, 'enqueue_styles' ] );
	}

	public function register_add_filter() {
		//
	}

}