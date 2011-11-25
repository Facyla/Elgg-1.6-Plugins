<?php

/**
 * Elgg event_calendar group widget
 *
 * @package event_calendar
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Kevin Jardine <kevin@radagast.biz>
 * @copyright Radagast Solutions 2008
 * @link http://radagast.biz/
 *
 */

if (!$vars['entity']->num_display) { $num_display = 5; } else { $num_display = $vars['entity']->num_display; }
if (!$vars['entity']->numpast_display) { $numpast_display = 3; } else { $numpast_display = $vars['entity']->numpast_display; }
if (!$vars['entity']->scope) { $scope = page_owner(); } else { $scope = $vars['entity']->scope; }
?>

<p>
		<?php echo elgg_echo("widgets_collection:calendar:scope"); ?>:
		<select name="params[scope]">
			<option value="<?php echo page_owner(); ?>" <?php if($scope == page_owner()) echo "SELECTED"; ?>>Agenda personnel</option>
			<option value="global" <?php if($scope == 'global') echo "SELECTED"; ?>>Agenda global</option>
		</select>
</p>

<p>
		<?php echo elgg_echo("widgets_collection:calendar:numfuture"); ?>:
		<select name="params[num_display]">
			<option value="0" <?php if($num_display == 0) echo "SELECTED"; ?>>0</option>
			<option value="1" <?php if($num_display == 1) echo "SELECTED"; ?>>1</option>
			<option value="2" <?php if($num_display == 2) echo "SELECTED"; ?>>2</option>
			<option value="3" <?php if($num_display == 3) echo "SELECTED"; ?>>3</option>
			<option value="4" <?php if($num_display == 4) echo "SELECTED"; ?>>4</option>
			<option value="5" <?php if($num_display == 5) echo "SELECTED"; ?>>5</option>
			<option value="6" <?php if($num_display == 6) echo "SELECTED"; ?>>6</option>
			<option value="7" <?php if($num_display == 7) echo "SELECTED"; ?>>7</option>
			<option value="8" <?php if($num_display == 8) echo "SELECTED"; ?>>8</option>
			<option value="9" <?php if($num_display == 9) echo "SELECTED"; ?>>9</option>
			<option value="10" <?php if($num_display == 10) echo "SELECTED"; ?>>10</option>
		</select>
</p>

<p>
		<?php echo elgg_echo("widgets_collection:calendar:numpast"); ?>:
		<select name="params[numpast_display]">
			<option value="0" <?php if($numpast_display == 0) echo "SELECTED"; ?>>0</option>
			<option value="1" <?php if($numpast_display == 1) echo "SELECTED"; ?>>1</option>
			<option value="2" <?php if($numpast_display == 2) echo "SELECTED"; ?>>2</option>
			<option value="3" <?php if($numpast_display == 3) echo "SELECTED"; ?>>3</option>
			<option value="4" <?php if($numpast_display == 4) echo "SELECTED"; ?>>4</option>
			<option value="5" <?php if($numpast_display == 5) echo "SELECTED"; ?>>5</option>
			<option value="6" <?php if($numpast_display == 6) echo "SELECTED"; ?>>6</option>
			<option value="7" <?php if($numpast_display == 7) echo "SELECTED"; ?>>7</option>
			<option value="8" <?php if($numpast_display == 8) echo "SELECTED"; ?>>8</option>
			<option value="9" <?php if($numpast_display == 9) echo "SELECTED"; ?>>9</option>
			<option value="10" <?php if($numpast_display == 10) echo "SELECTED"; ?>>10</option>
		</select>
</p>
