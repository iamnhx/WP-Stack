<?php

// Subpackage namespace
namespace RISE\LimitHeartbeat\Core;

// Aliased namespaces
use \RISE\LimitHeartbeat\Helpers;
use \RISE\LimitHeartbeat\Heartbeat;

/**
 * Object Factory class
 *
 * @package Limit Heartbeat
 * @subpackage Core
 */
class Factory extends Helpers\Factory {



	/**
	 * Disabler object instance
	 */
	protected function createDisabler() {
		return new Heartbeat\Disabler($this->context());
	}



	/**
	 * Setup object instance
	 */
	protected function createSetup() {
		return new Heartbeat\Setup($this->context());
	}



}