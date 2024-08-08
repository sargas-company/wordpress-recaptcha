<?php
/**
 * Warning_Notice Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Admin\Notices;

use Sargas\Recaptcha\Abstracts\Admin_Notice;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Warning_Notice extends Admin_Notice {

	/**
	 * @var string $message Notice message must be ready translation-ready.
	 */
	private $message;

	public function __construct( string $message ) {
		$this->message = $message;
	}

	public function show_admin_notice() {
		//show notice only on plugin page
		if ( get_current_screen()->parent_base === SARGAS_RECAPTCHA_NAME ) { ?>
            <div class="notice notice-warning">
                <p>
					<?php printf(
						'<strong>%1s</strong>: %2s',
						__( 'Warning', 'sargas-recaptcha' ),
						$this->message
					); ?>
                </p>
            </div>

		<?php }
	}
}