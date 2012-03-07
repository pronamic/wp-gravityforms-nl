<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wp-plugins/gravityforms-nl/
Description: Extends the Gravity Forms plugin and add-ons with the Dutch language: <strong>Gravity Forms</strong> 1.6.3.2 | <strong>User Registration Add-On</strong> 1.3 | <strong>Campaign Monitor Add-On</strong> 1.9 | <strong>MailChimp Add-On</strong> 1.6.1 | <strong>PayPal Add-On</strong> 1.4
Version: 2.5.10
Requires at least: 3.0
Author: Pronamic
Author URI: http://pronamic.eu/
*/

class GravityFormsNL {
	/**
	 * The text domain of this plugin
	 * 
	 * @var string
	 */
	const TEXT_DOMAIN = 'gravityforms-nl';

	////////////////////////////////////////////////////////////

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

		add_filter('gform_admin_pre_render', array(__CLASS__, 'gFormAdminPreRender'));

		add_action('wp_print_scripts', array(__CLASS__, 'translateDatepicker'));
	}

	////////////////////////////////////////////////////////////

	/**
	 * Initialize
	 */
	public static function init() {		
		// Constants
		self::$language = get_option('WPLANG', WPLANG);
		self::$isDutch = (self::$language == 'nl' || self::$language == 'nl_NL');
		
		if(defined('ICL_LANGUAGE_CODE')) {
			self::$isDutch = ICL_LANGUAGE_CODE == 'nl';
		}

		$relPath = dirname(plugin_basename(__FILE__)) . '/languages/';

		// Load plugin text domain - Gravity Forms (nl)
		load_plugin_textdomain(self::TEXT_DOMAIN, false, $relPath);

		// Load plugin text domain - Gravity Forms user registration Add-On
		load_plugin_textdomain('gravityformsuserregistration', false, $relPath);
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

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms admin pre render
	 */
	public static function gFormAdminPreRender($form) {
		wp_register_script('gravityforms-nl-forms', plugins_url('js/forms-nl.js', __FILE__));

		wp_localize_script('gravityforms-nl-forms', 'gravityFormsNlL10n', array(
			'formTitle' => __('Untitled Form', self::TEXT_DOMAIN) , 
			'formDescription' => __('We would love to hear from you! Please fill out this form and we will get in touch with you shortly.', self::TEXT_DOMAIN) ,  
			'confirmationMessage' => __('Thanks for contacting us! We will get in touch with you shortly.', self::TEXT_DOMAIN) , 
			'buttonText' => __('Submit', self::TEXT_DOMAIN)
		));
		
		wp_print_scripts(array('gravityforms-nl-forms'));
		
		return $form;
	}
}

GravityFormsNL::bootstrap();
