<?php
/**
 * Ninja_Forms_Custom_Field Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.2
 */

namespace Sargas\Recaptcha\Forms\Ninja_Forms;

use NF_Abstracts_Input;
use NF_Database_Models_Form;
use Sargas\Recaptcha\Services\Recaptcha;

class Ninja_Forms_Custom_Field extends NF_Abstracts_Input {

	protected $_templates = 'sargas_recaptcha';

	private Recaptcha $recaptcha_service;

	public function __construct( Recaptcha $recaptcha ) {
		$this->_type             = 'sargas_recaptcha';
		$this->_name             = $this->_type;
		$this->_nicename         = 'Sargas reCAPTCHA';
		$this->_section          = 'misc';
		$this->_icon             = 'shield';
		$this->_settings_all_fields = [];
		$this->recaptcha_service = $recaptcha;

		add_filter( 'ninja_forms_field_template_file_paths', [ $this, 'template_path' ] );

		add_filter( 'ninja_forms_localize_field_settings_' . $this->_type, [ $this, 'add_field_options' ] );

		add_filter( 'ninja_forms_submit_data', [ $this, 'on_submit' ] );

		add_filter( 'nf_sub_hidden_field_types', [ $this, 'hide_field_type' ] );

		parent::__construct();
	}

	public function add_field_options( $settings ): array {
		$options = get_option( 'sargas-recaptcha-options', [] );

		$settings['recaptcha_type'] = $options['recaptcha_type'];
		$settings['content']        = $this->recaptcha_service->display( true );
		$settings['label_pos']      = 'hidden';
		$settings['required']       = true;

		return $settings;
	}

	public function template_path( $templates ) {
		$templates[] = SARGAS_RECAPTCHA_TPL;

		return $templates;
	}

	public function on_submit( $form_data ) {
		$error_message = sprintf( '<strong>%1$s</strong>: %2$s',
			esc_html__( 'Error', 'sargas-recaptcha' ),
			esc_html__( 'Invalid reCAPTCHA. Please try again.', 'sargas-recaptcha' )
		);

		/**
		 * @var NF_Database_Models_Form $form
		*/
		$form = Ninja_Forms()->form( $form_data['id'] )->get();

		$formContent = (array) $form->get_setting('formContentData');

		$shouldCheck = current( array_filter( $formContent, function ( $item ) {
			return strpos( $item, $this->_type ) !== false;
		} ) );

		if ( (bool) $shouldCheck ) {
			$recaptcha_field = current( array_filter( $form_data['fields'], function ( $item ) {
				return isset( $item['key'] ) && strpos( $item['key'], $this->_type ) !== false;
			} ) );

			$field_id = $recaptcha_field['id'];

			$_POST['g-recaptcha-response'] = esc_attr( $recaptcha_field['value'] );

			if ( isset( $_POST['g-recaptcha-response'] ) || '' !== $_POST['g-recaptcha-response'] ) {
				if ( true !== $this->recaptcha_service->validate() ) {
					$form_data['errors']['fields'][$field_id] = $error_message;
				}
			} else {
				$form_data['errors']['fields'][$field_id] = $error_message;
			}
		}

		return $form_data;
	}

	public function hide_field_type( $field_types ) {
		$field_types[] = $this->_name;

		return $field_types;
	}
}
