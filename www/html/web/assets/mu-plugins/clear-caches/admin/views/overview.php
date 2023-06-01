<?php

// Subpackage namespace
namespace RISE\ClearCaches\Admin\Views;

// Aliased namespaces
use \RISE\ClearCaches\Libraries;

/**
 * Displays the "Overview" tab
 *
 * @package Clear Caches
 * @subpackage Admin
 */
class Overview extends Libraries\View_Display {



	/**
	 * Output
	 */
	protected function display($args) { extract($args); ?>

		<tr class="section">
			<td><label><h4>All Caches</h4></label></td>
			<td id="clrchs-action-all" class="clrchs-action"><input type="button" class="button button-primary button-large clrchs-purge-request" value="PURGE THEM ALL" /></td>
		</tr>

	<?php }



}
