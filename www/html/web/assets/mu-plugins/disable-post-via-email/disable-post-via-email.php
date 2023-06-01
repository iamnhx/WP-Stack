<?php
/*
Plugin Name: Disable Post Via Email
Description: Completely disables and hides the Post Via Email feature included in WordPress core for stronger security and to simplify the backend settings page.
Version: 1.0.0
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: DPVEML
*/

// Plugin namespace
namespace RISE\DisablePostViaEmail;

// Aliased namespaces
use RISE\DisablePostViaEmail\Notices;

// Block direct calls
if (!function_exists('add_action'))
	die;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'dpveml';
const VERSION = '1.0.0';

// Loader
require_once dirname(FILE).'/helpers/loader.php';

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');
