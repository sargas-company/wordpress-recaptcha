<?php
/**
 * Plugin Name:       Sargas reCAPTCHA
 * Description:       Protect your WordPress forms against spam and brute-force using Sargas reCAPTCHA
 * Version:           1.0.2
 * Author:            Sargas Inc
 * Author URI:        https://sargas.io
 * Text Domain:       sargas-recaptcha
 * Requires at least: 5.0
 * Requires PHP:      7.2.5
 *
 * @package           Sargas\Recaptcha
 */

use Sargas\Recaptcha\Admin\{Admin_Menu,
	Admin_Sub_Menu,
	Notices\Error_Notice,
	Notices\Warning_Notice,
	Settings_Page,
	Test_Keys_Ajax,
	Feature_Request_Ajax
};
use Sargas\Recaptcha\Config\Initial_Value;
use Sargas\Recaptcha\Init\{Activator, Admin_Hook, Constant, Core, Recaptcha_Form_Factory, Init_Functions};
use Sargas\Recaptcha\Services\Recaptcha;
use Sargas\Recaptcha\Uninstall\{Uninstall};

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Sargas_Recaptcha {
	/**
	 * @var Sargas_Recaptcha $instance
	 */
	private static $instance;

	private function __construct() {
		$autoloader_path = 'vendor/autoload.php';
		require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . $autoloader_path;

		Constant::define_constant();

		register_activation_hook(
			__FILE__,
			function () {
				$this->activate(
					new Activator()
				);
			}
		);

		register_uninstall_hook(
			__FILE__,
			[ __CLASS__, 'uninstall' ]
		);
	}

	public static function activate( Activator $activator ): void {
		$activator->activate();
	}

	public static function instance(): Sargas_Recaptcha {
		if ( is_null( ( self::$instance ) ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function uninstall(): void {
		Uninstall::uninstall();
	}

	public function init(): void {
		$settings = (array) get_option( 'sargas-recaptcha-options' );

		$this->load_plugin_textdomain();

		$initial_values  = new Initial_Value();
		$admin_notices   = null;
		$recaptcha_forms = null;
		$ajax_calls      = [ new Feature_Request_Ajax( 'sargas_feature_request' ) ];

		if ( empty( $settings['secret_key'] ) || empty( $settings['site_key'] ) ) {
			$admin_notices['empty_key'] = new Warning_Notice( __( 'Before you start working with Google reCAPTCHA, you need to enter the site key and the secret key.', 'sargas-recaptcha' ) );
		} else {
			try {
				$recaptcha = new Recaptcha( $settings );
				$recaptcha_forms = $this->get_recaptcha_forms( $recaptcha );
				$ajax_calls[] = new Test_Keys_Ajax( 'sargas_recaptcha_test',  $recaptcha );
			} catch ( RuntimeException $exception ) {
				$admin_notices['warning'] = new Warning_Notice( $exception->getMessage() );
			} catch ( Exception $exception ) {
				$admin_notices['error'] = new Error_Notice( __( 'An error occurred. Please, try again', 'sargas-recaptcha' ) );
			}
		}

		wp_cache_add( 'sargas-recaptcha-plugin-list', get_plugins(), '', 1200 );

		$core_object = new Core(
			new Init_Functions(),
			new Admin_Hook(),
			new Admin_Menu( $initial_values->admin_menu_page() ),
			new Admin_Sub_Menu( $initial_values->admin_submenu_page() ),
			$admin_notices,
			$recaptcha_forms,
			new Settings_Page( $initial_values->settings_page() ),
			$ajax_calls
		);

		$core_object->init_core();
	}

	/**
	 * Set up localisation.
	 */
	private function load_plugin_textdomain() {
		load_plugin_textdomain(
			'sargas-recaptcha',
			false,
			SARGAS_RECAPTCHA_LANG_SRC
		);
	}

	/**
	 * Initialize reCAPTCHA form list
	 * @param Recaptcha $recaptcha
	 *
	 * @return array array of Recaptcha_Form
	 * @throws RuntimeException
	 *
	 */
	private function get_recaptcha_forms( Recaptcha $recaptcha ): array {
		$settings = (array) get_option( 'sargas-recaptcha-options' );

		$form_factory = new Recaptcha_Form_Factory( $recaptcha );
		$active_forms = $this->filter_inactive_forms( $settings['forms'] );

		$forms = array_map( static function ( $form ) use ( $form_factory ) {
			return $form_factory->create_recaptcha_form( $form );
		}, $active_forms );

		return $forms;
	}

	/**
	 * @param array $forms List of all forms from options
	 *
	 * @return array
	 */
	private function filter_inactive_forms( array $forms ): array {
		//Remove inactive saved forms
		$active_forms = array_keys( array_filter( $forms ) );

		//Get list of available now forms
		$available_forms = array_keys(
			array_filter( Initial_Value::get_supported_forms(), static function ( $form ) {
				return $form !== false;
			} )
		);

		$filtered_forms = array_filter( $active_forms, static function ( $form ) use ( $available_forms ) {
			return in_array( $form, $available_forms, true );
		} );

		return $filtered_forms;
	}
}

$recaptcha = Sargas_Recaptcha::instance();
$recaptcha->init();
