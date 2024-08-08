<?php
/**
 * Plugin initial values
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Config;

use Sargas\Recaptcha\Abstracts\Admin_Menu;
use Sargas\Recaptcha\Abstracts\Admin_Sub_Menu;

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Initial_Value {

	/**
	 * Plugin default options
	 */
	const DEFAULT_OPTIONS = [
		'version'        => SARGAS_RECAPTCHA_VERSION,
		'site_key'       => '',
		'secret_key'     => '',
		'recaptcha_type' => 'v2',
		'forms'          => [
			'login_form'            => 1,
			'register_form'         => 1,
			'comment_form'          => 1,
			'lost_password_form'    => 1,
			'enable_comment_form'   => 1,
			'wc_login_form'         => 0,
			'wc_register_form'      => 0,
			'wc_lost_password_form' => 0,
			'wc_checkout_form'      => 0,
			'mc4wp_form'            => 0,
			'nf_form'               => 0,
			'gf_form'               => 0,
		]
	];

	/**
	 * Get list of supported forms
	 *
	 * @return array
	 */
	public static function get_supported_forms(): array {
		$supported_forms = [
			'wc_login_form'         => is_plugin_active( 'woocommerce/woocommerce.php' ),
			'wc_register_form'      => is_plugin_active( 'woocommerce/woocommerce.php' ),
			'wc_lost_password_form' => is_plugin_active( 'woocommerce/woocommerce.php' ),
			'wc_checkout_form'      => is_plugin_active( 'woocommerce/woocommerce.php' ),
			'mc4wp_form'            => is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ),
			'nf_form'               => is_plugin_active( 'ninja-forms/ninja-forms.php' ),
			'gf_form'               => is_plugin_active( 'gravityforms/gravityforms.php' ),
			'register_form'         => 1,
			'comment_form'          => 1,
			'lost_password_form'    => 1,
			'login_form'            => 1
		];

		return $supported_forms;
	}

	/**
	 * @return array
	 */
	public function admin_menu_page(): array {

		$menu_svg = '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="20" height="20" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
					viewBox="0 0 5399.62 5194.91"
					 xmlns:xlink="http://www.w3.org/1999/xlink"
					 xmlns:xodm="http://www.corel.com/coreldraw/odm/2003">
					 <defs>
					  <style type="text/css">
					   <![CDATA[
					    .fil0 {fill:#fff;fill-rule:nonzero}
					   ]]>
					  </style>
					 </defs>
					 <g id="Layer_x0020_1">
					  <metadata id="CorelCorpID_0Corel-Layer"/>
					  <path class="fil0" d="M2306.75 2594.88c121,148.47 265.37,294.23 409.41,442.84 233.7,-276.89 428.51,-530.67 604.83,-805.5 171.06,23.53 319.65,66.52 496.59,124.25 -276.48,511.96 -694.27,984.84 -1073,1411.3 -335.96,-319.16 -635.58,-614.75 -896.69,-1005.43l6.98 -4.67 451.89 -162.78zm409.37 -1926.17c-347.05,0 -679.09,29.94 -1005.64,87.54 -321.81,56.79 -638.37,140.47 -958.69,248.81 17.53,77.1 39.09,155.95 62.94,235.34 23.87,79.49 49.96,159.17 76.64,238.07 683.68,-188.32 1376.46,-284.71 2082.09,-266.44 711.2,18.41 1435.28,153.27 2175.91,427.73l14.21 5.25 -3.33 14.75c-166.72,733.17 -485.99,1382.53 -905.7,1964.79 -419.47,581.94 -939.17,1096.77 -1507.18,1561.28l-11.09 9.08 -11 -9.33c-455.96,-388.02 -854.5,-739.08 -1201.46,-1128.91 -347.53,-390.48 -643.6,-820.02 -894.15,-1364.67l-7.88 -17.17 17.88 -6.26c103.39,-36.25 205.24,-71.09 305.51,-103.9 100.58,-32.91 201.14,-64.35 302.2,-93.84l13.97 -4.08 6.35 13.12c182.68,377.46 390.42,697.44 633.64,994.09 240.52,293.42 515.86,564.28 835.99,845.59 348.19,-320.34 666.03,-656.82 937.82,-1025.28 271.08,-367.47 496.5,-766.86 660.86,-1213.96 -507.1,-140.98 -951.57,-219.6 -1377.77,-239.74 -430.98,-20.36 -843.8,19.04 -1284.39,114.12 -407.57,88.62 -798.62,214.56 -1191.21,353.19 -19.31,-55.38 -39.46,-110.59 -58.24,-166.08 -89.56,-256.55 -166.79,-487.59 -235.55,-729.35 -68.89,-242.22 -129.58,-496.07 -186.1,-798.33l-2.75 -14.73 154.48 -52.26c860.85,-291.57 1615.36,-547.14 2561.63,-547.14 462.67,0 920.64,39.47 1370.54,119.98 442.24,79.14 876.3,197.93 1299.01,357.82l13.95 5.28c-45.17,204.99 -90.76,409.94 -136.21,614.89l-17.56 -5.03c-405.66,-116.37 -825.54,-222.53 -1249.93,-299.44 -424.29,-76.9 -853.96,-124.79 -1279.79,-124.79z"/>
					 </g>
				</svg>';

		$initial_values = [
			'page_title' => 'Sargas reCAPTCHA',
			'menu_title' => 'reCAPTCHA',
			'capability' => 'manage_options',
			'menu_slug'  => 'sargas-recaptcha',
			'icon_url'   => 'data:image/svg+xml;base64,' . base64_encode( $menu_svg ),
			'position'   => null,
			'identifier' => 'sargas-recaptcha-admin-menu-page'
		];

		return $initial_values;
	}

	/**
	 * @return array
	 */
	public function admin_submenu_page(): array {
		$initial_values = [
			'parent-slug' => 'sargas-recaptcha',
			'page_title'  => esc_html__( 'Settings', 'sargas-recaptcha' ),
			'menu_title'  => esc_html__( 'Settings', 'sargas-recaptcha' ),
			'capability'  => 'manage_options',
			'menu_slug'   => 'sargas-recaptcha',
		];

		return $initial_values;
	}

	/**
	 * @return array array of initial values for a settings page.
	 */
	public function settings_page(): array {
		$register_setting_args = [
			'type'              => 'string',
			'description'       => 'reCAPTCHA Setting page',
			'sanitize_callback' => 'sanitize_setting_fields',
			'default'           => null,
			'show_in_rest'      => false,
		];

		$settings_sections = [
			[
				'id'                => 'sargas-recaptcha-general-section',
				'title'             => __( 'General Settings', 'sargas-recaptcha' ),
				'callback_function' => 'general_section',
				'page'              => 'sargas-recaptcha-menu-page-general',
			],
			[
				'id'                => 'sargas-recaptcha-standard-forms-section',
				'title'             => __( 'Standard Forms', 'sargas-recaptcha' ),
				'callback_function' => 'standard_forms_section',
				'page'              => 'sargas-recaptcha-menu-page-standard-forms',
			],
			[
				'id'                => 'sargas-recaptcha-wc-forms-section',
				'title'             => __( 'WooCommerce Forms', 'sargas-recaptcha' ),
				'callback_function' => 'woocommerce_forms_section',
				'page'              => 'sargas-recaptcha-menu-page-wc-forms',
			],
			[
				'id'                => 'sargas-recaptcha-mc4wp-forms-section',
				'title'             => __( 'Mailchimp For Wordpress Forms', 'sargas-recaptcha' ),
				'callback_function' => 'mc4wp_forms_section',
				'page'              => 'sargas-recaptcha-menu-page-mc4wp-forms',
			],
			[
				'id'                => 'sargas-recaptcha-nf-forms-section',
				'title'             => __( 'Ninja Forms', 'sargas-recaptcha' ),
				'callback_function' => 'nf_forms_section',
				'page'              => 'sargas-recaptcha-menu-page-nf-forms',
			],
			[
				'id'                => 'sargas-recaptcha-gf-forms-section',
				'title'             => __( 'Gravity Forms', 'sargas-recaptcha' ),
				'callback_function' => 'gf_forms_section',
				'page'              => 'sargas-recaptcha-menu-page-gf-forms',
			]
		];

		$settings_fields = [
			[
				'id'                => 'sargas-recaptcha-type',
				'title'             => __( 'reCAPTCHA type', 'sargas-recaptcha' ),
				'callback_function' => 'radio',
				'page'              => 'sargas-recaptcha-menu-page-general',
				'section'           => 'sargas-recaptcha-general-section',
				'arguments'         => [
					'name'  => 'recaptcha_type',
					'types' => [ 'v2', 'v3' ]
				]
			],
			[
				'id'                => 'sargas-recaptcha-site-key',
				'title'             => __( 'Site Key', 'sargas-recaptcha' ),
				'callback_function' => 'text_field',
				'page'              => 'sargas-recaptcha-menu-page-general',
				'section'           => 'sargas-recaptcha-general-section',
				'arguments'         => [
					'name'        => 'site_key',
					'disabled'    => false,
					'description' => '',
					'placeholder' => __( 'Please input your site key here', 'sargas-recaptcha' )
				]
			],
			[
				'id'                => 'sargas-recaptcha-secret-key',
				'title'             => __( 'Secret Key', 'sargas-recaptcha' ),
				'callback_function' => 'text_field',
				'page'              => 'sargas-recaptcha-menu-page-general',
				'section'           => 'sargas-recaptcha-general-section',
				'arguments'         => [
					'name'        => 'secret_key',
					'disabled'    => false,
					'description' => '',
					'placeholder' => __( 'Please input your secret key here', 'sargas-recaptcha' )
				]
			],
			[
				'id'                => 'sargas-recaptcha-login-form',
				'title'             => __( 'Login Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-standard-forms',
				'section'           => 'sargas-recaptcha-standard-forms-section',
				'arguments'         => [
					'name'     => 'login_form',
					'disabled' => false,
				]
			],
			[
				'id'                => 'sargas-recaptcha-register-form',
				'title'             => __( 'Register Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-standard-forms',
				'section'           => 'sargas-recaptcha-standard-forms-section',
				'arguments'         => [
					'name'     => 'register_form',
					'disabled' => false,
				]
			],
			[
				'id'                => 'sargas-recaptcha-comment-form',
				'title'             => __( 'Comment Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-standard-forms',
				'section'           => 'sargas-recaptcha-standard-forms-section',
				'arguments'         => [
					'name'     => 'comment_form',
					'disabled' => false,
				]
			],
			[
				'id'                => 'sargas-recaptcha-lost-password-form',
				'title'             => __( 'Lost Password Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-standard-forms',
				'section'           => 'sargas-recaptcha-standard-forms-section',
				'arguments'         => [
					'name'     => 'lost_password_form',
					'disabled' => false,
				]
			],
			[
				'id'                => 'sargas-recaptcha-wc-login-form',
				'title'             => __( 'Login Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-wc-forms',
				'section'           => 'sargas-recaptcha-wc-forms-section',
				'arguments'         => [
					'name'     => 'wc_login_form',
					'disabled' => is_plugin_active( 'woocommerce/woocommerce.php' ) === false
				]
			],
			[
				'id'                => 'sargas-recaptcha-wc-register-form',
				'title'             => __( 'Register Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-wc-forms',
				'section'           => 'sargas-recaptcha-wc-forms-section',
				'arguments'         => [
					'name'     => 'wc_register_form',
					'disabled' => is_plugin_active( 'woocommerce/woocommerce.php' ) === false
				]
			],
			[
				'id'                => 'sargas-recaptcha-wc-lost-password-form',
				'title'             => __( 'Lost Password Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-wc-forms',
				'section'           => 'sargas-recaptcha-wc-forms-section',
				'arguments'         => [
					'name'     => 'wc_lost_password_form',
					'disabled' => is_plugin_active( 'woocommerce/woocommerce.php' ) === false
				],
			],
			[
				'id'                => 'sargas-recaptcha-wc-checkout_formm',
				'title'             => __( 'Checkout Form', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-wc-forms',
				'section'           => 'sargas-recaptcha-wc-forms-section',
				'arguments'         => [
					'name'     => 'wc_checkout_form',
					'disabled' => is_plugin_active( 'woocommerce/woocommerce.php' ) === false
				],
			],
			[
				'id'                => 'sargas-recaptcha-mc4wp-form',
				'title'             => __( 'Mailchimp For Wordpress Forms', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-mc4wp-forms',
				'section'           => 'sargas-recaptcha-mc4wp-forms-section',
				'arguments'         => [
					'name'     => 'mc4wp_form',
					'disabled' => is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) === false
				]
			],
			[
				'id'                => 'sargas-recaptcha-nf-form',
				'title'             => __( 'Ninja Forms', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-nf-forms',
				'section'           => 'sargas-recaptcha-nf-forms-section',
				'arguments'         => [
					'name'     => 'nf_form',
					'disabled' => is_plugin_active( 'ninja-forms/ninja-forms.php' ) === false
				]
			],
			[
				'id'                => 'sargas-recaptcha-gf-form',
				'title'             => __( 'Gravity Forms', 'sargas-recaptcha' ),
				'callback_function' => 'checkbox',
				'page'              => 'sargas-recaptcha-menu-page-gf-forms',
				'section'           => 'sargas-recaptcha-gf-forms-section',
				'arguments'         => [
					'name'     => 'gf_form',
					'disabled' => is_plugin_active( 'gravityforms/gravityforms.php' ) === false
				]
			]
		];

		$changed_type_message = sprintf(
			'<strong>%1s</strong>: %2s <a target="_blank" href="https://www.google.com/recaptcha/admin">%2s</a>',
			__( 'Warning', 'sargas-recaptcha' ),
			__( 'reCAPTCHA type has been changed. Please, don\'t forget to replace necessaries keys from', 'sargas-recaptcha' ),
			__( 'the admin dashboard.', 'sargas-recaptcha' )
		);

		$settings_errors = [
			'success'      => [
				'setting' => 'success-saved',
				'code'    => 'success-saved',
				'message' => __( 'Settings saved.', 'sargas-recaptcha' ),
				'type'    => 'notice-success'
			],
			'changed_type' => [
				'setting' => 'changed-type',
				'code'    => 'changed-type',
				'message' => $changed_type_message,
				'type'    => 'notice-warning'
			]
		];

		$initial_value = [
			'option_group'          => 'sargas_recaptcha_option_group',
			'option_name'           => 'sargas-recaptcha-options',
			'register_setting_args' => $register_setting_args,
			'settings_sections'     => $settings_sections,
			'settings_fields'       => $settings_fields,
			'settings_errors'       => $settings_errors
		];

		return $initial_value;
	}
}
