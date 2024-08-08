<?php
/**
 * Setting_Page Class File
 *
 * @package    Sargas\Plugin_Name
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Admin;

use Sargas\Recaptcha\Abstracts\Settings_Page as Abstract_Settings_Page;
use Sargas\Recaptcha\Traits\Utility;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Settings_Page extends Abstract_Settings_Page {

	use Utility;

	/**
	 * @var array|null $settings
	 */
	private ?array $settings;

	public function __construct( array $initial_values ) {
		parent::__construct( $initial_values );
		$this->settings = (array) get_option( $this->option_name );
	}

	/**
	 * @return array
	 */
	public function sanitize_setting_fields( array $input ) {
		$valid               = [];
		$valid['site_key']   = stripslashes( sanitize_text_field( $input['site_key'] ) );
		$valid['secret_key'] = stripslashes( sanitize_text_field( $input['secret_key'] ) );

		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			$valid['forms']['wc_login_form']         = isset( $input['wc_login_form'] );
			$valid['forms']['wc_register_form']      = isset( $input['wc_register_form'] );
			$valid['forms']['wc_lost_password_form'] = isset( $input['wc_lost_password_form'] );
			$valid['forms']['wc_checkout_form']      = isset( $input['wc_checkout_form'] );
		}

		if ( is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) {
			$valid['forms']['mc4wp_form'] = isset( $input['mc4wp_form'] );
		}

		if ( is_plugin_active( 'ninja-forms/ninja-forms.php' ) ) {
			$valid['forms']['nf_form'] = isset( $input['nf_form'] );
		}

		if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
			$valid['forms']['gf_form'] = isset( $input['gf_form'] );
		}

		$valid['forms']['login_form']         = isset( $input['login_form'] );
		$valid['forms']['register_form']      = isset( $input['register_form'] );
		$valid['forms']['comment_form']       = isset( $input['comment_form'] );
		$valid['forms']['lost_password_form'] = isset( $input['lost_password_form'] );

		$valid['recaptcha_type'] = in_array( $input['recaptcha_type'], [
			'v2',
			'v3'
		] ) ? $input['recaptcha_type'] : false;

		if ( $valid['recaptcha_type'] !== $this->settings['recaptcha_type'] ) {
			$this->create_settings_error( 'changed_type' );
		}

		$this->create_settings_error( 'success' );

		$result = array_replace_recursive( $this->settings, $valid );

		return $result;
	}

	public function create_general_section() {
		$message = sprintf(
			'<p class="sargas-recaptcha-info">%1s <a target="_blank" href="%2s">%3s</a></p>',
			esc_html__( 'Before you start working with Google reCAPTCHA, you need to generate API keys from', 'sargas-recaptcha' ),
			esc_url( 'https://www.google.com/recaptcha/admin/create' ),
			esc_url( 'https://www.google.com/recaptcha/admin/create' )
		);

		echo wp_kses( $message, [ 'p' => [ 'class' => [] ], 'a' => [ 'href' => [] ] ] );
	}

	public function create_standard_forms_section() {
		//
	}

	public function create_woocommerce_forms_section() {
		$plugin_list = array_keys( wp_cache_get( 'sargas-recaptcha-plugin-list' ) );

		if ( in_array( 'woocommerce/woocommerce.php', $plugin_list, true ) === false ) {
			$wc_link = 'https://wordpress.org/plugins/woocommerce/';
			$this->show_not_installed_plugin_message( 'The WooCommerce ', $wc_link );
		} else if ( is_plugin_active( 'woocommerce/woocommerce.php' ) === false ) {
			$this->show_inactive_plugin_message( 'The WooCommerce' );
		}
	}

	/**
	 * Display message about not installed plugin
	 *
	 * @param string $name Plugin name
	 * @param string $link Link to plugin on https://wordpress.org
	 */
	private function show_not_installed_plugin_message( $name, $link ) {
		$message = sprintf(
			'<p class="sargas-recaptcha-info"><strong>%1s</strong>: %2s, <a target="_blank" href="%3s">%4s</a></p>',
			esc_html__( 'Warning', 'sargas-recaptcha' ),
			esc_attr( $name ) . '' . esc_html__( 'plugin is not installed. Please', 'sargas-recaptcha' ),
			esc_url( $link ),
			esc_html__( 'install it.', 'sargas-recaptcha' )
		);

		echo wp_kses( $message, [ 'p' => [ 'class' => [] ], 'a' => [ 'href' => [] ] ] );
	}

	/**
	 * Display message about inactive plugin
	 *
	 * @param string $name Plugin name
	 */
	private function show_inactive_plugin_message( $name ) {
		$message = sprintf(
			'<p class="sargas-recaptcha-info"><strong>%1s</strong>: %2s, <a target="_blank" href="%3s">%4s</a></p>',
			esc_html__( 'Warning', 'sargas-recaptcha' ),
			esc_attr( $name ) . ' ' . esc_html__( 'plugin is inactive. Please', 'sargas-recaptcha' ),
			self_admin_url( 'plugins.php' ),
			esc_html__( 'activate it.', 'sargas-recaptcha' )
		);

		echo wp_kses( $message, [ 'p' => [ 'class' => [] ], 'a' => [ 'href' => [] ] ] );
	}

	public function create_mc4wp_forms_section() {
		$plugin_list = array_keys( wp_cache_get( 'sargas-recaptcha-plugin-list' ) );

		if ( in_array( 'mailchimp-for-wp/mailchimp-for-wp.php', $plugin_list, true ) === false ) {
			$mc4wp_link = 'https://wordpress.org/plugins/mailchimp-for-wp/';
			$this->show_not_installed_plugin_message( 'The Mailchimp for WordPress ', $mc4wp_link );
		} else if ( is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) === false ) {
			$this->show_inactive_plugin_message( 'The Mailchimp for WordPress' );
		}
	}

	public function create_nf_forms_section() {
		$plugin_list = array_keys( wp_cache_get( 'sargas-recaptcha-plugin-list' ) );

		if ( in_array( 'ninja-forms/ninja-forms.php', $plugin_list, true ) === false ) {
			$nf_link = 'https://wordpress.org/plugins/ninja-forms';
			$this->show_not_installed_plugin_message( 'The Ninja Forms ', $nf_link );
		} else if ( is_plugin_active( 'ninja-forms/ninja-forms.php' ) === false ) {
			$this->show_inactive_plugin_message( 'The Ninja Forms' );
		}
	}

	public function create_gf_forms_section() {
		$plugin_list = array_keys( wp_cache_get( 'sargas-recaptcha-plugin-list' ) );

		if ( in_array( 'gravityforms/gravityforms.php', $plugin_list, true ) === false ) {
			$nf_link = 'https://www.gravityforms.com';
			$this->show_not_installed_plugin_message( 'The Gravity Forms ', $nf_link );
		} else if ( is_plugin_active( 'gravityforms/gravityforms.php' ) === false ) {
			$this->show_inactive_plugin_message( 'The Gravity Forms' );
		}
	}

	public function create_radio( $args ) {
		echo '<fieldset>';
		foreach ( $args['types'] as $value ) {
			$args['value'] = $value;
			$this->create_radio_button( $args );
			echo '<br/>';
		}
		echo '</fieldset>';
	}
}
