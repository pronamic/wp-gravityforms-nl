<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wordpress/gravityforms-nl/
Description: Extends the Gravity Forms plugin with the Dutch language
Version: 1.4.3.1
Author: pronamic, remcotolsma
Author URI: http://pronamic.eu/
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