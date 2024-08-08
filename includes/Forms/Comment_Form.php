<?php
/**
 * Comment_Form Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Forms;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Comment_Form extends Recaptcha_Form {

	/**
	 * @param array $commentdata
	 *
	 * @return array
	 */
	public function validate( array $commentdata ): array {
		//Disable reCAPTCHA for logged users
		if ( absint( $commentdata['user_ID'] ) > 0 ) {
			return $commentdata;
		}

		if ( isset( $_POST['g-recaptcha-response'] ) || $_POST['g-recaptcha-response'] !== '' ) {
			if ( true !== $this->recaptcha_service->validate() ) {
				wp_die(
					$this->error_message,
					esc_html__( 'reCAPTCHA error', 'sargas-recaptcha' ),
					[ 'response' => 403, 'back_link' => 1 ]
				);
			}
		} else {
			wp_die(
				$this->error_message,
				esc_html__( 'reCAPTCHA error', 'sargas-recaptcha' ),
				[ 'response' => 403, 'back_link' => 1 ]
			);
		}

		return $commentdata;
	}

	public function register_add_action() {
		add_action( 'comment_form_after_fields', [ $this, 'display' ] );

		add_action( 'comment_form_before', [ $this, 'enqueue_styles' ] );
		add_action( 'comment_form_before', [ $this, 'enqueue_scripts' ] );
	}

	public function register_add_filter() {
		add_filter( 'preprocess_comment', [ $this, 'validate' ] );
	}
}