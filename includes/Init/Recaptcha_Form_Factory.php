<?php
/**
 * Recaptcha_Form_Factory class
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Init;

use RuntimeException;
use Sargas\Recaptcha\Abstracts\Recaptcha_Form;
use Sargas\Recaptcha\Forms\Comment_Form;
use Sargas\Recaptcha\Forms\Gravity_Forms;
use Sargas\Recaptcha\Forms\Login_Form;
use Sargas\Recaptcha\Forms\Lost_Password_Form;
use Sargas\Recaptcha\Forms\MC4WP_Form;
use Sargas\Recaptcha\Forms\Ninja_Forms\Ninja_Forms;
use Sargas\Recaptcha\Forms\Register_Form;
use Sargas\Recaptcha\Forms\Woocommerce\Checkout_Form as WC_Checkout_Form;
use Sargas\Recaptcha\Forms\Woocommerce\Login_Form as WC_Login_Form;
use Sargas\Recaptcha\Forms\Woocommerce\Lost_Password_Form as WC_Lost_Password_Form;
use Sargas\Recaptcha\Forms\Woocommerce\Register_Form as WC_Register_Form;
use Sargas\Recaptcha\Services\Recaptcha as Recaptcha_Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Recaptcha_Form_Factory {

	private Recaptcha_Service $recaptcha_service;

	public function __construct( Recaptcha_Service $recaptcha_service ) {
		$this->recaptcha_service = $recaptcha_service;
	}

	/**
	 * @param string $form Form name
	 *
	 * @return Recaptcha_Form
	 * @throws RuntimeException
	 */
	public function create_recaptcha_form( string $form ) {
		switch ( $form ) {
			case 'login_form':
				return new Login_Form( $this->recaptcha_service );
			case 'register_form':
				return new Register_Form( $this->recaptcha_service );
			case 'comment_form':
				return new Comment_Form( $this->recaptcha_service );
			case 'lost_password_form':
				return new Lost_Password_Form( $this->recaptcha_service );
			case 'wc_login_form':
				return new WC_Login_Form( $this->recaptcha_service );
			case 'wc_lost_password_form':
				return new WC_Lost_Password_Form( $this->recaptcha_service );
			case 'wc_register_form':
				return new WC_Register_Form( $this->recaptcha_service );
			case 'wc_checkout_form':
				return new WC_Checkout_Form( $this->recaptcha_service );
			case 'mc4wp_form':
				return new MC4WP_Form( $this->recaptcha_service );
			case 'nf_form':
				return new Ninja_Forms( $this->recaptcha_service );
			case 'gf_form':
				return new Gravity_Forms( $this->recaptcha_service );
			default:
				throw new RuntimeException( __( 'An error occurred while processing the form. Please try again', 'sargas-recaptcha' ) );
		}
	}

}
