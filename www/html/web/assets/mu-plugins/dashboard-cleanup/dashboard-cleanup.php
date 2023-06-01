<?php
/*
Plugin Name: Dashboard Cleanup
Description: Cleans up the WP Admin backend by disabling various core WP and WC bloat features including Automattic spam, nag notices, tracking, and other items.
Version: 1.1.2
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: DSHCLN
*/

// Plugin namespace
namespace RISE\DashboardCleanup;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'dshcln';
const VERSION = '1.1.2';
const REPO = 'rise/dashboard-cleanup';

// Boot
require_once dirname(FILE).'/helpers/boot.php';
Helpers\Boot::instance(FILE);
