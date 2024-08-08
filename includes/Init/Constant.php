<?php
/**
 * Constant Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Constant {

	public static function define_constant() {
		if ( ! defined( 'SARGAS_GOOGLE_RECAPTCHA_API_URL' ) ) {
			define( 'SARGAS_GOOGLE_RECAPTCHA_API_URL', 'https://www.google.com/recaptcha/api.js' );
		}

		if ( ! defined( 'SARGAS_API_URL' ) ) {
			define( 'SARGAS_API_URL', 'https://sargas.io/api' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_PATH' ) ) {
			define( 'SARGAS_RECAPTCHA_PATH', trailingslashit( plugin_dir_path( dirname( __FILE__, 2 ) ) ) );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_URL' ) ) {
			define( 'SARGAS_RECAPTCHA_URL', trailingslashit( plugin_dir_url( dirname( __FILE__, 2 ) ) ) );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_PUBLIC_CSS_SRC' ) ) {
			define( 'SARGAS_RECAPTCHA_PUBLIC_CSS_SRC', trailingslashit( SARGAS_RECAPTCHA_URL ) . 'assets/css/' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_PUBLIC_JS_SRC' ) ) {
			define( 'SARGAS_RECAPTCHA_PUBLIC_JS_SRC', trailingslashit( SARGAS_RECAPTCHA_URL ) . 'assets/js/' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_ADMIN_CSS_SRC' ) ) {
			define( 'SARGAS_RECAPTCHA_ADMIN_CSS_SRC', trailingslashit( SARGAS_RECAPTCHA_URL ) . 'assets/admin/css/' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_ADMIN_JS_SRC' ) ) {
			define( 'SARGAS_RECAPTCHA_ADMIN_JS_SRC', trailingslashit( SARGAS_RECAPTCHA_URL ) . 'assets/admin/js/' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_ADMIN_IMG_SRC' ) ) {
			define( 'SARGAS_RECAPTCHA_ADMIN_IMG_SRC', trailingslashit( SARGAS_RECAPTCHA_URL ) . 'assets/admin/images/' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_TPL' ) ) {
			define( 'SARGAS_RECAPTCHA_TPL', trailingslashit( SARGAS_RECAPTCHA_PATH . 'templates' ) );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_LANG_SRC' ) ) {
			define( 'SARGAS_RECAPTCHA_LANG_SRC', 'sargas-recaptcha/languages/' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_TPL_ADMIN' ) ) {
			define( 'SARGAS_RECAPTCHA_TPL_ADMIN', trailingslashit( SARGAS_RECAPTCHA_TPL . 'admin' ) );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_VERSION' ) ) {
			define( 'SARGAS_RECAPTCHA_VERSION', '1.0.2' );
		}

		if ( ! defined( 'SARGAS_RECAPTCHA_NAME' ) ) {
			define( 'SARGAS_RECAPTCHA_NAME', 'sargas-recaptcha' );
		}

		if ( ! defined( 'SARGAS_API_TOKEN' ) ) {
			define( 'SARGAS_API_TOKEN', '$2y$10$Y1BMcLnMJZssMfqHnl/yyOmlPWoawpKrZJVHCrjNnD9i9agi6lXMW' );
		}
	}

}
