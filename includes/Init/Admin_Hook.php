<?php
/**
 * Admin_Hook Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Init;

use Sargas\Recaptcha\Interfaces\Action_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin_Hook implements Action_Hook_Interface {

	public function enqueue_styles() {
		wp_enqueue_style(
			SARGAS_RECAPTCHA_NAME . '-admin-style',
			SARGAS_RECAPTCHA_ADMIN_CSS_SRC . 'sargas-recaptcha-admin.css',
			[],
			SARGAS_RECAPTCHA_VERSION
		);

	}

	public function register_add_action() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
	}

}

