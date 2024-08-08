<?php
/**
 * Uninstall Class
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Uninstall;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Uninstall {
	public static function uninstall() {
		if ( get_option( 'sargas-recaptcha-options' ) ) {
			delete_option( 'sargas-recaptcha-options' );
		}
	}
}



