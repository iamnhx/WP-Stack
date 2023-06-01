<?php
/*
Plugin Name: Custom Functions
Description: Enables the ability to input custom WordPress functions such as filters in a centralized place to avoid the dependence on a theme functions.php file.
Version: 1.0.0
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: CSTMFN
*/

// Plugin namespace
namespace RISE\CustomFunctions;

// Aliased namespaces
use RISE\CustomFunctions\Notices;

// Block direct calls
if (!function_exists('add_action'))
	die;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'cstmfn';
const VERSION = '1.0.0';

// Loader
require_once dirname(FILE).'/helpers/loader.php';

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');
