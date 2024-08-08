<?php
/**
 * Admin_Notice abstract Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Abstracts;

use Sargas\Recaptcha\Interfaces\Action_Hook_Interface;
use Sargas\Recaptcha\Traits\Utility;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Admin_Notice implements Action_Hook_Interface {

	use Utility;

	public function register_add_action() {
		add_action( 'admin_notices', [ $this, 'show_admin_notice' ] );
	}

	abstract public function show_admin_notice();

}
