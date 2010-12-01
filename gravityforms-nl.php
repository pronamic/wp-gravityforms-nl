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

function pronamic_gravityforms_change_mo_file_location($moFile, $domain) {
	$isGravityForms = ($domain == 'gravityforms');
	$isDutch = (WPLANG == 'nl' || WPLANG == 'nl_NL');

	if($isGravityForms && $isDutch) {
		$moFile = __DIR__ . '/languages/' . pathinfo($moFile, PATHINFO_BASENAME);
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