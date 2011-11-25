<?php
/**
 * Subscriber
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Fabrice Collette
 * this plugin has been founded by Fondation Maison des Sciences de l'Homme - Paris	 
 * @copyright Fabrice Collette 2010
 * @link http://www.meleze-conseil.com
*/

$group_guid = get_input('group_guid');			
$group = get_entity($group_guid);

$body = elgg_view('input/form', array(
    'body' => elgg_view('subscribe/setsubscribenotification', array('group' => $group)),
    'method' => 'post',
    'action' => $CONFIG->wwwroot . 'mod/subscribe/actions/notification.php?group='.$group_guid
  ));

echo '<div id="subscribe_popup_group" style="display:none;width:320px;">' . $body . '</div>';
?>

<script type="text/javascript"> 
window.onload = function() {
  $("#subscribe_popup_group").jqpopup_open("subscribe_popup_group");
  $("#subscribe_popup_group").jqpopup_toCenter();
}
</script>

