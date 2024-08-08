<?php

/**
 * Init_Functions Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Init;

use Sargas\Recaptcha\Interfaces\Action_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Init_Functions implements Action_Hook_Interface {

	public function app_output_buffer() {
		ob_start();
	}

	public function register_add_action() {
		add_action( 'init', [ $this, 'app_output_buffer' ] );
	}
}
