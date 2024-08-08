<?php
/**
 * Activator Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Sargas\Recaptcha\Config\Initial_Value;

class Activator {

	public function activate() {
		$options        = get_option( 'sargas-recaptcha-options' );
		$plugin_version = $options['version'] ?? null;

		if ( $options ) {
			if ( SARGAS_RECAPTCHA_VERSION > $plugin_version ) {
				$result = array_merge( Initial_Value::DEFAULT_OPTIONS, $options );

				update_option(
					'sargas-recaptcha-options',
					$result
				);
			}
		} else {
			add_option(
				'sargas-recaptcha-options',
				Initial_Value::DEFAULT_OPTIONS
			);
		}
	}

}

