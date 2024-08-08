<?php
/**
 * Utility Class File
 *
 * @package    Sargas\Recaptcha
 * @since      1.0.0
 */

namespace Sargas\Recaptcha\Traits;

use Sargas\Recaptcha\Config\Initial_Value;
use WP_User;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait Utility {

	/**
	 * @return boolean
	 */
	public static function is_admin(): bool {
		return is_user_logged_in() && current_user_can( 'manage_options' );
	}

	public static function get_current_user_email(): string {
		/**
		 * @var WP_User $user
		 */
		$user = wp_get_current_user();

		return $user->user_email;
	}

	/**
	 * @param array $items Passed array to check type of each item inside it
	 * @param string $type type to check
	 */
	public function check_array_by_parent_type( array $items, string $type ): array {
		$result['valid']   = [];
		$result['invalid'] = [];
		foreach ( $items as $item ) {
			if ( get_parent_class( $item ) === $type ) {
				$result['valid'][] = $item;
			} else {
				$result['invalid'][] = $item;
			}

		}

		return $result;
	}

	/**
	 * @param array $items Passed array to check type of each item inside it
	 * @param string $type type to check
	 */
	public function check_associative_array_by_parent_type( array $items, string $type ): array {
		$result['valid']   = [];
		$result['invalid'] = [];
		foreach ( $items as $key => $item ) {
			if ( get_parent_class( $item ) === $type ) {
				$result['valid'][ $key ] = $item;
			} else {
				$result['invalid'][ $key ] = $item;
			}

		}

		return $result;
	}
}
