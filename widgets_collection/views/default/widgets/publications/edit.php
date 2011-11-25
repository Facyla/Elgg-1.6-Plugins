<?php

    /**
	 * Elgg widgets_collection widget edit
	 *
	 * @package Elggwidgets_collection
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.com/
	 */
	 
	 /* TODO
	 * paramétrages pour rendre le widget le plus générique possible :
   *  choix du owner ou des owners (array),
   *  multiselect des types de contenus à lister,
   *  ordre de tri
	 */

?>
	<p>
		<?php echo elgg_echo("widgets_collection:num"); ?>
		<input type="text" name="params[widgets_collection_num]" value="<?php echo htmlentities($vars['entity']->widgets_collection_num); ?>" />	
  </p>
	<p>
		<?php echo elgg_echo("widgets_collection:owners") . " (vous&nbsp;: <b>" . page_owner() . "</b>)"; ?>
		<input type="text" name="params[widgets_collection_owners]" value="<?php echo htmlentities($vars['entity']->widgets_collection_owners); ?>" />	
  </p>
	<p>
		<?php echo elgg_echo("widgets_collection:subtypes"); ?>
		<input type="text" name="params[widgets_collection_subtypes]" value="<?php echo htmlentities($vars['entity']->widgets_collection_subtypes); ?>" />	
  </p>
	<p>
		<?php echo elgg_echo("widgets_collection:sort"); ?>
		<input type="text" name="params[widgets_collection_sort]" value="<?php echo htmlentities($vars['entity']->widgets_collection_sort); ?>" />	
  </p>
