<?php
/**
 * Simple_Setting_Page abstract Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Abstracts;

use Sargas\Recaptcha\Interfaces\Action_Hook_Interface;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Settings_Page implements Action_Hook_Interface {

	/**
	 * @var string $option_group
	 */
	protected $option_group;

	/**
	 * @var string $option_name
	 */
	protected $option_name;

	/**
	 * @var string $register_setting_args
	 */
	protected $register_setting_args;

	/**
	 * @var array $settings_sections
	 */
	protected $settings_sections;

	/**
	 * @var array $settings_fields
	 */
	protected $settings_fields;

	/**
	 * @var array $settings_errors
	 */
	protected $settings_errors;

	/**
	 * @var array $notices
	 */
	protected $notices;

	/**
	 * @access public
	 *
	 * @param array $initial_values
	 */
	public function __construct( array $initial_values ) {
		$this->option_group          = $initial_values['option_group'];
		$this->option_name           = $initial_values['option_name'];
		$this->register_setting_args = [
			'type'              => $initial_values['register_setting_args']['type'],
			'description'       => $initial_values['register_setting_args']['description'],
			'sanitize_callback' => [ $this, 'sanitize_setting_fields' ],
			'show_in_rest'      => $initial_values['register_setting_args']['show_in_rest'],
			'default'           => $initial_values['register_setting_args']['default'],
		];
		$this->settings_sections     = $initial_values['settings_sections'];
		$this->settings_fields       = $initial_values['settings_fields'];
		$this->settings_errors       = $initial_values['settings_errors'];
	}

	public function register_add_action() {
		add_action( 'admin_init', [ $this, 'add_settings_page' ] );
	}

	public function add_settings_page() {
		$this->init_register_setting();
		$this->add_all_settings_sections();
		$this->add_all_settings_fields();
	}

	public function init_register_setting() {
		register_setting( $this->option_group, $this->option_name, $this->register_setting_args );
	}

	public function add_all_settings_sections() {
		if ( ! is_null( $this->settings_sections ) ) {
			foreach ( $this->settings_sections as $settings_section ) {
				add_settings_section(
					$settings_section['id'],
					$settings_section['title'],
					[ $this, 'create_' . $settings_section['callback_function'] ],
					$settings_section['page']
				);
			}
		}
	}

	public function add_all_settings_fields() {
		if ( ! is_null( $this->settings_fields ) ) {
			foreach ( $this->settings_fields as $settings_field ) {
				add_settings_field(
					$settings_field['id'],
					$settings_field['title'],
					[ $this, 'create_' . $settings_field['callback_function'] ],
					$settings_field['page'],
					$settings_field['section'],
					$settings_field['arguments']
				);
			}
		}
	}

	public function create_settings_error( string $name ) {
		add_settings_error(
			$this->settings_errors[ $name ]['setting'],
			$this->settings_errors[ $name ]['code'],
			$this->settings_errors[ $name ]['message'],
			$this->settings_errors[ $name ]['type']
		);

	}

	/**
	 * @param array $args Field args
	 */
	public function create_text_field( array $args ) {

		$value = $this->get_option( $args['name'], $this->option_name );
		$type  = $args['type'] ?? 'text';

		$html = sprintf(
			'<input type="%1$s" class="sargas-recaptcha-text-input regular-text" id="%2$s-%3$s" name="%2$s[%3$s]" value="%4$s" placeholder="%5$s" />',
			esc_attr( $type ), esc_attr( $this->option_name ),
			esc_attr( $args['name'] ),
			esc_attr( $value ),
			esc_attr( $args['placeholder'] )
		);

		$html .= $this->get_field_description( $args );

		echo wp_kses( $html, [
			'input' => [
				'type'        => [],
				'class'       => [],
				'id'          => [],
				'name'        => [],
				'value'       => [],
				'placeholder' => []
			],
			'p'     => [
				'class' => []
			]
		] );
	}

	/**
	 * @param string $option Name of necessary option from options
	 * @param string $name Name of the options to retrieve
	 * @param string $default Default option value
	 * @param string $section
	 *
	 * @return string
	 */
	protected function get_option( string $option, string $name, string $default = '', string $section = '' ): string {
		$options = (array) get_option( $name );

		if ( ( '' !== $section ) && isset( $options[ $section ][ $option ] ) ) {
			return $options[ $section ][ $option ];
		}

		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}

		return $default;
	}

	/**
	 * @param array $args settings field args
	 *
	 * @return string
	 */
	protected function get_field_description( array $args ): string {
		if ( ! empty( $args['description'] ) ) {
			$desc = sprintf( '<p class="description">%s</p>', $args['description'] );
		} else {
			$desc = '';
		}

		return $desc;
	}

	/**
	 * @param array $args settings field args
	 */
	public function create_checkbox( array $args ) {
		$value = (bool) esc_attr( $this->get_option( $args['name'], $this->option_name, '', 'forms' ) );

		$html = sprintf(
			'<input type="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" %3$s %4$s />',
			esc_attr( $this->option_name ),
			esc_attr( $args['name'] ),
			checked( 1, $value, false ),
			disabled( $args['disabled'], true, false )
		);

		echo wp_kses( $html, [
			'input' => [
				'type'     => [],
				'id'       => [],
				'name'     => [],
				'checked'  => [],
				'disabled' => []
			]
		] );
	}

	/**
	 * @param array $args settings field args
	 */
	public function create_radio_button( array $args ) {
		$value = esc_attr( $this->get_option( $args['name'], $this->option_name ) );

		$html = sprintf(
			'<label for="%1$s-%2$s">',
			esc_attr( $args['name'] ),
			esc_attr( $args['value'] )
		);

		$html .= sprintf(
			'<input type="radio" id="%1$s-%2$s" name="%3$s[%1$s]" value="%2$s" %4$s />',
			esc_attr( $args['name'] ), esc_attr( $args['value'] ), esc_attr( $this->option_name ),
			checked( $args['value'], $value, false )
		);

		$html .= sprintf( '%s</label>', esc_attr( $args['value'] ) );

		echo wp_kses( $html, [
			'label' => [
				'for' => []
			],
			'input' => [
				'type'    => [],
				'id'      => [],
				'name'    => [],
				'value'   => [],
				'checked' => []
			]
		] );
	}

	/**
	 * A callback function that sanitizes the option's value.
	 *
	 * @param array $input
	 */
	abstract public function sanitize_setting_fields( array $input );

}
