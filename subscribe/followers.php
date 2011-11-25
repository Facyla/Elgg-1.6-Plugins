<?php
/**
 * Elgg subscribe plugin
 * 
 * @founded by Fondation Maison des Sciences de l'Homme - Paris
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Fabrice Collette <fabrice.Collette@free.fr>
 * @copyright Fabrice Collette 2009
 * @link http://www.meleze-conseil.com/
 */


require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
gatekeeper();
global $CONFIG, $NOTIFICATION_HANDLERS; 
$guid = $SESSION['user']->guid;
$offset = get_input('offset',0);
$limit = get_input('limit',20);
$multipublisher = get_entity($guid);
set_page_owner(get_entity($multipublisher->container_guid)->guid);

set_context('multipublisher');

$title = elgg_view_title(elgg_echo("multipublisher:followers:list"));

foreach($NOTIFICATION_HANDLERS as $method => $foo) {
  $count = get_entities_from_relationship('notify' . $method,$guid,false,'user','',0,'',99999, 0, true, -1);
  if (is_array($followers)) {
    $followers2 = get_entities_from_relationship('notify' . $method,$guid,false,'user','',0,'',$count, 0, false, -1);
    if (is_array($followers2)) {
      $followers = array_merge($followers, $followers2);
    }
  } else {
    $followers = get_entities_from_relationship('notify' . $method, $guid, false, 'user', '', 0, '', $count, 0, false, -1);
  }
}

$users = array();
if (is_array($followers)) {
  foreach ($followers as $follower) {
    if (!in_array($follower,$users)) { $users[] = $follower; }
  }
}

// Builds the page
$area1 = "";

set_context('search');
$area2 = "<div class=\"contentWrapper\">";
$area2 .= "<div style=\"margin-bottom:15px;\"><a href=\"" . $_SESSION['last_forward_from'] . "\">" . elgg_echo('multipublisher:back') . "</a></div>";
$area2 .= elgg_view_entity_list($users, count($users), $offset, $limit, false, false,  true);
$area2 .= "</div>";

$body = $title . $area2;

// Draw it
echo page_draw( elgg_echo('multipublisher:page_title'), elgg_view_layout("two_column_left_sidebar", $area1, $body) );

