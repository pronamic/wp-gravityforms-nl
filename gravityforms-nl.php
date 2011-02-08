<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wordpress/gravityforms-nl/
Description: <strong>Gravity Forms</strong> public 1.4.5 | beta 1.5.RC4 | <strong>User Registration Add-On</strong> 1.0.beta3.1 | Extends the Gravity Forms plugin and add-ons with the Dutch language
Version: 2.1
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

class GravityFormsNL {
	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		add_action('init', array(__CLASS__, 'init'));

		add_filter('load_textdomain_mofile', array(__CLASS__, 'loadMoFile'), 10, 2);
	
		add_action('wp_print_scripts', array(__CLASS__, 'translateDatepicker'));
	}

	////////////////////////////////////////////////////////////

	/**
	 * Initialize
	 */
	public static function init() {
		load_plugin_textdomain('gravityformsuserregistration', false, dirname(plugin_basename(__FILE__)) . '/languages/');
	}

	////////////////////////////////////////////////////////////
	
	/**
	 * Load text domain MO file
	 * 
	 * @param string $moFile
	 * @param string $domain
	 */
	function loadMoFile($moFile, $domain) {
		$isDutch = (WPLANG == 'nl' || WPLANG == 'nl_NL');

		// Gravity Forms
		$version = null;
		if(class_exists('GFCommon')) {
			$version = GFCommon::$version;
        }

		$isGravityForms = ($domain == 'gravityforms');
		if($isDutch && $isGravityForms) {
			$moFile = __DIR__ . '/languages/' . $version . '/gravityforms-' . WPLANG . '.mo';

			// if specific version MO file is not available point to the public release version
			if(!is_readable($moFile)) {
				$moFile = __DIR__ . '/languages/gravityforms-' . WPLANG . '.mo';
			}
		}

		// User Registration Add-On
		$isGravityFormsUserRegistration = ($domain == 'gravityformsuserregistration' || $domain == 'gravityforms_user_registration');
		if($isDutch && $isGravityFormsUserRegistration) {
			$moFile = __DIR__ . '/languages/gravityformsuserregistration-' . WPLANG . '.mo';
		}
	
		return $moFile;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms translate datepicker
	 */
	function translateDatepicker() {
		if(wp_script_is('gforms_ui_datepicker')) {
			$srcUrl = plugins_url('js/jquery.ui.datepicker-nl.js', __FILE__);
	
			wp_enqueue_script('gforms_ui_datepicker_nl', $srcUrl, array('gforms_ui_datepicker'), false, true);
	    }
	}
}

GravityFormsNL::bootstrap();
