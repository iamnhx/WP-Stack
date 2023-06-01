<?php
/*
Plugin Name: Disable Attachment Pages
Description: Completely disables media attachment pages which then become 404 errors to avoid thin content SEO issues and better guard against snoopers and bots.
Version: 1.0.0
Author: Fenix
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Prefix: DSATCH
*/

// Plugin namespace
namespace RISE\DisableAttachmentPages;

// Plugin constants
const FILE = __FILE__;
const PREFIX = 'dsatch';
const VERSION = '1.0.0';

// Boot
require_once dirname(FILE).'/helpers/boot.php';
Helpers\Boot::instance(FILE);
