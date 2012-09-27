<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wp-plugins/gravityforms-nl/
Description: Extends the Gravity Forms plugin and add-ons with the Dutch language: <strong>Gravity Forms</strong> 1.6.7 | <strong>User Registration Add-On</strong> 1.4 | <strong>Campaign Monitor Add-On</strong> 2.0 | <strong>MailChimp Add-On</strong> 1.7 | <strong>PayPal Add-On</strong> 1.5 | <strong>Signature Add-On</strong> 1.2 | <strong>Polls Add-On</strong> 1.0

Version: 2.6.11
Requires at least: 3.0

Author: Pronamic
Author URI: http://pronamic.eu/

Text Domain: gravityforms_nl
Domain Path: /languages/

License: GPL

GitHub URI: https://github.com/pronamic/wp-gravityforms-nl
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
	private static $is_dutch;

	////////////////////////////////////////////////////////////

	/**
	 * Bootstrap
	 */
	public static function bootstrap() {
		// Priority is set to 8, beceasu the Signature Add-On is using priority 9
		add_action( 'init',                   array( __CLASS__, 'init' ), 8 );

		add_filter( 'load_textdomain_mofile', array( __CLASS__, 'load_textdomain_mofile' ), 10, 2 );

		add_filter( 'gform_admin_pre_render', array( __CLASS__, 'gform_admin_pre_render' ) );
		add_filter( 'gform_currencies',       array( __CLASS__, 'gform_currencies' ) );

		add_action( 'wp_print_scripts',       array( __CLASS__, 'wp_print_scripts' ) );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Initialize
	 */
	public static function init() {		
		// Constants
		self::$language = get_option( 'WPLANG', WPLANG );
		self::$is_dutch = ( self::$language == 'nl' || self::$language == 'nl_NL' );
		
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			self::$is_dutch = ICL_LANGUAGE_CODE == 'nl';
		}

		$rel_path = dirname( plugin_basename( __FILE__ ) ) . '/languages/';

		// Load plugin text domain - Gravity Forms (nl)
		load_plugin_textdomain( 'gravityforms_nl', false, $rel_path );

		// Load plugin text domain - Gravity Forms user registration Add-On
		load_plugin_textdomain( 'gravityformsuserregistration', false, $rel_path );
	}

	////////////////////////////////////////////////////////////
	
	/**
	 * Load text domain MO file
	 * 
	 * @param string $moFile
	 * @param string $domain
	 */
	public static function load_textdomain_mofile( $mo_file, $domain ) {
		if ( self::$is_dutch ) {
			// Gravity Forms
			$is_gravity_forms = ( $domain == 'gravityforms' );
			if ( $is_gravity_forms ) {
				$version = null;
				if ( class_exists( 'GFCommon' ) ) {
					$version = GFCommon::$version;
				}
	
				$mo_file = self::get_mo_file( 'gravityforms', $version );
			}
	
			// User Registration Add-On
			$is_user_registration_addon = ( $domain == 'gravityformsuserregistration' || $domain == 'gravityforms_user_registration' );
			if ( $is_user_registration_addon ) {
				// Unfortunately the static var GFUser::$version is private
				$version = get_option( 'gf_user_registration_version' );
	
				$mo_file = self::get_mo_file( 'gravityformsuserregistration', $version );
			}
	
			// Campaign Monitor Add-On
			$is_campaign_monitor_addon = ( $domain == 'gravityformscampaignmonitor' );
			if ( $is_campaign_monitor_addon ) {
				// Unfortunately the static var GFCampaignMonitor::$version is private
				$version = get_option( 'gf_campaignmonitor_version' );
	
				$mo_file = self::get_mo_file( 'gravityformscampaignmonitor', $version );
			}
	
			// MailChimp Add-On
			$is_mailchimp_addon = ( $domain == 'gravityformsmailchimp' );
			if ( $is_mailchimp_addon ) {
				// Unfortunately the static var GFMailChimp::$version is private
				$version = get_option( 'gf_mailchimp_version' );
	
				$mo_file = self::get_mo_file( 'gravityformsmailchimp', $version );
			}
	
			// PayPal Add-On
			$is_paypal_addon = ( $domain == 'gravityformspaypal' );
			if ( $is_paypal_addon ) {
				// Unfortunately the static var GFPayPal::$version is private
				$version = get_option( 'gf_paypal_version' );
	
				$mo_file = self::get_mo_file( 'gravityformspaypal', $version );
			}
			
			// Signature Add-On
			$is_signature_addon = ( $domain == 'gravityformssignature' );
			if ( $is_signature_addon ) {
				// Unfortunately the static var GFSignature::$version is private
				$version = get_option( 'gf_signature_version' );
	
				$mo_file = self::get_mo_file( 'gravityformssignature', $version );
			}
			
			// Polls Add-On
			$is_polls_addon = ( $domain == 'gravityformspolls' );
			if ( $is_polls_addon ) {
				// Unfortunately the static var GFPolls::$version is private
				$version = 'cpr'; // there is no way to retrieve the version
	
				$mo_file = self::get_mo_file( 'gravityformspolls', $version );
			}
		}

		return $mo_file;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Get the MO file for the specified domain, version and language
	 * 
	 * @param string $domain
	 * @param string $version
	 * @return string
	 */
	private static function get_mo_file( $domain, $version ) {
		$dir = dirname( __FILE__ );

		$mo_file = $dir . '/languages/' . $domain . '/' . $version . '/' . self::$language . '.mo';

		// if specific version MO file is not available point to the current public release (cpr) version 
		if ( ! is_readable( $mo_file ) ) {
			$mo_file = $dir . '/languages/' . $domain . '/cpr/' . self::$language . '.mo';
		}

		return $mo_file;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms translate datepicker
	 */
	public static function wp_print_scripts() {
		if ( self::$is_dutch && wp_script_is( 'gforms_ui_datepicker' ) ) {
			// @see http://code.google.com/p/jquery-ui/source/browse/trunk/ui/i18n/jquery.ui.datepicker-nl.js
			// @see https://github.com/jquery/jquery-ui/blob/master/ui/i18n/jquery.ui.datepicker-nl.js
			$src = plugins_url( 'js/jquery.ui.datepicker-nl.js', __FILE__ );

			wp_enqueue_script( 'gforms_ui_datepicker_nl', $src, array( 'gforms_ui_datepicker' ), false, true );
		}
	}

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms admin pre render
	 */
	public static function gform_admin_pre_render( $form ) {
		wp_register_script( 'gravityforms-nl-forms', plugins_url( 'js/forms-nl.js', __FILE__ ) );

		wp_localize_script( 'gravityforms-nl-forms', 'gravityFormsNlL10n', array(
			'formTitle'           => __( 'Untitled Form', 'gravityforms_nl' ) , 
			'formDescription'     => __( 'We would love to hear from you! Please fill out this form and we will get in touch with you shortly.', 'gravityforms_nl' ) ,  
			'confirmationMessage' => __( 'Thanks for contacting us! We will get in touch with you shortly.', 'gravityforms_nl' ) , 
			'buttonText'          => __( 'Submit', 'gravityforms_nl' )
		));

		wp_print_scripts( array( 'gravityforms-nl-forms' ) );

		return $form;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Update currency
	 * 
	 * @param array $currencies
	 */
	public static function gform_currencies( $currencies ) {
		$currencies['EUR'] = array(
			'name'               => __( 'Euro', 'gravityforms_nl' ) ,  
			'symbol_left'        => '€' , 
			'symbol_right'       => '' ,  
			'symbol_padding'     => ' ' , 
			'thousand_separator' => '.' , 
			'decimal_separator'  => ',' , 
			'decimals'           => 2
		);

		return $currencies; 
	}
}

GravityFormsNL::bootstrap();
