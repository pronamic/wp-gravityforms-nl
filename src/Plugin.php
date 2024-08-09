<?php
/**
 * Plugin Gravity Forms (nl).
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\GravityFormsNL
 */

namespace Pronamic\WordPress\GravityFormsNL;

/**
 * Plugin.
 *
 * @author  Remco Tolsma
 * @version 3.0.1
 * @since   1.0.0
 */
class Plugin {
	/**
	 * Plugin file.
	 *
	 * @var string
	 */
	private $plugin_file;

	/**
	 * Version.
	 *
	 * @var string
	 */
	private $version = '';

	/**
	 * Current language.
	 *
	 * @var string|null
	 */
	private $language;

	/**
	 * Flag for the Dutch language.
	 *
	 * @var boolean
	 */
	private $is_dutch;

	/**
	 * Instance.
	 *
	 * @var Plugin|null
	 */
	protected static $instance;

	/**
	 * Instance.
	 *
	 * @param string|array<string, mixed>|object $args The plugin arguments.
	 *
	 * @return Plugin
	 */
	public static function instance( $args = [] ) {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self( $args );
		}

		return self::$instance;
	}

	/**
	 * Construct and initialize.
	 *
	 * @param string|array<string, mixed>|object $args Plugin arguments.
	 */
	public function __construct( $args ) {
		$args = wp_parse_args(
			$args,
			[
				'file'    => __DIR__ . '/../gravityforms-nl.php',
				'options' => [],
			]
		);

		// Version from plugin file header.
		if ( null !== $args['file'] ) {
			$file_data = get_file_data( $args['file'], [ 'Version' => 'Version' ] );

			if ( \array_key_exists( 'Version', $file_data ) ) {
				$this->version = (string) $file_data['Version'];
			}
		}

		$this->plugin_file = $args['file'];
		$this->is_dutch    = false;

		// Actions.
		\add_action( 'init', [ $this, 'init' ] );
		\add_action( 'wp_print_scripts', [ $this, 'wp_print_scripts' ] );

		// Filters.
		\add_filter( 'gform_currencies', [ $this, 'gform_currencies' ] );
		\add_filter( 'gform_address_types', [ $this, 'gform_address_types' ] );
		\add_filter( 'gform_address_display_format', [ $this, 'gform_address_display_format' ] );
	}

	/**
	 * Initialize.
	 *
	 * @return void
	 */
	public function init() {
		$rel_path = \dirname( \plugin_basename( $this->plugin_file ) ) . '/languages/';

		// Determine language.
		if ( null === $this->language ) {
			$this->language = \get_locale();
			$this->is_dutch = \in_array( $this->language, [ 'nl', 'nl_NL', 'nl_NL_formal' ], true );
		}

		// The `ICL_LANGUAGE_CODE` constant is defined from a plugin.
		if ( \defined( 'ICL_LANGUAGE_CODE' ) ) {
			$this->is_dutch = ( 'nl' === ICL_LANGUAGE_CODE );
		}

		// Load plugin text domain.
		\load_plugin_textdomain( 'gravityforms-nl', false, $rel_path );
	}

	/**
	 * Gravity Forms datepicker translation.
	 *
	 * @return void
	 */
	public function wp_print_scripts() {
		if ( ! $this->is_dutch ) {
			return;
		}

		/**
		 * Filter `gforms_ui_datepicker` » @since ?
		 * Filter `gforms_datepicker` » @since Gravity Forms 1.7.5
		 * Filter `gform_datepicker_init` » @since Gravity Forms 1.8.9
		 */
		foreach ( [ 'gforms_ui_datepicker', 'gforms_datepicker', 'gform_datepicker_init' ] as $script_datepicker ) {
			if ( ! \wp_script_is( $script_datepicker ) ) {
				continue;
			}

			// @link http://code.google.com/p/jquery-ui/source/browse/trunk/ui/i18n/jquery.ui.datepicker-nl.js
			// @link https://github.com/jquery/jquery-ui/blob/master/ui/i18n/jquery.ui.datepicker-nl.js
			$src = \plugins_url( 'js/jquery.ui.datepicker-nl.js', $this->plugin_file );

			\wp_enqueue_script( 'gforms_ui_datepicker_nl', $src, [ $script_datepicker ], $this->version, true );
		}
	}

	/**
	 * Update Euro currency.
	 *
	 * @param array<string, array<string, string|int>> $currencies Currencies.
	 * @return array<string, array<string, string|int>>
	 */
	public function gform_currencies( $currencies ) {
		if ( ! $this->is_dutch ) {
			return $currencies;
		}

		// Euro currency definition.
		$euro = [
			'name'               => __( 'Euro', 'gravityforms-nl' ),
			'symbol_left'        => '€',
			'symbol_right'       => '',
			'symbol_padding'     => ' ',
			'thousand_separator' => '.',
			'decimal_separator'  => ',',
			'decimals'           => 2,
		];

		// Only move symbol if currency already exists.
		if ( \array_key_exists( 'EUR', $currencies ) ) {
			$euro = \wp_parse_args(
				[
					'symbol_left'  => '€',
					'symbol_right' => '',
				],
				$currencies['EUR']
			);
		}

		$currencies['EUR'] = $euro;

		return $currencies;
	}

	/**
	 * Add Dutch address types.
	 *
	 * @param array<string, array<mixed>> $address_types Address types.
	 * @return array<string, array<mixed>>
	 * @link http://www.gravityhelp.com/forums/topic/add-custom-field-to-address-field-set
	 */
	public function gform_address_types( $address_types ) {
		$address_types['dutch'] = [
			'label'       => \apply_filters( 'pronamic_gravityforms_nl_address_label', _x( 'Dutch', 'Dutch address type', 'gravityforms-nl' ) ),
			'country'     => \apply_filters( 'pronamic_gravityforms_nl_address_country', _x( 'Netherlands', 'Dutch address type', 'gravityforms-nl' ) ),
			'zip_label'   => \apply_filters( 'pronamic_gravityforms_nl_address_zip_label', _x( 'Postal Code', 'Dutch address type', 'gravityforms-nl' ) ),
			'state_label' => \apply_filters( 'pronamic_gravityforms_nl_address_state_label', _x( 'Province', 'Dutch address type', 'gravityforms-nl' ) ),
			'states'      => \array_merge( [ '' ], \apply_filters( 'pronamic_gravityforms_nl_address_states', self::get_dutch_provinces() ) ),
		];

		return $address_types;
	}

	/**
	 * Get Dutch provinces.
	 *
	 * @return array<int, string>
	 */
	public static function get_dutch_provinces() {
		return [
			__( 'Drenthe', 'gravityforms-nl' ),
			__( 'Flevoland', 'gravityforms-nl' ),
			__( 'Friesland', 'gravityforms-nl' ),
			__( 'Gelderland', 'gravityforms-nl' ),
			__( 'Groningen', 'gravityforms-nl' ),
			__( 'Limburg', 'gravityforms-nl' ),
			__( 'Noord-Brabant', 'gravityforms-nl' ),
			__( 'Noord-Holland', 'gravityforms-nl' ),
			__( 'Overijssel', 'gravityforms-nl' ),
			__( 'Utrecht', 'gravityforms-nl' ),
			__( 'Zeeland', 'gravityforms-nl' ),
			__( 'Zuid-Holland', 'gravityforms-nl' ),
		];
	}

	/**
	 * Address display format.
	 *
	 * @param string $format Address display format.
	 * @return string
	 * @link http://www.gravityhelp.com/documentation/page/Gform_address_display_format
	 */
	public function gform_address_display_format( $format ) {
		if ( $this->is_dutch ) {
			return 'zip_before_city';
		}

		return $format;
	}
}
