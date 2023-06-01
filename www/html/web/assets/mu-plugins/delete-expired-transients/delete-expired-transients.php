<?php
/*
Plugin Name: Delete Expired Transients
Description: Deletes all expired transients upon activation and on a daily basis thereafter via WP-Cron to maintain a cleaner database and improve performance.
Version: 1.0.3
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: DLEXTR
*/

// Plugin namespace
namespace RISE\DeleteExpiredTransients;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'dlextr';
const VERSION = '1.0.3';

// Block direct calls
if (!function_exists('add_action'))
	die;

// Plugin loader
require_once dirname(FILE).'/helpers/loader.php';

// Run the main class
Helpers\Runner::start('Core\Core', 'instance');
