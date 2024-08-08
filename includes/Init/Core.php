<?php
/**
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Init;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Sargas\Recaptcha\Abstracts\{Admin_Menu, Admin_Notice, Admin_Sub_Menu, Ajax, Recaptcha_Form, Settings_Page};
use Sargas\Recaptcha\Interfaces\{Action_Hook_Interface, Filter_Hook_Interface};
use Sargas\Recaptcha\Traits\{Utility};

class Core implements Action_Hook_Interface, Filter_Hook_Interface {

	use Utility;

	/**
	 * @var Admin_Hook $admin_hooks Object to keep all hooks in your plugin
	 */
	protected Admin_Hook $admin_hooks;

	/**
	 * @var Admin_Menu $admin_menu
	 */
	protected Admin_Menu $admin_menu;

	/**
	 * @var Admin_Sub_Menu $admin_sub_menu
	 */
	protected Admin_Sub_Menu $admin_sub_menu;

	/**
	 * @var Admin_Notice[] $admin_notices
	 */
	protected $admin_notices;

	/**
	 * @var Init_Functions $init_functions Object  to keep all initial function in plugin
	 */
	protected Init_Functions $init_functions;

	/**
	 * @var Settings_Page $settings_page
	 */
	protected Settings_Page $settings_page;

	/**
	 * @var Recaptcha_Form[] $recaptcha_forms
	 */
	protected $recaptcha_forms;

	/**
	 * @var Ajax[] $ajax_calls
	 */
	protected $ajax_calls;

	public function __construct(
		Init_Functions $init_functions = null,
		Admin_Hook $admin_hooks = null,
		Admin_Menu $admin_menu = null,
		Admin_Sub_Menu $admin_sub_menu = null,
		array $admin_notices = null,
		array $recaptcha_forms = null,
		Settings_Page $settings_page = null,
		array $ajax_calls = null
	) {
		if ( ! is_null( $init_functions ) ) {
			$this->init_functions = $init_functions;
		}

		if ( ! is_null( $admin_hooks ) ) {
			$this->admin_hooks = $admin_hooks;
		}

		if ( ! is_null( $admin_menu ) ) {
			$this->admin_menu = $admin_menu;
		}

		if ( ! is_null( $admin_sub_menu ) ) {
			$this->admin_sub_menu = $admin_sub_menu;
		}

		if ( ! is_null( $admin_notices ) ) {
			$this->admin_notices = $this->check_associative_array_by_parent_type( $admin_notices, Admin_Notice::class )['valid'];
		}

		if ( ! is_null( $recaptcha_forms ) ) {
			$this->recaptcha_forms = $this->check_associative_array_by_parent_type( $recaptcha_forms, Recaptcha_Form::class )['valid'];
		}

		if ( ! is_null( $settings_page ) ) {
			$this->settings_page = $settings_page;
		}

		if ( ! is_null( $ajax_calls ) ) {
			$this->ajax_calls = $this->check_array_by_parent_type( $ajax_calls, Ajax::class )['valid'];
		}
	}

	public function init_core() {
		$this->register_add_action();
		$this->register_add_filter();
		$this->show_admin_notice();
	}

	public function register_add_action() {
		if ( ! is_null( $this->init_functions ) ) {
			$this->init_functions->register_add_action();
		}

		if ( ! is_null( $this->ajax_calls ) ) {
			foreach ( $this->ajax_calls as $ajax_call ) {
				$ajax_call->register_add_action();
			}
		}

		if ( ! is_null( $this->recaptcha_forms ) ) {
			foreach ( $this->recaptcha_forms as $form ) {
				$form->register_add_action();
			}
		}

		if ( is_admin() ) {
			$this->set_admin_menus();
			if ( ! is_null( $this->admin_hooks ) ) {
				$this->admin_hooks->register_add_action();
			}
		}
	}

	private function set_admin_menus() {
		$this->admin_menu->register_add_action();
		$this->admin_sub_menu->register_add_action();
		$this->settings_page->register_add_action();
	}

	public function register_add_filter() {
		if ( ! is_null( $this->recaptcha_forms ) ) {
			foreach ( $this->recaptcha_forms as $form ) {
				$form->register_add_filter();
			}
		}
	}

	private function show_admin_notice() {
		if ( ! is_null( $this->admin_notices ) ) {
			foreach ( $this->admin_notices as $key => $value ) {
				$this->admin_notices[ $key ]->register_add_action();
			}
		}
	}

}

