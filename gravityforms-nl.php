<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wordpress/gravityforms-nl/
Description: Extends the Gravity Forms plugin with the Dutch language
Version: 1.4.5
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

function pronamic_gravityforms_init() {
	load_plugin_textdomain('gravityformsuserregistration', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('init', 'pronamic_gravityforms_init');

function pronamic_gravityforms_change_mo_file_location($moFile, $domain) {
	$isDutch = (WPLANG == 'nl' || WPLANG == 'nl_NL');

	$isGravityForms = ($domain == 'gravityforms');
	if($isDutch && $isGravityForms) {
		//$moFile = __DIR__ . '/languages/' . pathinfo($moFile, PATHINFO_BASENAME);
		$moFile = __DIR__ . '/languages/gravityforms-' . WPLANG . '.mo';
	}

	$isGravityFormsUserRegistration = ($domain == 'gravityformsuserregistration' || $domain == 'gravityforms_user_registration');
	if($isDutch && $isGravityFormsUserRegistration) {
		//$moFile = __DIR__ . '/languages/' . pathinfo($moFile, PATHINFO_BASENAME);
		$moFile = __DIR__ . '/languages/gravityformsuserregistration-' . WPLANG . '.mo';
	}

	return $moFile;
}

add_filter('load_textdomain_mofile', 'pronamic_gravityforms_change_mo_file_location', 10, 2);

/**
 * Gravity forms translate datepicker
 */
function pronamic_gravityforms_translate_datepicker() {
	if(wp_script_is('gforms_ui_datepicker')) {
		$srcUrl = plugins_url('js/jquery.ui.datepicker-nl.js', __FILE__);

		wp_enqueue_script('gforms_ui_datepicker_nl', $srcUrl, array('gforms_ui_datepicker'), false, true);
    }
}

add_action('wp_print_scripts', 'pronamic_gravityforms_translate_datepicker');