<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wordpress/gravityforms-nl/
Description: <strong>Gravity Forms</strong> public 1.5.2.3 | <strong>User Registration Add-On</strong> 1.0 | <strong>Campaign Monitor Add-On</strong> 1.6 | Extends the Gravity Forms plugin and add-ons with the Dutch language 
Version: 2.4.4
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

class GravityFormsNL {
	/**
	 * The officiale name of this plugin
	 * 
	 * @var string
	 */
	const PLUGIN_NAME = 'Gravity Forms (nl)';

	/**
	 * The URL to this plugin
	 * 
	 * @var string
	 */
	const PLUGIN_URL_PAGE = 'http://pronamic.eu/wordpress/gravityforms-nl/';

	////////////////////////////////////////////////////////////

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
	public static function loadMoFile($moFile, $domain) {
		$isDutch = (WPLANG == 'nl' || WPLANG == 'nl_NL');

		// Gravity Forms
		$isGravityForms = ($domain == 'gravityforms');
		if($isDutch && $isGravityForms) {
			$version = null;
			if(class_exists('GFCommon')) {
				$version = GFCommon::$version;
	        }

			$moFile = self::getMoFile('gravityforms', $version);
		}

		// User Registration Add-On
		$isUserRegistrationAddOn = ($domain == 'gravityformsuserregistration' || $domain == 'gravityforms_user_registration');
		if($isDutch && $isUserRegistrationAddOn) {
			// Unfortunately the static var GFUser::$version is private
			$version = get_option('gf_user_registration_version');

			$moFile = self::getMoFile('gravityformsuserregistration', $version);
		}

		// Campaign Monitor Add-On
		$isCampaignMonitorAddOn = ($domain == 'gravityformscampaignmonitor');
		if($isDutch && $isCampaignMonitorAddOn) {
			// Unfortunately the static var GFCampaignMonitor::$version is private
			$version = get_option('gf_campaignmonitor_version');

			$moFile = self::getMoFile('gravityformscampaignmonitor', $version);
		}
	
		return $moFile;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Get the MO file for the specified domain and version
	 * Enter description here ...
	 */
	public static function getMoFile($domain, $version) {
		$dir = dirname(__FILE__);

		$moFile = $dir . '/languages/' . $domain . '/' . $version . '/' . WPLANG . '.mo';

		// if specific version MO file is not available point to the current public release (cpr) version 
		if(!is_readable($moFile)) {
			$moFile = $dir . '/languages/' . $domain . '/cpr/' . WPLANG . '.mo';
		}

		return $moFile;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms translate datepicker
	 */
	public static function translateDatepicker() {
		if(wp_script_is('gforms_ui_datepicker')) {
			// @see http://code.google.com/p/jquery-ui/source/browse/trunk/ui/i18n/jquery.ui.datepicker-nl.js
			$srcUrl = plugins_url('js/jquery.ui.datepicker-nl.js', __FILE__);

			wp_enqueue_script('gforms_ui_datepicker_nl', $srcUrl, array('gforms_ui_datepicker'), false, true);
	    }
	}
}

GravityFormsNL::bootstrap();
