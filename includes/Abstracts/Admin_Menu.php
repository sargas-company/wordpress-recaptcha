<?php
/**
 * Admin_Menu abstract Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Abstracts;

use Sargas\Recaptcha\Interfaces\Action_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Admin_Menu implements Action_Hook_Interface {

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
	 * @var string $icon_url
	 */
	protected $icon_url;

	/**
	 * @var int $position
	 */
	protected $position;

	/**
	 * @var string $identifier
	 */
	protected $identifier;

	/**
	 * @param array $initial_values
	 */
	public function __construct( array $initial_values ) {
		$this->page_title = $initial_values['page_title'];
		$this->menu_title = $initial_values['menu_title'];
		$this->capability = $initial_values['capability'];
		$this->menu_slug  = $initial_values['menu_slug'];
		$this->icon_url   = $initial_values['icon_url'];
		$this->position   = $initial_values['position'];
		$this->identifier = $initial_values['identifier'];
	}

	public function add_admin_menu_page() {
		add_menu_page(
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug,
			[ $this, 'render_menu_panel' ],
			$this->icon_url,
			$this->position
		);
	}

	public function register_add_action() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu_page' ] );
	}

	abstract public function render_menu_panel();

}
