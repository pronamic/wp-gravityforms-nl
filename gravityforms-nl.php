<?php
/**
 * Plugin Name: Gravity Forms (nl)
 * Plugin URI: https://www.pronamic.eu/plugins/gravityforms-nl/
 * Description: Extend the Gravity Forms plugin with Dutch address and Euro sign notation.
 *
 * Version: 3.0.0
 * Requires at least: 3.0
 *
 * Author: Pronamic
 * Author URI: https://www.pronamic.eu/
 *
 * Text Domain: gravityforms-nl
 * Domain Path: /languages/
 *
 * License: GPL
 *
 * GitHub URI: https://github.com/pronamic/wp-gravityforms-nl
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2020 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

/**
 * Bootstrap.
 */
\Pronamic\WordPress\GravityFormsNL\Plugin::instance(
	array(
		'file' => __FILE__,
	)
);

// Backwards compatibility.
global $gravityforms_nl_plugin;

$gravityforms_nl_plugin = \Pronamic\WordPress\GravityFormsNL\Plugin::instance();
