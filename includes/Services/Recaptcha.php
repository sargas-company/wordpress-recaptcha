<?php
/**
 * Recaptcha Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Services;

use ReCaptcha\ReCaptcha as Google_Recaptcha;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Recaptcha {

	/**
	 * @var Google_Recaptcha $recaptcha
	 */
	private $recaptcha;

	/**
	 * @var string $site_key
	 */
	private $site_key;

	/**
	 * @var string $type reCAPTCHA type
	 */
	private $type;

	/**
	 * @param array $settings Plugin settings
	 */
	public function __construct( array $settings ) {
		$this->recaptcha = new Google_Recaptcha( $settings['secret_key'] );
		$this->site_key  = $settings['site_key'];
		$this->type      = $settings['recaptcha_type'];
	}

	/**
	 * Display reCAPTCHA badge
	 *
	 * @param bool $should_return Optional parameter if you want to return the reCAPTCHA output
	 *
	 * @return string|void
	 */
	public function display( bool $should_return = false ) {
		switch ( $this->type ) {
			case 'v2':
				$recaptcha_html = '<div class="sargas-recaptcha-wrapper"></div>';
				break;
			case 'v3':
				$recaptcha_html = '<input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response sargas-recaptcha-wrapper">';
				break;
			default:
				$recaptcha_html = '';
				break;
		}

		if ( $should_return ) {
			return $recaptcha_html;
		}

		echo wp_kses( $recaptcha_html, [
				'div'   => [
					'class' => []
				],
				'input' => [
					'type'  => [],
					'name'  => [],
					'class' => []
				]
			]
		);
	}

	public function validate(): bool {
		$response = $this->recaptcha
			->setExpectedHostname( $_SERVER['SERVER_NAME'] )
			->verify( $_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'] );

		return $response->isSuccess();
	}

	public function enqueue_scripts() {
		$options = [
            'siteKey'           => $this->site_key,
            'type'              => $this->type,
			'recaptchaCallback' => 'v2' ===$this->type ? 'onLoadCallbackV2' : 'onLoadCallbackV3',
        ];

		wp_enqueue_script(
			'sargas-recaptcha-api',
			$this->get_api_url(),
			[],
			SARGAS_RECAPTCHA_VERSION,
			true
		);

		wp_enqueue_script(
			'sargas-recaptcha-public-script',
			SARGAS_RECAPTCHA_PUBLIC_JS_SRC . 'sargas-recaptcha-public.js',
			['jquery', 'sargas-recaptcha-api'],
			SARGAS_RECAPTCHA_VERSION,
			true
		);

		wp_localize_script(
			'sargas-recaptcha-public-script',
			'sargasRecaptcha',
			$options
		);
	}

	public function get_api_url(): string {
		$api_url = '';

		list ( $language ) = explode( '-', get_bloginfo( 'language' ) );

		if ( 'v2' === $this->type ) {
			$api_url = SARGAS_GOOGLE_RECAPTCHA_API_URL . '?hl=' . esc_attr( $language ) . '&onload=onLoadCallbackV2&render=explicit';
		} elseif ( 'v3' === $this->type ) {
			$api_url = SARGAS_GOOGLE_RECAPTCHA_API_URL . '?onload=onLoadCallbackV3&render=' . esc_attr( $this->site_key );
		}

		return $api_url;
	}

	public function enqueue_styles() {
		wp_enqueue_style(
			'sargas-recaptcha-public-style',
			SARGAS_RECAPTCHA_PUBLIC_CSS_SRC . 'sargas-recaptcha-public.css',
			[],
			SARGAS_RECAPTCHA_VERSION
		);
	}

}