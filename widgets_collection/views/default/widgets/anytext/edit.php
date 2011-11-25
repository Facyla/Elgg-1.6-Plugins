<?php
/**
 * Anytext plugin.
 * Allows users to enter any text or html into a widget
 * 
 * @package AnyText
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt <brett.profitt@eschoolconsultants.com>
 * @copyright Brett Profitt 2008
 * @link http://www.eschoolconsultants.com
 * 
 * <textarea name="params[description]"><?php echo $vars['entity']->description; ?></textarea>
 * 
 */

/*
// this will seriously break with tinymce installed.
echo elgg_view('input/longtext', array('internalname'=>'params[description]', 'value'=>$vars['entity']->description, 'editor_view'=>'none')); 
 <?php echo elgg_view('input/longtext', array('internalname'=>'params[description]', 'value'=>$vars['entity']->description, 'editor_view'=>'none')); ?>
<textarea name="params[description]"><?php echo $vars['entity']->description; ?></textarea>
*/

/* Obsolete as title, link and default settings are implemented as a generic patch in 'formavia' plugin
<p>
	<?php echo elgg_echo("widgets_collection:widgettitle"); ?><br />
	<input type="text" name="params[widgettitle]" value="<?php echo $vars['entity']->widgettitle; ?>" style="width:100%;" />
</p>
*/
?>

<p>
	<?php echo elgg_echo("widgets_collection:anytext"); ?><br />
	<?php //	echo '<input type="text" name="params[title]" value="' . htmlentities($vars['entity']->title) . '" />'; ?>
	<textarea name="params[description]" style="width:100%; height:12ex !important;"><?php echo $vars['entity']->description; ?></textarea>
	<?php //echo elgg_view('input/longtext', array('internalname'=>'params[description]', 'value'=>$vars['entity']->description)); ?>
</p>
