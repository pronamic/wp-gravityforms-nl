<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wp-plugins/gravityforms-nl/
Description: Extends the Gravity Forms plugin and add-ons with the Dutch language: <strong>Gravity Forms</strong> 1.6.12 | <strong>User Registration Add-On</strong> 1.4 | <strong>Campaign Monitor Add-On</strong> 2.0 | <strong>MailChimp Add-On</strong> 1.7 | <strong>PayPal Add-On</strong> 1.6 | <strong>Signature Add-On</strong> 1.2 | <strong>Polls Add-On</strong> 1.0

Version: 2.7
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

		add_filter( 'gform_admin_pre_render',       array( __CLASS__, 'gform_admin_pre_render' ) );
		add_filter( 'gform_currencies',             array( __CLASS__, 'gform_currencies' ) );
		add_filter( 'gform_address_types',          array( __CLASS__, 'gform_address_types' ) );
		add_filter( 'gform_address_display_format', array( __CLASS__, 'gform_address_display_format' ) );

		add_action( 'wp_print_scripts',       array( __CLASS__, 'wp_print_scripts' ) );

		/*
		 * @since Gravity Forms v1.6.12
		 * 
		 * Gravity Forms don't execute the load_plugin_textdomain() in the 'init'
		 * action, therefor we have to make sure this plugin will load first
		 * 
		 * @see http://stv.whtly.com/2011/09/03/forcing-a-wordpress-plugin-to-be-loaded-before-all-other-plugins/
		 */ 
		add_action( 'activated_plugin',       array( __CLASS__, 'activated_plugin' ) );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Activated plugin
	 */
	function activated_plugin() {
		$path = str_replace( WP_PLUGIN_DIR . '/', '', __FILE__ );

		if ( $plugins = get_option( 'active_plugins' ) ) {
			if ( $key = array_search( $path, $plugins ) ) {
				array_splice( $plugins, $key, 1 );
				array_unshift( $plugins, $path );

				update_option( 'active_plugins', $plugins );
			}
		}
	}

	////////////////////////////////////////////////////////////

	/**
	 * Initialize
	 */
	public static function init() {		
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
		if ( self::$language == null ) {
			self::$language = get_option( 'WPLANG', WPLANG );
			self::$is_dutch = ( self::$language == 'nl' || self::$language == 'nl_NL' );
		}

		// The ICL_LANGUAGE_CODE constant is defined from an plugin, so this constant
		// is not always defined in the first 'load_textdomain_mofile' filter call
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			self::$is_dutch = ( ICL_LANGUAGE_CODE == 'nl' );
		}

		if ( self::$is_dutch ) {
			$domains = array(
				'gravityforms',
				'gravityformscampaignmonitor',
				'gravityformsmailchimp',
				'gravityformspaypal',
				'gravityformspolls',
				'gravityformssignature',
				'gravityformsuserregistration'
			);

			if ( in_array( $domain, $domains ) ) {
				$mo_file = self::get_mo_file( $domain );
			}
		}

		return $mo_file;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Get the MO file for the specified domain, version and language
	 * 
	 * @param string $domain
	 * @return string
	 */
	private static function get_mo_file( $domain ) {
		$dir = dirname( __FILE__ );

		$mo_file = $dir . '/languages/' . $domain . '/' . self::$language . '.mo';

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

	////////////////////////////////////////////////////////////

	/**
	 * Address types
	 * 
	 * @param array $address_types
	 */
	public static function gform_address_types( $address_types ) {
		// @see http://www.gravityhelp.com/forums/topic/add-custom-field-to-address-field-set
		$address_types['dutch'] = array(
			'label'       => __( 'Dutch', 'gravityforms_nl' ),
			'country'     => __( 'Netherlands', 'gravityforms_nl' ),
			'zip_label'   => __( 'Postal Code', 'gravityforms_nl' ),
			'state_label' => __( 'Province', 'gravityforms_nl' ),
			'states'      => array(
				__( 'Drenthe', 'gravityforms_nl' ),
				__( 'Flevoland', 'gravityforms_nl' ),
				__( 'Friesland', 'gravityforms_nl' ),
				__( 'Gelderland', 'gravityforms_nl' ),
				__( 'Groningen', 'gravityforms_nl' ),
				__( 'Limburg', 'gravityforms_nl' ),
				__( 'Noord-Brabant', 'gravityforms_nl' ),
				__( 'Noord-Holland', 'gravityforms_nl' ),
				__( 'Overijssel', 'gravityforms_nl' ),
				__( 'Utrecht', 'gravityforms_nl' ),
				__( 'Zeeland', 'gravityforms_nl' ),
				__( 'Zuid-Holland', 'gravityforms_nl' )
			)
		);

		return $address_types; 
	}

	////////////////////////////////////////////////////////////

	/**
	 * Address display format
	 * 
	 * @see http://www.gravityhelp.com/documentation/page/Gform_address_display_format
	 * @param array $address_types
	 */
	public static function gform_address_display_format( $format ) {
		if ( self::$is_dutch ) {
			return 'zip_before_city';
		}
		
		return $format;
	}
}

GravityFormsNL::bootstrap();
