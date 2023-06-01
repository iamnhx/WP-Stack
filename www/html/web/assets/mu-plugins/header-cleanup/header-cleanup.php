<?php
/*
Plugin Name: Header Cleanup
Description: Cleans up most of the unnecessary junk meta included by default in the WordPress header including generator, RSD, shortlink, previous and next, etc.
Version: 1.2.0
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: HDRCLN
*/

// Plugin namespace
namespace RISE\HeaderCleanup;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'hdrcln';
const VERSION = '1.2.0';

// Block direct calls
if (!function_exists('add_action'))
	die;

// Loader
require_once dirname(FILE).'/helpers/loader.php';

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');
