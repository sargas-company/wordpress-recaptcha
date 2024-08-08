<?php
/**
 * Login_Form Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Forms;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;
use WP_Error;
use WP_User;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Login_Form extends Recaptcha_Form {

	/**
	 * @param $user WP_User|WP_Error
	 *
	 * @return WP_User|WP_Error
	 */
	public function validate( $user ) {
		//Check if this is a WP Login Page
		if ( isset( $_POST['log'] ) ) {
			if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
				if ( true !== $this->recaptcha_service->validate() ) {
					$user = new WP_Error(
						'sargas_recaptcha_error',
						$this->error_message
					);
				}
			} else {
				$user = new WP_Error(
					'sargas_recaptcha_error',
					$this->error_message
				);
			}
		}

		return $user;
	}

	public function register_add_action() {
		add_action( 'login_form', [ $this, 'display' ] );

		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

	public function register_add_filter() {
		add_filter( 'wp_authenticate_user', [ $this, 'validate' ] );
	}

}