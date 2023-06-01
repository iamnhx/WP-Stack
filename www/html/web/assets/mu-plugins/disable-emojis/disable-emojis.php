<?php
/*
Plugin Name: Disable Emojis
Description: Completely disables both the old and new versions of WordPress emojis, removes the corresponding javascript calls, and improves page loading times.
Version: 1.2.0
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: DSBEMJ
*/

// Plugin namespace
namespace RISE\DisableEmojis;

// Block direct calls
if (!function_exists('add_action'))
	die;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'dsbemj';
const VERSION = '1.2.0';

// Loader
require_once dirname(FILE).'/helpers/loader.php';

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');
