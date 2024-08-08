<?php
/**
 * Action_Hook_Interface interface File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Action_Hook_Interface {
	public function register_add_action();
}