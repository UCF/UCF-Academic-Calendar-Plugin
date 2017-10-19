<?php
/**
 * Handles retrieving academic calendar data
 **/
if ( ! class_exists( 'UCF_Acad_Cal_Feed' ) ) {
	class UCF_Acad_Cal_Feed {
		/**
		 * Retrieves the academic calendar feed
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $args Arguments to override the configured default
		 * @return array The academic calendar events in an array
		 **/
		public static function get_feed( $args ) {
			// Get default values
			$args = shortcode_atts(
				UCF_Acad_Cal_Config::get_option_defaults(),
				$args
			);

			$feed_url       = $args['calendar_feed'];
			$use_cache      = UCF_Acad_Cal_Config::get_option_or_default( 'cache_items' );
			$items          = false;

			if ( $use_cache ) {
				$transient_name = self::get_transient_name( $feed_url );
				$items = get_transient( $transient_name );
			}

			if ( $items === false ) {
				$response = wp_remote_get( $feed_url, array( 'timeout' => 15 ) );

				if ( is_array( $response ) ) {
					$retobj = json_decode( wp_remote_retrieve_body( $response ) );

					if ( is_array( $retobj->terms ) ) {
						$items = $retobj->terms[0]->events;
					}
				}

				if ( $use_cache ) {
					$expiration = UCF_Acad_Cal_Config::get_option_or_default( 'cache_expiration' ) * HOUR_IN_SECONDS;

					set_transient( $transient_name, $items, $expiration );
				}
			}

			if ( $items ) {
				$items = array_slice( $items, 0, $args['default_count'] );
			}

			if ( ! is_array( $items ) ) {
				$items = array();
			}

			return $items;
		}

		/**
		 * Returns a unique transient name based on the feed url.
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param string The url of the feed to store as a transient
		 * @return string The unique name of the transient.
		 **/
		private static function get_transient_name( $url ) {
			return 'ucf_acad_cal_' . md5( $url );
		}
	}
}
