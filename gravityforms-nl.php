<?php
/*
Plugin Name: Gravity Forms (nl)
Plugin URI: http://pronamic.eu/wordpress/gravityforms-nl/
Description: <strong>Gravity Forms</strong> public 1.5.2 | <strong>User Registration Add-On</strong> 1.0 | Extends the Gravity Forms plugin and add-ons with the Dutch language 
Version: 2.4.2
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

		add_filter('plugin_row_meta', array(__CLASS__, 'pluginRowMeta'), 10, 4);
	}

	////////////////////////////////////////////////////////////

	/**
	 * Plugin row meta
	 * 
	 * @param array $meta
	 * @param string $file
	 * @param unknown $data
	 * @param unknown $status
	 */
	public static function pluginRowMeta($meta, $file, $data, $status) {
		if($file == plugin_basename(__FILE__)) {
			$share = '<div style="margin-top: .5em;">';
			
			// UTM
			$utm = array(
				'utm_medium' => 'wp-admin' , 
				'utm_campaign' => 'WordPress plugins' ,
				'utm_content' => self::PLUGIN_NAME
			);

			$utm = array_map('rawurlencode', $utm);

			// Twitter, we use the iframe solution, because the JavaScript soluction had some issies with Facebook
			// @see http://dev.twitter.com/pages/tweet_button
			$utm['utm_source'] = 'twitter';
			$url = add_query_arg($utm, self::PLUGIN_URL_PAGE);

			$share .= sprintf('<a href="http://twitter.com/share" class="twitter-share-button" data-url="%s" data-via="%s" data-text="%s" data-related="%s" data-count="horizontal">Tweet</a>', 
				esc_url($url) , 
				esc_attr('pronamic') , 
				esc_attr(sprintf('Check out the "%s" #WordPress plugin', self::PLUGIN_NAME)) , 
				esc_attr('remcotolsma:' . sprintf('Devloper of the "%s" plugin', self::PLUGIN_NAME))  
			);

			$share .= '<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';

			// Facebook
			// @see http://developers.facebook.com/docs/reference/plugins/like/
			$utm['utm_source'] = 'facebook';
			$url = add_query_arg($utm, self::PLUGIN_URL_PAGE);

			$languages = array('en_US', 'fr_FR', 'nl_NL');

			$share .= sprintf('<script src="http://connect.facebook.net/%s/all.js#xfbml=1"></script>',
				in_array(WPLANG, $languages) ? WPLANG : 'en_US'
			);

			$share .= sprintf('<fb:like href="%s" show_faces="false" width="450" font=""></fb:like>', 
				esc_url($url) 
			);

			$share .= '</div>';

			$meta[] = $share;
		}

		return $meta;
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
		$isGravityFormsUserRegistration = ($domain == 'gravityformsuserregistration' || $domain == 'gravityforms_user_registration');
		if($isDutch && $isGravityFormsUserRegistration) {
			// Unfortunately the static var GFUser::$version is private
			$version = get_option('gf_user_registration_version');

			$moFile = self::getMoFile('gravityformsuserregistration', $version);
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
			$srcUrl = plugins_url('js/jquery.ui.datepicker-nl.js', __FILE__);
	
			wp_enqueue_script('gforms_ui_datepicker_nl', $srcUrl, array('gforms_ui_datepicker'), false, true);
	    }
	}
}

GravityFormsNL::bootstrap();
