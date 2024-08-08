<?php
/**
 * Lost_Password_Form Class File
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

class Lost_Password_Form extends Recaptcha_Form {

	/**
	 * @param WP_Error $errors
	 *
	 * @return void
	 */
	public function validate( WP_Error $errors ) {
		if ( ! isset( $_POST['wc_reset_password'] ) ) {
			if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
				if ( true !== $this->recaptcha_service->validate() ) {
					$errors->add( 'sargas_recaptcha_error', $this->error_message );
				}
			} else {
				$errors->add( 'sargas_recaptcha_error', $this->error_message );
			}
		}
	}

	public function register_add_action() {
		add_action( 'lostpassword_post', [ $this, 'validate' ], 20 );
		add_action( 'lostpassword_form', [ $this, 'display' ] );

		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

	public function register_add_filter() {
		//
	}

}