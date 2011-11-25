<?php
/**
 * Elgg edit widget layout
 * 
 * @package Elgg
 * @subpackage Core

 * @author Curverider Ltd & Facyla
 * @changes : add generic per-widget custom settings - title, title link, details (on title hover), default open/close

 * @link http://elgg.org/
 */

//$guid = $vars['entity']->getGUID();
$guid = $vars['entity']->guid;

// Widget-specific settings
$form_body = $vars['body'];

// Facyla 20110717 : Makes it more clear to users - don't change access where it doesn't apply
if (get_context() != 'dashboard') $form_body .= "<p><label>" . elgg_echo('access') . ": " . elgg_view('input/access', array('internalname' => 'params[access_id]','value' => $vars['entity']->access_id)) . "</label></p>";

$form_body .= "<p>" . elgg_view('input/hidden', array('internalname' => 'guid', 'value' => $guid)) . elgg_view('input/hidden', array('internalname' => 'noforward', 'value' => 'true')) . "</p>";

// Optional generic custom fields for all widgets
$form_body .= '<hr />';
// Title
$form_body .= "<p><label>" . elgg_echo('widget:widgettitle') . ": " . elgg_view('input/text', array('internalname' => 'params[widgettitle]','value' => $vars['entity']->widgettitle)) . "</label></p>";
// Title link, if any
$form_body .= "<p><label>" . elgg_echo('widget:widgetlink') . ": " . elgg_view('input/text', array('internalname' => 'params[widgetlink]','value' => $vars['entity']->widgetlink)) . "</label></p>";
// Description (hover or included in content)
$form_body .= "<p><label>" . elgg_echo('widget:widgetdetails') . ': </label><textarea name="params[widgetdetails]" style="height:12ex; width:95%;" class="NoEditor">' . $vars['entity']->widgetdetails . '</textarea></p>';
// Default open or hidden ?
$yesno_opt = array('no' => elgg_echo('widgets_collection:settings:no'), 'yes' => elgg_echo('widgets_collection:settings:yes'));
$form_body .= "<p><label>" . elgg_echo('widget:defaultopen') . ": " . elgg_view('input/pulldown', array('internalname'=>'params[defaultopen]', 'options_values'=>$yesno_opt, 'value'=>$vars['entity']->defaultopen)) . "</label></p>";

// submit
$form_body .= "<p>" . elgg_view('input/submit', array('internalname' => "submit$guid", 'value' => elgg_echo('save'))) . "</p>";

echo elgg_view('input/form', array('internalid' => "widgetform$guid", 'body' => $form_body, 'action' => "{$vars['url']}action/widgets/save"))	
?>


<script type="text/javascript">
$(document).ready(function() {

$("#widgetform<?php echo $guid; ?>").submit(function () {

  $("#submit<?php echo $guid; ?>").attr("disabled","disabled");
  $("#submit<?php echo $guid; ?>").attr("value","<?php echo elgg_echo("saving"); ?>");
  $("#widgetcontent<?php echo $guid; ?>").html('<?php echo elgg_view('ajax/loader',array('slashes' => true)); ?>');
  $("#widget<?php echo $guid; ?> .toggle_box_edit_panel").click();

  var variables = $("#widgetform<?php echo $guid; ?>").serialize();
  $.post($("#widgetform<?php echo $guid; ?>").attr("action"),variables,function() {
    $("#submit<?php echo $guid; ?>").attr("disabled","");
    $("#submit<?php echo $guid; ?>").attr("value","<?php echo elgg_echo("save"); ?>");
    $("#widgetcontent<?php echo $guid; ?>").load("<?php echo $vars['url']; ?>pg/view/<?php echo $guid; ?>?shell=no&username=<?php echo page_owner_entity()->username; ?>&context=<?php echo get_context(); ?>&callback=true");
  });
  return false;

});

}); 
</script>