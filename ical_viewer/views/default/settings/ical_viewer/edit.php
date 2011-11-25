<?php
	/**
	 * Elgg iCal viewer plugin
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Facyla
	 * @copyright (c) Facyla 2010
	 * @link http://id.facyla.net/
	 */

?>	 
	<p>
    <?php echo elgg_echo('ical_viewer:settings:calendartitle');
    echo elgg_view('input/text', array('internalname' => 'params[calendartitle]', 'value' => $vars['entity']->calendartitle));
		echo "<p>&nbsp;</p>"; ?>
	</p>
	<p>
    <?php echo elgg_echo('ical_viewer:settings:defaulturl');
    echo elgg_view('input/text', array('internalname' => 'params[defaulturl]', 'value' => $vars['entity']->defaulturl));
		echo "<p>&nbsp;</p>"; ?>
	</p>
	<p>
    <?php echo elgg_echo('ical_viewer:settings:timeframe_before');
    echo elgg_view('input/text', array('internalname' => 'params[timeframe_before]', 'value' => $vars['entity']->timeframe_before));
		echo "<p>&nbsp;</p>"; ?>
	</p>
	<p>
    <?php echo elgg_echo('ical_viewer:settings:timeframe_after');
    echo elgg_view('input/text', array('internalname' => 'params[timeframe_after]', 'value' => $vars['entity']->timeframe_after));
		echo "<p>&nbsp;</p>"; ?>
	</p>
	<p>
    <?php echo elgg_echo('ical_viewer:settings:num_items');
    echo elgg_view('input/text', array('internalname' => 'params[num_items]', 'value' => $vars['entity']->num_items));
		echo "<p>&nbsp;</p>"; ?>
	</p>
	<p>
    <a href="<?php echo $vars['url']; ?>mod/ical_viewer/" target="_new">&rarr;&nbsp;Voir l'agenda public dans une nouvelle fenêtre</a><br />
    URL de l'agenda (pour insertion dans le menu par ex.) : <strong><?php echo $vars['url']; ?>mod/ical_viewer/</strong>
	</p>


