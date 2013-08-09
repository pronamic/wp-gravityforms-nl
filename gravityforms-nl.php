<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wordpress-plugins/gravity-forms-nl/
Description: Extends the Gravity Forms plugin and add-ons with the Dutch language: <strong>Gravity Forms</strong> 1.7.7 | <strong>User Registration Add-On</strong> 1.6 | <strong>Campaign Monitor Add-On</strong> 2.1 | <strong>MailChimp Add-On</strong> 2.3 | <strong>PayPal Add-On</strong> 1.8 | <strong>Signature Add-On</strong> 1.3 | <strong>Polls Add-On</strong> 1.5

Version: 2.7.8
Requires at least: 3.0

Author: Pronamic
Author URI: http://pronamic.eu/

Text Domain: gravityforms_nl
Domain Path: /languages/

License: GPL

GitHub URI: https://github.com/pronamic/wp-gravityforms-nl
*/

class GravityFormsNLPlugin {
	/**
	 * The plugin file
	 * 
	 * @var string
	 */
	private $file;

	////////////////////////////////////////////////////////////

	/**
	 * The current langauge
	 * 
	 * @var string
	 */
	private $language;

	/**
	 * Flag for the dutch langauge, true if current langauge is dutch, false otherwise
	 * 
	 * @var boolean
	 */
	private $is_dutch;

	////////////////////////////////////////////////////////////

	/**
	 * Construct and intialize
	 */
	public function __construct( $file ) {
		$this->file = $file;

		// Priority is set to 8, beceasu the Signature Add-On is using priority 9
		add_action( 'init', array( $this, 'init' ), 8 );

		add_filter( 'load_textdomain_mofile', array( $this, 'load_textdomain_mofile' ), 10, 2 );

		add_filter( 'gform_admin_pre_render',       array( $this, 'gform_admin_pre_render' ) );
		add_filter( 'gform_currencies',             array( $this, 'gform_currencies' ) );
		add_filter( 'gform_address_types',          array( $this, 'gform_address_types' ) );
		add_filter( 'gform_address_display_format', array( $this, 'gform_address_display_format' ) );

		add_action( 'wp_print_scripts', array( $this, 'wp_print_scripts' ) );

		/*
		 * @since Gravity Forms v1.6.12
		 * 
		 * Gravity Forms don't execute the load_plugin_textdomain() in the 'init'
		 * action, therefor we have to make sure this plugin will load first
		 * 
		 * @see http://stv.whtly.com/2011/09/03/forcing-a-wordpress-plugin-to-be-loaded-before-all-other-plugins/
		 */ 
		add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Activated plugin
	 */
	public function activated_plugin() {
		$path = str_replace( WP_PLUGIN_DIR . '/', '', $this->file );

		if ( $plugins = get_option( 'active_plugins' ) ) {
			if ( $key = array_search( $path, $plugins ) ) {
				array_splice( $plugins, $key, 1 );
				array_unshift( $plugins, $path );

				update_option( 'active_plugins', $plugins );
			}
		}
		
		if ( $plugins = get_site_option( 'active_sitewide_plugins' ) ) {
			if ( $key = array_search( $path, $plugins ) ) {
				array_splice( $plugins, $key, 1 );
				array_unshift( $plugins, $path );
		
				update_site_option( 'active_sitewide_plugins', $plugins );
			}
		}
	}

	////////////////////////////////////////////////////////////

	/**
	 * Initialize
	 */
	public function init() {		
		$rel_path = dirname( plugin_basename( $this->file ) ) . '/languages/';

		// Determine language
		if ( $this->language == null ) {
			$this->language = get_option( 'WPLANG', WPLANG );
			$this->is_dutch = ( $this->language == 'nl' || $this->language == 'nl_NL' );
		}
		
		// The ICL_LANGUAGE_CODE constant is defined from an plugin, so this constant
		// is not always defined in the first 'load_textdomain_mofile' filter call
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$this->is_dutch = ( ICL_LANGUAGE_CODE == 'nl' );
		}

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
	public function load_textdomain_mofile( $mo_file, $domain ) {
		// First do quick check if an Dutch .MO file is loaded
		if ( strpos( $mo_file, 'nl_NL.mo' ) !== false ) {
			$domains = array(
				// @see https://github.com/woothemes/woocommerce/tree/v2.0.5
				'gravityforms'                 => array(
					'languages/gravityforms-nl_NL.mo'                 => 'gravityforms/nl_NL.mo'
				),
				'gravityformscampaignmonitor'  => array(
					'languages/gravityformscampaignmonitor-nl_NL.mo'  => 'gravityformscampaignmonitor/nl_NL.mo'
				),
				'gravityformsmailchimp'        => array(
					'languages/gravityformsmailchimp-nl_NL.mo'        => 'gravityformsmailchimp/nl_NL.mo'
				),
				'gravityformspaypal'           => array(
					'languages/gravityformspaypal-nl_NL.mo'           => 'gravityformspaypal/nl_NL.mo'
				),
				'gravityformspolls'            => array(
					'languages/gravityformspolls-nl_NL.mo'            => 'gravityformspolls/nl_NL.mo'
				),
				'gravityformssignature'        => array(
					'languages/gravityformssignature-nl_NL.mo'        => 'gravityformssignature/nl_NL.mo'
				),
				'gravityformsuserregistration' => array(
					'languages/gravityformsuserregistration-nl_NL.mo' => 'gravityformsuserregistration/nl_NL.mo'
				)
			);
			
			if ( isset( $domains[$domain] ) ) {
				$paths = $domains[$domain];
			
				foreach ( $paths as $path => $file ) {
					if ( substr( $mo_file, -strlen( $path ) ) == $path ) {
						$new_file = dirname( $this->file ) . '/languages/' . $file;
			
						if ( is_readable( $new_file ) ) {
							$mo_file = $new_file;
						}
					}
				}
			}
		}

		return $mo_file;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms translate datepicker
	 */
	public function wp_print_scripts() {
		if ( $this->is_dutch ) {
			/**
			 * gforms_ui_datepicker » @since ?
			 * gforms_datepicker » @since Gravity Forms 1.7.5
			 */
			foreach ( array( 'gforms_ui_datepicker', 'gforms_datepicker' ) as $script_datepicker ) {
				if ( wp_script_is( $script_datepicker ) ) {
					// @see http://code.google.com/p/jquery-ui/source/browse/trunk/ui/i18n/jquery.ui.datepicker-nl.js
					// @see https://github.com/jquery/jquery-ui/blob/master/ui/i18n/jquery.ui.datepicker-nl.js
					$src = plugins_url( 'js/jquery.ui.datepicker-nl.js', $this->file );

					wp_enqueue_script( 'gforms_ui_datepicker_nl', $src, array( $script_datepicker ), false, true );
				}
			}
		}
	}

	////////////////////////////////////////////////////////////

	/**
	 * Gravity Forms admin pre render
	 */
	public function gform_admin_pre_render( $form ) {
		wp_register_script( 'gravityforms-nl-forms', plugins_url( 'js/forms-nl.js', $this->file ) );

		wp_localize_script( 'gravityforms-nl-forms', 'gravityFormsNlL10n', array(
			'formTitle'           => __( 'Untitled Form', 'gravityforms_nl' ) , 
			'formDescription'     => __( 'We would love to hear from you! Please fill out this form and we will get in touch with you shortly.', 'gravityforms_nl' ) ,  
			'confirmationMessage' => __( 'Thanks for contacting us! We will get in touch with you shortly.', 'gravityforms_nl' ) , 
			'buttonText'          => __( 'Submit', 'gravityforms_nl' )
		) );

		wp_print_scripts( array( 'gravityforms-nl-forms' ) );

		return $form;
	}

	////////////////////////////////////////////////////////////

	/**
	 * Update currency
	 * 
	 * @param array $currencies
	 */
	public function gform_currencies( $currencies ) {
		$currencies['EUR'] = array(
			'name'               => __( 'Euro', 'gravityforms_nl' ), 
			'symbol_left'        => '€',
			'symbol_right'       => '', 
			'symbol_padding'     => ' ',
			'thousand_separator' => '.',
			'decimal_separator'  => ',',
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
	public function gform_address_types( $address_types ) {
		// @see http://www.gravityhelp.com/forums/topic/add-custom-field-to-address-field-set
		$address_types['dutch'] = array(
			'label'       => __( 'Dutch', 'gravityforms_nl' ),
			'country'     => __( 'Netherlands', 'gravityforms_nl' ),
			'zip_label'   => __( 'Postal Code', 'gravityforms_nl' ),
			'state_label' => __( 'Province', 'gravityforms_nl' ),
			'states'      => array_merge( array( '' ), self::get_dutch_provinces() )
		);

		return $address_types; 
	}
	
	////////////////////////////////////////////////////////////
	
	/**
	 * Get list of Dutch provinces
	 * 
	 * @return array
	 */
	public static function get_dutch_provinces() {
		return array(
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
		);	
	}

	////////////////////////////////////////////////////////////

	/**
	 * Address display format
	 * 
	 * @see http://www.gravityhelp.com/documentation/page/Gform_address_display_format
	 * @param array $address_types
	 */
	public function gform_address_display_format( $format ) {
		if ( $this->is_dutch ) {
			return 'zip_before_city';
		}
		
		return $format;
	}
}

global $gravityforms_nl_plugin;

$gravityforms_nl_plugin = new GravityFormsNLPlugin( __FILE__ );
