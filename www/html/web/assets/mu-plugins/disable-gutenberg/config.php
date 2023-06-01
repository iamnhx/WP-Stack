<?php

return [



	/**
	 * Boot check PHP configuration
	 */
	'boot-check-php' => [

		/**
		 * Enables the PHP validation
		 */
		'enabled' => true,

		/**
		 * PHP minimum version
		 * Uses version_compare function: http://php.net/manual/en/function.version-compare.php
		 */
		'version-required' => '5.6.0',

		/**
		 * Aborts the plugin activation on WP sandbox generating an error output message
		 */
		'prevent-activation' => false,

		/**
		 * PHP error message
		 *
		 * Used to trigger a user error: It is limited to 1024 bytes in length. Any additional characters beyond 1024 bytes will be truncated
		 * (from PHP documentation: http://php.net/manual/en/function.trigger-error.php)
		 *
		 * Supported variables: %php_current_version% and %php_version_required%
		 */
		'version-message' => '<strong>%plugin%</strong> does not support your outdated PHP version (%php_current_version%). Please update your PHP to at least version 7.0',

	], // End of boot check PHP

]; // End of main array
