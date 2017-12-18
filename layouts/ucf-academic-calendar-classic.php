<?php
/**
 * Functions for the 'classic' layout
 **/
if ( ! function_exists( 'ucf_acad_cal_display_classic_before' ) ) {
	/**
	 * Function that returns the default opening markup for
	 * an academic calendar event list.
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @param string $content The incoming content (for filter)
	 * @param array $items The array of calendar events
	 * @param array $args Additional arguments
	 * @return string The opening markup
	 **/
	function ucf_acad_cal_display_classic_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="ucf-academic-calendar ucf-academic-calendar-classic">
	<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'ucf_acad_cal_display_classic_title' ) ) {
	/**
	 * Function that returns the default title markup for
	 * an academic calendar event list.
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @param string $content The incoming content (for filter)
	 * @param array $items The array of calendar events
	 * @param array $args Additional arguments
	 * @return string The title markup
	 **/
	function ucf_acad_cal_display_classic_title( $content, $items, $args ) {
		ob_start();
		if ( isset( $args['title'] ) ) :
	?>
		<h2 class="ucf-academic-calendar-title"><?php echo $args['title']; ?></h2>
	<?php
		endif;
		return ob_get_clean();
	}
}

if ( ! function_exists( 'ucf_acad_cal_display_classic' ) ) {
	/**
	 * Function that returns the default list markup for
	 * an academic calendar event list
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @param string $content The incoming content (for filter)
	 * @param array $items The array of calendar events
	 * @param array $args Additional arguments
	 * @return string The content markup
	 **/
	function ucf_acad_cal_display_classic( $content, $items, $args ) {
		ob_start();
	?>

	<?php if ( !empty( $items ) ) : ?>
	<ul class="ucf-academic-calendar-list">
		<?php foreach( $items as $item ) : ?>
			<li class="ucf-academic-calendar-list-item">
				<a href="<?php echo $item->directUrl; ?>"><?php echo $item->summary; ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>

	<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'ucf_acad_cal_display_classic_after' ) ) {
	/**
	 * Function that returns the default closing markup for
	 * an academic calendar event list
	 * @author Jim Barnes
	 * @since 1.0.0
	 * @param string $content The incoming content (for filter)
	 * @param array $items The array of calendar events
	 * @param array $args Additional arguments
	 * @return string The content markup
	 **/
	function ucf_acad_cal_display_classic_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}
}
