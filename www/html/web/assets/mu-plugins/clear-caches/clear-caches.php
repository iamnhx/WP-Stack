<?php
/*
Plugin Name: Clear Caches
Description: The easiest way to clear caches including WordPress cache, PHP Opcache, Nginx cache, Transient cache, Varnish cache, and object cache (e.g. Redis).
Version: 1.2.1
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: CLRCHS
*/

// Plugin namespace
namespace RISE\ClearCaches;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'clrchs';
const VERSION = '1.2.1';
const REPO = 'rise/clear-caches';

// Boot
require_once dirname(FILE).'/helpers/boot.php';
Helpers\Boot::instance(FILE);
