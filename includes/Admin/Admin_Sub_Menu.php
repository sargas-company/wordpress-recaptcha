<?php
/**
 * Admin_Sub_Menu Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Admin;

use Sargas\Recaptcha\Abstracts\Admin_Sub_Menu as Admin_Menu_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin_Sub_Menu extends Admin_Menu_Interface {

	public function render_sub_menu_panel() {
		include_once SARGAS_RECAPTCHA_TPL_ADMIN . 'options-page/main-option-page.php';
	}

}
