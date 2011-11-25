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
?>
<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/subscribe/vendor/js/jquery.bgiframe.min.js"  fetchhint="safe"></script>
<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/subscribe/vendor/js/jqDnR.min.js"  fetchhint="safe"></script>
<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/subscribe/vendor/js/jquery.jqpopup.min.js"  fetchhint="safe"></script>
<script type="text/javascript"> 
function subscribedialog(id1,guid,url){   
  var elt1 = document.getElementById(id1);
  elt1.innerHTML = $.ajax({
      url: "<?php echo $CONFIG->wwwroot; ?>mod/subscribe/setsubscribenotification.php?guid="+guid,
      async: false
    }).responseText;
  $("#"+id1).jqpopup_open(id1);
  $("#"+id1).jqpopup_toCenter();       
}
</script>

<?php
// Include styles (multiste caching issue)
echo '<style>';
require_once($CONFIG->pluginspath . 'subscribe/views/default/subscribe/css.php');
echo '</style>';

// Is there a page owner?
$owner = page_owner_entity();
$_SESSION['subscribe_url'] = current_page_url();

$type = ($owner instanceof ElggUser) ? ':user' : '';
$type = ($owner instanceof ElggGroup) ? ':group' : '';

$label = elgg_echo('subscribe:owner_block_menu:subscribe'.$type);	
$unlabel = elgg_echo('subscribe:owner_block_menu:unsubscribe'.$type);


if (($owner instanceof ElggUser) && !($owner == $_SESSION['user'])) {
  if (is_follower($owner->guid)) {
    $contents = "<p class=\"user_menu_profile\"><a href=\"#\" onclick=\"subscribedialog('subscribedisplay".$owner->guid."','".$owner->guid."','".$current_url."'); return false;\">{$unlabel}</a></p>";
  } else {
    $contents = "<p class=\"user_menu_profile\"><a href=\"#\" onclick=\"subscribedialog('subscribedisplay".$owner->guid."','".$owner->guid."','".$current_url."'); return false;\">{$label}</a></p>";
  }
}

if (($owner instanceof ElggGroup) && (check_entity_relationship($_SESSION['user']->guid,'member', $owner->guid))) {
  if (is_follower($owner->guid)) {
    $contents = "<p class=\"user_menu_profile\"><a href=\"#\" onclick=\"subscribedialog('subscribedisplay".$owner->guid."','".$owner->guid."','".$current_url."'); return false;\">{$unlabel}</a></p>";
  } else {
    $contents = "<p class=\"user_menu_profile\"><a href=\"#\" onclick=\"subscribedialog('subscribedisplay".$owner->guid."','".$owner->guid."','".$current_url."'); return false;\">{$label}</a></p>";
  }
}

echo $contents;
?>
<div id="subscribedisplay<?php echo $owner->guid; ?>" style="display:none;width:300px;">

</div>
