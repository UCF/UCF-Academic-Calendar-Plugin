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
				UCF_Acad_Cal_Config::get_shortcode_defaults(),
				$args
			);

			$feed_url       = $args['calendar_feed'];
			$use_cache      = UCF_Acad_Cal_Config::get_option_or_default( 'cache_items' );
			$offset         = $args['offset'];
			$count          = $args['count'];
			$is_important   = $args['is_important'];
			$items          = false;

			if ( $use_cache ) {
				$transient_name = self::get_transient_name( $feed_url );
				$items = get_transient( $transient_name );
			}

			if ( $items === false ) {
				$response = wp_remote_get( $feed_url, array( 'timeout' => 15 ) );

				if ( is_array( $response ) ) {
					$retobj = json_decode( wp_remote_retrieve_body( $response ) );

					if ( is_array( $retobj->terms ) && 
						 array_key_exists( 0, $retobj->terms ) &&
						 property_exists( $retobj->terms[0], 'events' ) ) {
						$items = $retobj->terms[0]->events;
					} // else $items is still false
				}

				if ( $use_cache ) {
					$expiration = UCF_Acad_Cal_Config::get_option_or_default( 'cache_expiration' ) * HOUR_IN_SECONDS;

					set_transient( $transient_name, $items, $expiration );
				}
			}

			if ( $items ) {
				$items = self::filter( $items, $offset, $count, $is_important );
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

		/**
		 * Filters events based on configuration options
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $items The array of items to filter
		 * @param int $offset The number of items to skip
		 * @param int $count The number of items to return
		 * @param bool $isImportant Flag indicating only isImportant items should be retrieved
		 * @return array The filtered array of items
		 **/
		private static function filter( $items, $offset, $count, $isImportant ) {
			$retval = array();

			foreach( $items as $item ) {
				if ( $isImportant ) {
					if ( $item->isImportant ) {
						$retval[] = $item;
					}
				} else {
					$retval[] = $item;
				}
			}

			return array_slice( $retval, $offset, $count );
		}
	}
}
