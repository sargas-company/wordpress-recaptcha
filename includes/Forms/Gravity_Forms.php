<?php
/**
 * Gravity_Forms Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.2
 */

namespace Sargas\Recaptcha\Forms;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gravity_Forms extends Recaptcha_Form {
	/**
	 * Adds a recaptcha field to Gravity Forms
	 *
	 * @param string $button
	 *
	 * @return string
	 */
	public function display_recaptcha( string $button ): string {
		$recaptcha = $this->recaptcha_service->display( true );

		return "<div>" . $recaptcha . $button . "</div>";
	}

	/**
	 * Validates recaptcha during form validation
	 *
	 * @param array $validation_result
	 *
	 * @return array
	 */
	public function recaptcha_validate( array $validation_result ): array {
		$form                   = $validation_result['form'];
		$form_pages_count       = $this->get_form_pages_count( $form );
		$current_validated_page = rgpost( 'gform_source_page_number_' . $form['id'] ) ?? 0;

		if ( $form_pages_count <= $current_validated_page ) {
			if ( true === isset( $_POST['g-recaptcha-response'] ) || '' !== $_POST['g-recaptcha-response'] ) {
				if ( true !== $this->recaptcha_service->validate() ) {
					$validation_result['is_valid'] = false;
				}
			}
		}

		return $validation_result;
	}

	/**
	 * Edits the error messages
	 *
	 * @param string $message
	 * @param array $form
	 *
	 * @return string
	 */
	public function display_recaptcha_error( string $message, array $form ): string {
		$custom_captcha_message = "<ol><li><span class='gform_validation_error_link'>$this->error_message</span></li></ol>";
		$is_form_valid          = $this->get_fields_validation_status( $form );

		if ( true === $is_form_valid ) {
			if ( true !== $this->recaptcha_service->validate() ) {
				$message = $message . $custom_captcha_message;

				// (Optional) If validation was fail, adds error message field under the captcha field.
				add_filter( 'gform_submit_button_' . $form['id'], function ( $button ) {
					$recaptcha          = $this->recaptcha_service->display( true );
					$error_message      = strstr( $this->error_message, ' ' );
					$button             = str_replace( $recaptcha, '', $button );
					$button             = str_replace( "<div>", '', str_replace( "</div>", '', $button ) );
					$validation_message = "<div id='validation_message' style='margin: -10px 0 10px 0' class='validation_message'>$error_message</div>";

					return "<div>" . $recaptcha . $validation_message . $button . "</div>";
				} );

			}
		}

		return $message;
	}

	/**
	 * Checks the validation of form fields
	 *
	 * @param array $form
	 *
	 * @return bool
	 */
	public function get_fields_validation_status( array $form ): bool {
		$validation_status = true;

		foreach ( $form['fields'] as $field ) {
			if ( true === $field->failed_validation ) {
				$validation_status = false;
				break;
			}
		}

		return $validation_status;
	}


	/**
	 * Gets a count of pages in form
	 *
	 * @param array $form
	 *
	 * @return int
	 */
	public function get_form_pages_count( array $form ): int {
		$form_pages_count = 1;

		foreach ( $form['fields'] as $field ) {
			if ( $field->pageNumber > $form_pages_count ) {
				$form_pages_count = $field->pageNumber;
			}
		}

		return $form_pages_count;
	}

	public function register_add_action() {
		add_action( 'gform_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'gform_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

    public function enqueue_scripts() {

        parent::enqueue_scripts();

        wp_enqueue_script(
            'sargas-recaptcha-public-gf-script',
            SARGAS_RECAPTCHA_PUBLIC_JS_SRC . 'sargas-recaptcha-public-gf.js',
            ['sargas-recaptcha-public-script'],
            SARGAS_RECAPTCHA_VERSION,
            true
        );
    }

	public function register_add_filter() {
		add_filter( 'gform_submit_button', [ $this, 'display_recaptcha' ] );
		add_filter( 'gform_validation', [ $this, 'recaptcha_validate' ], 10, 2 );
		add_filter( 'gform_validation_message', [ $this, 'display_recaptcha_error' ], 10, 2 );
	}

}