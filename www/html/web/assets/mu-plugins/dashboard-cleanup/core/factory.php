<?php

// Subpackage namespace
namespace RISE\DashboardCleanup\Core;

// Aliased namespaces
use \RISE\DashboardCleanup\Helpers;
use \RISE\DashboardCleanup\Cleanup;

/**
 * Object Factory class
 *
 * @package Dashboard Cleanup
 * @subpackage Core
 */
class Factory extends Helpers\Factory {



	/**
	 * Cleanup Elements object
	 */
	protected function createElements() {
		return Cleanup\Elements::instance($this->plugin);
	}



	/**
	 * Cleanup Dashboard object
	 */
	protected function createDashboard() {
		return Cleanup\Dashboard::instance($this->plugin);
	}



	/**
	 * Cleanup Woocommerce object
	 */
	protected function createWoocommerce() {
		return Cleanup\Woocommerce::instance($this->plugin);
	}



}