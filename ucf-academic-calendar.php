<?php
/*
Plugin Name: UCF Academic Calendar Plugin
Description: Provides a shortcode for displaying UCF Academic Calendar dates with configurable defaults
Version: 1.0.4
AuthorL UCF Web Communications
License: GPL3
Github Plugin URI: UCF/UCF-Academic-Calendar-Plugin
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'UCF_ACAD_CAL__PLUGIN_FILE', __FILE__ );
define( 'UCF_ACAD_CAL__PLUGIN_URL', plugins_url( basename( dirname( __FILE__ ) ) ) );
define( 'UCF_ACAD_CAL__STATIC_URL', UCF_ACAD_CAL__PLUGIN_URL . '/static' );

include_once 'admin/ucf-academic-calendar-config.php';
include_once 'includes/ucf-academic-calendar-feed.php';
include_once 'includes/ucf-academic-calendar-common.php';
include_once 'layouts/ucf-academic-calendar-classic.php';
include_once 'shortcodes/ucf-academic-calendar-shortcode.php';

if ( ! function_exists( 'ucf_acad_cal_plugin_activation' ) ) {
	function ucf_acad_cal_plugin_activation() {
		UCF_Acad_Cal_Config::add_options();
	}

	register_activation_hook( UCF_ACAD_CAL__PLUGIN_FILE, 'ucf_acad_cal_plugin_activation' );
}

if ( ! function_exists( 'ucf_acad_cal_plugin_deactivation' ) ) {
	function ucf_acad_cal_plugin_deactivation() {
		UCF_Acad_Cal_Config::delete_options();
	}

	register_deactivation_hook( UCF_ACAD_CAL__PLUGIN_FILE, 'ucf_acad_cal_plugin_deactivation' );
}

if ( ! function_exists( 'ucf_acad_cal_init' ) ) {
	function ucf_acad_cal_init() {
		/* Register Settings */
		add_action( 'admin_init', array( 'UCF_Acad_Cal_Config', 'settings_init' ) );
		add_action( 'admin_menu', array( 'UCF_Acad_Cal_Config', 'add_options_page' ) );
	}

	add_action( 'plugins_loaded', 'ucf_acad_cal_init' );
}
