<?php

// Subpackage namespace
namespace RISE\DisableAttachmentPages\Core;

// Aliased namespaces
use \RISE\DisableAttachmentPages\Helpers;

/**
 * Core class
 *
 * @package Disable Attachment Pages
 * @subpackage Core
 */
final class Core extends Helpers\Singleton {



	/**
	 * Constructor
	 */
	protected function onConstruct() {

		// Create factory object
		$this->plugin->factory = new Factory($this->plugin);

		if ($this->plugin->enabled('DISABLE_ATTACHMENT_PAGES'))
			$this->plugin->factory->attachments($this->plugin);
	}



}