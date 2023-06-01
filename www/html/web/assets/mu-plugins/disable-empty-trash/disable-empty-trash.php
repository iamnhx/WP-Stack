<?php
/*
Plugin Name: Disable Empty Trash
Description: Completely disables the automatic trash empty for WordPress posts, custom posts, pages, and comments to avoid data loss and encourage manual emptying.
Version: 1.0.0
Author: Fenix
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/


/**
 * Define main plugin class
 */
class RISE_Disable_Empty_Trash {

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
		remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
	}

	/**
	 * Returns plugin base file
	 *
	 * @return string
	 */
	public static function file() {
		return __FILE__;
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
 * Returns instance of RISE_Disable_Empty_Trash class
 *
 * @return object
 */
function rise_disable_empty_trash() {
	return RISE_Disable_Empty_Trash::get_instance();
}

/**
 * Initalize plugin instance very early on 'init' hook
 */
add_action( 'init', array( rise_disable_empty_trash(), 'init' ), -999 );
