<?php
/**
 * Admin_Sub_Menu Abstract Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Abstracts;

use Sargas\Recaptcha\Interfaces\Action_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Admin_Sub_Menu implements Action_Hook_Interface {

	/**
	 * @var string $parent_slug
	 */
	protected $parent_slug;

	/**
	 * @var string $page_title
	 */
	protected $page_title;

	/**
	 * @var string $menu_title
	 */
	protected $menu_title;

	/**
	 * @var string $capability
	 */
	protected $capability;

	/**
	 * @var string $menu_slug
	 */
	protected $menu_slug;

	/**
	 * @var callable $callable_function
	 */
	protected $callable_function;

	/**
	 * @param array $initial_values
	 */
	public function __construct( array $initial_values ) {
		$this->parent_slug = $initial_values['parent-slug'];
		$this->page_title  = $initial_values['page_title'];
		$this->menu_title  = $initial_values['menu_title'];
		$this->capability  = $initial_values['capability'];
		$this->menu_slug   = $initial_values['menu_slug'];
	}

	public function add_admin_sub_menu_page() {
		add_submenu_page(
			$this->parent_slug,
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug,
			[ $this, 'render_sub_menu_panel' ]
		);
	}

	public function register_add_action() {
		add_action( 'admin_menu', [ $this, 'add_admin_sub_menu_page' ] );
	}

	abstract public function render_sub_menu_panel();

}
