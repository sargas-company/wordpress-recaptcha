<?php
/**
 * Ajax Abstract Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.2
 */

namespace Sargas\Recaptcha\Abstracts;

use Sargas\Recaptcha\Interfaces\Action_Hook_Interface;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Ajax implements Action_Hook_Interface {

	/**
	 * @var string action name for ajax call
	 */
	protected $action;

	/**
	 * @param string $action Action name for ajax call
	 */
	public function __construct( string $action ) {
		$this->action = $action;
	}

	public function register_add_action() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_script' ] );
		add_action( 'wp_ajax_' . $this->action, [ $this, 'handle' ] );
		add_action( 'wp_ajax_nopriv_' . $this->action, [ $this, 'handle' ] );
	}

	abstract public function register_script();

	/**
	 * @return array
	 */
	public function ajax_data(): array {
		$initial_value = [
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'sargas_recaptcha_ajax_nonce' ),
		];

		return $initial_value;
	}

	/**
	 * Abstract method for handle ajax request in back-end
	 */
	abstract public function handle();

	/**
	 * @param WP_Error $error
	 * @param int|null $status_code
	 */
	protected function send_error( WP_Error $error, int $status_code = null ) {
		wp_send_json_error( [
			'code'    => $error->get_error_code(),
			'message' => $error->get_error_message()
		], $status_code
		);
	}
}
