<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wordpress/gravityforms-nl/
Description: Extends the Gravity Forms plugin and add-ons with the Dutch language: <strong>Gravity Forms</strong> public 1.5.2.8 | <strong>User Registration Add-On</strong> 1.2.6 | <strong>Campaign Monitor Add-On</strong> 1.8 | <strong>MailChimp Add-On</strong> 1.5 | <strong>PayPal Add-On</strong> 1.2.3 
Version: 2.4.8
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
License: GPL
*/

class GravityFormsNL {
	/**
	 * The current langauge
	 * 
	 * @var string
	 */
	private static $language;

	/**
	 * Flag for the dutch langauge, true if current langauge is dutch, false otherwise
	 * 
	 * @var boolean
	 */
	private static $isDutch;

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
		self::$language = get_option('WPLANG', WPLANG);
		self::$isDutch = (self::$language == 'nl' || self::$language == 'nl_NL');

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
		// Gravity Forms
		$isGravityForms = ($domain == 'gravityforms');
		if(self::$isDutch && $isGravityForms) {
			$version = null;
			if(class_exists('GFCommon')) {
				$version = GFCommon::$version;
		}

			$moFile = self::getMoFile('gravityforms', $version);
		}

		// User Registration Add-On
		$isUserRegistrationAddOn = ($domain == 'gravityformsuserregistration' || $domain == 'gravityforms_user_registration');
		if(self::$isDutch && $isUserRegistrationAddOn) {
			// Unfortunately the static var GFUser::$version is private
			$version = get_option('gf_user_registration_version');

			$moFile = self::getMoFile('gravityformsuserregistration', $version);
		}

		// Campaign Monitor Add-On
		$isCampaignMonitorAddOn = ($domain == 'gravityformscampaignmonitor');
		if(self::$isDutch && $isCampaignMonitorAddOn) {
			// Unfortunately the static var GFCampaignMonitor::$version is private
			$version = get_option('gf_campaignmonitor_version');

			$moFile = self::getMoFile('gravityformscampaignmonitor', $version);
		}

		// MailChimp Add-On
		$isMailChimpAddOn = ($domain == 'gravityformsmailchimp');
		if(self::$isDutch && $isMailChimpAddOn) {
			// Unfortunately the static var GFMailChimp::$version is private
			$version = get_option('gf_mailchimp_version');

			$moFile = self::getMoFile('gravityformsmailchimp', $version);
		}
		
		// PayPal Add-On
		$isPayPalAddOn = ($domain == 'gravityformspaypal');
		if(self::$isDutch && $isPayPalAddOn) {
			// Unfortunately the static var GFPayPal::$version is private
			$version = get_option('gf_paypal_version');

			$moFile = self::getMoFile('gravityformspaypal', $version);
		}

		return $moFile;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Get the MO file for the specified domain, version and language
	 */
	public static function getMoFile($domain, $version) {
		$dir = dirname(__FILE__);

		$moFile = $dir . '/languages/' . $domain . '/' . $version . '/' . self::$language . '.mo';

		// if specific version MO file is not available point to the current public release (cpr) version 
		if(!is_readable($moFile)) {
			$moFile = $dir . '/languages/' . $domain . '/cpr/' . self::$language . '.mo';
		}

		return $moFile;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms translate datepicker
	 */
	public static function translateDatepicker() {
		if(self::$isDutch && wp_script_is('gforms_ui_datepicker')) {
			// @see http://code.google.com/p/jquery-ui/source/browse/trunk/ui/i18n/jquery.ui.datepicker-nl.js
			$srcUrl = plugins_url('js/jquery.ui.datepicker-nl.js', __FILE__);

			wp_enqueue_script('gforms_ui_datepicker_nl', $srcUrl, array('gforms_ui_datepicker'), false, true);
		}
	}
}

GravityFormsNL::bootstrap();
