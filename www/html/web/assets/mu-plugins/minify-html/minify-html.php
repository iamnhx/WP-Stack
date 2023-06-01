<?php
/*
Plugin Name: Minify HTML
Description: Tactfully minifies HTML output and markup to remove line breaks, whitespace, comments, and other code bloat to cleanup source code and improve speed.
Version: 1.0.1
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: MNFHTM
*/

// Plugin namespace
namespace RISE\MinifyHTML;

// Aliased namespaces
use RISE\MinifyHTML\Notices;

// Block direct calls
if (!function_exists('add_action')) {
	die;
}

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'mnfhtm';
const VERSION = '1.0.1';

// Loader
require_once dirname(FILE).'/helpers/loader.php';

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');
