<?php
/**
 * Plugin Name: Hogan Module: Links
 * Plugin URI: https://github.com/dekodeinteraktiv/hogan-links
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/hogan-links
 * Description: Links Module for Hogan
 * Version: 1.0.0-dev
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * * Text Domain: hogan-links
 * Domain Path: /languages/
 *
 * @package Hogan
 * @author Dekode
 */

declare( strict_types = 1 );
namespace Dekode\Hogan\Links;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\\hogan_links_load_textdomain' );
add_action( 'hogan/include_modules', __NAMESPACE__ . '\\hogan_links_register_module' );

/**
 * Register module text domain
 */
function hogan_links_load_textdomain() {
	load_plugin_textdomain( 'hogan-links', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

/**
 * Register module in Hogan
 */
function hogan_links_register_module() {
	require_once 'class-links.php';
	require_once 'includes/template-tags.php';
	hogan_register_module( new \Dekode\Hogan\Links() );
}
