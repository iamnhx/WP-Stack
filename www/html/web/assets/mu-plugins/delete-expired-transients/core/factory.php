<?php

// Subpackage namespace
namespace RISE\DeleteExpiredTransients\Core;

// Aliased namespaces
use \RISE\DeleteExpiredTransients\Transients;
use \RISE\DeleteExpiredTransients\Helpers;

/**
 * Object Factory class
 *
 * @package Delete Expired Transients
 * @subpackage Core
 */
class Factory extends Helpers\Factory {



	/**
	 * Actions object
	 */
	protected function createCron() {
		return new Transients\Cron($this, $this->plugin);
	}


	/**
	 * Filters object
	 */
	protected function createTransients() {
		return new Transients\Transients;
	}



}