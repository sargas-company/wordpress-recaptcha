<?php
/**
 * Recaptcha_Form Abstract Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Abstracts;

use Sargas\Recaptcha\Services\Recaptcha as Recaptcha_Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Recaptcha_Form {
	/**
	 * @var Recaptcha_Service $recaptcha_service
	 */
	protected Recaptcha_Service $recaptcha_service;

	/**
	 * @var string $error_message
	 */
	public string $error_message;

	/**
	 * @param Recaptcha_Service $recaptcha_service
	 */
	public function __construct( Recaptcha_Service $recaptcha_service ) {
		$this->recaptcha_service = $recaptcha_service;

		$this->error_message = sprintf( '<strong>%1$s</strong>: %2$s',
			esc_html__( 'Error', 'sargas-recaptcha' ),
			esc_html__( 'Invalid reCAPTCHA. Please try again.', 'sargas-recaptcha' )
		);
	}

	public function display() {
		$this->recaptcha_service->display();
	}

	/**
	 * Add reCAPTCHA scripts to form
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		$this->recaptcha_service->enqueue_scripts();
	}

	/**
	 * Add reCAPTCHA styles to form
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		$this->recaptcha_service->enqueue_styles();
	}

	abstract public function register_add_action();

	abstract public function register_add_filter();

}