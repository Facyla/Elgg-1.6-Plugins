<?php
	/**
	 * Elgg folder plugin
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Facyla
	 * @copyright (c) Facyla 2010
	 * @link http://id.facyla.net/
	 */

?>	 
	<p>
    <?php
    echo elgg_echo('folder:settings:subtypes');
    echo "<br /><i>" . elgg_echo('folder:settings:subtypes:list') . "</i>";
    echo elgg_view('input/text', array('internalname' => 'params[subtypes]', 'value' => $vars['entity']->subtypes));
		echo "<p>&nbsp;</p>";
		?>
	</p>