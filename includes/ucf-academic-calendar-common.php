<?php
/**
 * Common display function
 **/
if ( ! class_exists( 'UCF_Acad_Cal_Common' ) ) {
	class UCF_Acad_Cal_Common {
		/**
		 * General class for displaying academic calendar_events
		 * @author Jim Barnes
		 * @since 1.0.0
		 * @param array $args An array of default arguments
		 * @return string The markup layout
		 **/
		public static function display_academic_calendar_events( $items, $layout='classic', $args=array() ) {
			ob_start();

			// Before
			$layout_before = ucf_acad_cal_display_classic_before( '', $items, $args );
			if ( has_filter( 'ucf_acad_cal_display_' . $layout . '_before' ) ) {
				$layout_before = apply_filters( 'ucf_acad_cal_display_' . $layout . '_before', $layout_before, $items, $args );
			}

			echo $layout_before;

			// Title
			$layout_title = ucf_acad_cal_display_classic_title( '', $items, $args );
			if ( has_filter( 'ucf_acad_cal_display_' . $layout . '_title' ) ) {
				$layout_title = apply_filters( 'ucf_acad_cal_display_' . $layout . '_title', $layout_title, $items, $args );
			}

			echo $layout_title;

			// Content
			$layout_content = ucf_acad_cal_display_classic( '', $items, $args );
			if ( has_filter( 'ucf_acad_cal_display_' . $layout ) ) {
				$layout_content = apply_filters( 'ucf_acad_cal_display_' . $layout, $layout_content, $items, $args );
			}

			echo $layout_content;

			// After
			$layout_after = ucf_acad_cal_display_classic_after( '', $items, $args );
			if ( has_filter( 'ucf_acad_cal_display_' . $layout ) ) {
				$layout_after = apply_filters( 'ucf_acad_cal_display_' . $layout . '_after', $layout_after, $items, $args );
			}

			echo $layout_after;

			return ob_get_clean();
		}
	}
}
