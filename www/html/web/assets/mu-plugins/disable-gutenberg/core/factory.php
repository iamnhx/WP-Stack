<?php

// Subpackage namespace
namespace RISE\DisableGutenberg\Core;

// Aliased namespaces
use \RISE\DisableGutenberg\Helpers;
use \RISE\DisableGutenberg\Gutenberg;

/**
 * Object Factory class
 *
 * @package Disable Gutenberg
 * @subpackage Core
 */
class Factory extends Helpers\Factory {



	/**
	 * A Gutenberg detector instance
	 */
	protected function createDetector() {
		return Gutenberg\Detector::instance($this->plugin);
	}



	/**
	 * Create Disabler object
	 */
	protected function createDisabler() {
		return new Gutenberg\Disabler($this->plugin->factory->detector);
	}



	/**
	 * Create Styles object
	 */
	protected function createStyles() {
		return new Gutenberg\Styles;
	}



}