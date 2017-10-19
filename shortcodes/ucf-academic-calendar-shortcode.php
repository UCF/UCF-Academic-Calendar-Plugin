<?php
/**
 * Handles the registration of the academic calendar shortcode
 **/
if ( ! class_exists( 'UCF_Acad_Cal_Shortcode' ) ) {
	class UCF_Acad_Cal_Shortcode {
		/**
		 * The handler for the `ucf-academic-calendar` shortcode
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $atts The shortcode attributes
		 * @return string The shortcode output
		 **/
		public static function handler( $atts, $content='' ) {
			$atts = shortcode_atts( UCF_Acad_Cal_Config::get_shortcode_defaults(), $atts );

			$items = UCF_Acad_Cal_Feed::get_feed( $atts );

			ob_start();

			echo UCF_Acad_Cal_Common::display_academic_calendar_events( $items, $atts['layout'], $atts );

			return ob_get_clean();
		}
	}

	add_shortcode( 'ucf-academic-calendar', array( 'UCF_Acad_Cal_Shortcode', 'handler' ) );
}
