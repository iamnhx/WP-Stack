<?php

// Subpackage namespace
namespace RISE\ClearCaches\Helpers;

// Aliased namespaces
use RISE\ClearCaches\Notices;

// Block direct calls
if (!function_exists('add_action')) {
	die;
}

/**
 * Boot class
 *
 * @package WordPress Plugin
 * @subpackage Helpers
 */
final class Boot {



	/**
	 * Single class instance
	 */
	private static $instance;



	/**
	 * Create or retrieve instance
	 */
	final public static function instance($file, $class = 'Core\Core', $method = 'instance') {

		// Check instance
		if (!isset(self::$instance)) {
			self::$instance = new self($file, $class, $method);
		}

		// Done
		return self::$instance;
	}



	/**
	 * Disallow clone use and overwriting
	 */
	final private function __clone() {}



	/**
	 * Constructor
	 */
	final private function __construct($file, $class, $method) {

		// Plugin directory
		$directory = dirname($file);

		// Load config file
		$config = @include $directory.'/config.php';
		if (!empty($config) && is_array($config)) {

			// Boot check
			require_once $directory.'/notices/boot-check-php.php';

			// Loader
			require_once $directory.'/helpers/loader.php';

		// No config
		} else {

			// Loader
			require_once $directory.'/helpers/loader.php';
		}

		// Run the main class
		Runner::start($class, $method);
	}



}