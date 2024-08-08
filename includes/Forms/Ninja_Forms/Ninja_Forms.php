<?php
/**
 * Ninja_Forms Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.2
 */

namespace Sargas\Recaptcha\Forms\Ninja_Forms;

use Sargas\Recaptcha\Abstracts\Recaptcha_Form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ninja_Forms extends Recaptcha_Form {

	public function register_fields( $fields ) {
		$fields['sargas_recaptcha'] = new Ninja_Forms_Custom_Field( $this->recaptcha_service );

		return $fields;
	}

	public function register_add_action() {
		add_action( 'ninja_forms_before_form_display', [ $this, 'enqueue_styles' ] );
		add_action( 'ninja_forms_before_form_display', [ $this, 'enqueue_scripts' ] );
	}

	public function enqueue_scripts() {
		parent::enqueue_scripts();

		wp_enqueue_script(
			'sargas-recaptcha-public-nf',
			SARGAS_RECAPTCHA_PUBLIC_JS_SRC . 'sargas-recaptcha-public-nf.js',
			[ 'nf-front-end', 'sargas-recaptcha-public-script' ],
			SARGAS_RECAPTCHA_VERSION
		);
	}

	public function enqueue_styles() {
		$this->recaptcha_service->enqueue_styles();
	}

	public function register_add_filter() {
		add_filter( 'ninja_forms_register_fields', [ $this, 'register_fields' ] );
	}
}