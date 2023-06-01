<?php
/*
Plugin Name: Disable Gutenberg
Description: Completely disables the Gutenberg block editor and enables the classic WordPress post editor (TinyMCE aka WYSIWYG) for lighter coding and simplicity.
Version: 1.1.0
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: DSBGTB
*/

// Plugin namespace
namespace RISE\DisableGutenberg;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'dsbgtb';
const VERSION = '1.1.0';
const REPO = 'rise/disable-gutenberg';

// Boot
require_once dirname(FILE).'/helpers/boot.php';
Helpers\Boot::instance(FILE);