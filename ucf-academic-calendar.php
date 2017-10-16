<?php
/*
Plugin Name: UCF Academic Calendar Plugin
Description: Provides a shortcode for displaying UCF Academic Calendar dates with configurable defaults
Version: 1.0.0
AuthorL UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'UCF_ACAD_CAL__PLUGIN_FILE', __FILE__ );
define( 'UCF_ACAD_CAL__PLUGIN_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
define( 'UCF_ACAD_CAL__STATIC_URL', UCF_ACAD_CAL__PLUGIN_URL . '/static' );

if ( ! function_exists( 'ucf_acad_cal_plugin_activation' ) ) {
	function ucf_acad_cal_plugin_activation() {

	}

	register_activation_hook( UCF_ACAD_CAL__PLUGIN_FILE, 'ucf_acad_cal_plugin_activation' );
}

if ( ! function_exists( 'ucf_acad_cal_plugin_deactivation' ) ) {
	function ucf_acad_cal_plugin_deactivation() {

	}

	register_deactivation_hook( UCF_ACAD_CAL__PLUGIN_FILE, 'ucf_acad_cal_plugin_deactivation' );
}

if ( ! function_exists( 'ucf_acad_cal_init' ) ) {
	function ucf_acad_cal_init() {

	}

	add_action( 'plugins_loaded', 'ucf_acad_cal_init' );
}
