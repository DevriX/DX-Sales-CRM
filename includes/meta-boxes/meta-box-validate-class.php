<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta Box Validate Class
 *
 * Handles all the functions to validate meta box data.
 *
 * @package WP Meta Box
 * @since 1.0.0
 */

if ( ! class_exists( 'at_Demo_Meta_Box_Validate' ) ) {

	class at_Demo_Meta_Box_Validate {

		public $model;

		// class constructor
		public function __construct() {

			global $wpd_mb_model;

			$this->model = $wpd_mb_model;
		}

		/**
		 * Convert date string to timestamp
		 *
		 * @param string $data Date string
		 * @return int Timestamp
		 */
		public function date_str_to_time( $data ) {
			return strtotime( $data );
		}

		/**
		 * Escape HTML data
		 *
		 * @param mixed $data Data to escape
		 * @return mixed Escaped data
		 */
		public function escape_html( $data ) {
			if ( is_array( $data ) ) {
				foreach ( $data as $key => $value ) {
					$data[ $key ] = $this->escape_html( $value );
				}
				return $data;
			}

			// Use WordPress's built-in escaping functions based on context
			return esc_html( $data );
		}

	} // End Class

} // End Check Class Exists

