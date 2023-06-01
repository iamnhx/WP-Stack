<?php
/*
Plugin Name: Disable XML-RPC
Description: Completely disables all XML-RPC related functions in WordPress including pingbacks and trackbacks, and helps prevent attacks on the xmlrpc.php file.
Version: 1.1.1
Author: Fenix
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
Prefix: DSBXML
*/

// Plugin namespace
namespace RISE\DisableXMLRPC;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'dsbxml';
const VERSION = '1.1.1';

// Block direct calls
if (!function_exists('add_action'))
	die;

/**
 * Define main plugin class
 */
class RISE_Disable_XML_RPC {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * Initalize plugin actions
	 *
	 * @return void
	 */
	public function init() {

		// Remove RSD link from head
		remove_action( 'wp_head', 'rsd_link' );

		// Disable XML-RPC API
		add_filter( 'xmlrpc_enabled', '__return_false' );

		// Force to uncheck pingbck and trackback options
		add_filter( 'pre_option_default_ping_status', '__return_zero' );
		add_filter( 'pre_option_default_pingback_flag', '__return_zero' );

		// Hide options on Discussion page
		add_action( 'admin_enqueue_scripts', array( $this, 'hide_options' ) );

		$this->set_disabled_header();

	}

	/**
	 * Returns plugin base file
	 * @return [type] [description]
	 */
	public static function file() {
		return __FILE__;
	}

	/**
	 * Hide Discussion options with CSS
	 *
	 * @return null
	 */
	public function hide_options( $hook ) {

		if ( 'options-discussion.php' !== $hook ) {
			return;
		}

		wp_add_inline_style( 'dashboard', '.form-table td label[for="default_pingback_flag"], .form-table td label[for="default_pingback_flag"] + br, .form-table td label[for="default_ping_status"], .form-table td label[for="default_ping_status"] + br { display: none; }' );

	}

	/**
	 * Set disabled header for any XML-RPC requests
	 */
	public function set_disabled_header() {

		// Return immediately if SCRIPT_FILENAME not set
		if ( ! isset( $_SERVER['SCRIPT_FILENAME'] ) ) {
			return;
		}

		$file = basename( $_SERVER['SCRIPT_FILENAME'] );

		// Break only if xmlrpc.php file was requested.
		if ( 'xmlrpc.php' !== $file ) {
			return;
		}

		$header = 'HTTP/1.1 403 Forbidden';

		header( $header );
		echo $header;
		die();

	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

/**
 * Returns instance of RISE_Disable_XML_RPC class
 *
 * @return object
 */
function rise_disable_xml_rpc() {
	return RISE_Disable_XML_RPC::get_instance();
}

/**
 * Initalize plugin instance very early on 'init' hook
 */
add_action( 'init', array( rise_disable_xml_rpc(), 'init' ), -999 );
