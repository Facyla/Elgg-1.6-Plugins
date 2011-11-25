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

global $CONFIG, $NOTIFICATION_HANDLERS; 


//the page owner
$owner = get_user($vars['entity']->owner_guid);

//the number of files to display
$num = (int) $vars['entity']->num_display;
if (!$num) $num = 8;

//get the correct size
$size = (int) $vars['entity']->icon_size;
if (!$size || $size == 1) { $size_value = "small"; } else { $size_value = "tiny"; }

if (is_plugin_enabled('multisite')){ $site = -1; } else { $site = 0; }

foreach($NOTIFICATION_HANDLERS as $method => $foo) {
  $count = get_entities_from_relationship('notify' . $method,$owner->guid,true,'user','',0,'',99999, 0, true, $site);
  if (is_array($followers)) {
    $followers2 = get_entities_from_relationship('notify' . $method,$owner->guid,true,'user','',0,'',$count, 0, false, $site);
    if (is_array($followers2)) { $followers = array_merge($followers,$followers2); }
  } else {$followers = get_entities_from_relationship('notify' . $method,$owner->guid,true,'user','',0,'',$count, 0, false, $site); }
}
$users = array();
if (is_array($followers)) {
  foreach ($followers as $follower) {
    if (!in_array($follower,$users)) { $users[] = $follower;}
  }
}
$max = min(sizeof($users),$num);


// If there are any subscribers to view, view them
if (is_array($users) && sizeof($users) > 0) {
  echo "<div id=\"widget_friends_list\">";
  for ($i=0; $i<$max; $i++) {
    echo "<div class=\"widget_friends_singlefriend\" >"
      . elgg_view("profile/icon", array('entity' => get_user($users[$i]->guid), 'size' => $size_value) )
      . "</div>";
  }
  echo "</div>";
}

