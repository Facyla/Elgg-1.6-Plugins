<?php
/**
 * Elgg feed plugin index : site feed index & group index
 * 
 * @package Elggfeed
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider <info@elgg.com>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */

// Start engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$area1 = "";
$area2 = "";
$title = "";
$container_guid = get_input('container_guid', null);

set_context('simplepie');
$enable_object = get_plugin_setting('feedobject', 'simplepie');
if ($enable_object === "yes") $worldlink = '<a href="' . $CONFIG->url . 'mod/simplepie/world.php">' . elgg_echo('simplepie:all') . '</a>';

// Vue générale (page principale)
if (!$container_guid) {
  //if ($layout = get_plugin_setting('mainlayout', 'simplepie')) {} else { $layout = 'one_colum'; }
  $layout = 'one_column';
  
  $title = get_plugin_setting('feedtitle', 'simplepie');
  $feed_url = get_plugin_setting('feed_url', 'simplepie');
  $excerpt = get_plugin_setting('feedexcerpt', 'simplepie');
  $num_items = get_plugin_setting('feednum_items', 'simplepie');
  $post_date = get_plugin_setting('feedpost_date', 'simplepie');
  $description = get_plugin_setting('feeddescription', 'simplepie');
  if ($worldlink) $area2 .= '<h3 style="float:right;">' . $worldlink . '</h3>'; // Do not display if objects are not activated
  $area2 .= elgg_view_title($title);
  $area2 .= elgg_view('feed/readfeed', array('feedurl' => $feed_url, 'excerpt' => $excerpt, 'num_items' => $num_items, 'post_date' => $post_date, 'title' => $title, 'description' => $description ));
  if ($worldlink) $area2 .= "<br /><br /><h3>&rarr;&nbsp;$worldlink</h3>"; // Do not display if objects are not activated

// Vue pour un container (group, ou user)
} else {
  $layout = 'two_column_left_sidebar';
  set_page_owner($container_guid);
  $page_owner = get_entity($container_guid);
  $title = sprintf( elgg_echo('simplepie:container'), $page_owner->name);
  $area2 .= elgg_view_title($title);
  
  $feeds = get_entities('object', 'feed', 0, 'time_updated desc', $limit, $offset, false, -1, $container_guid, 0, 0);
  $totalcount = count($feeds);
  set_context('search');
  $area2 .= elgg_view_entity_list($feeds, $totalcount, $offset, $limit, false, false, true);
}

set_context('simplepie');

// Display the contents in chosen layout
if (is_plugin_enabled('externalblog')) {
  $area2 = '<div class="contentWrapper">' . $area2 . '</div>';
  $body = externalblog_layout_switch($area2, array('layout' => $layout));
} else {
  switch ($layout) {
    case "one_column" :
      $body = elgg_view_layout($layout, '<div class="contentWrapper">' . $area2 . '</div>');
      break;
    case "two_column_left_sidebar" :
      // Tout membre d'un groupe a la possibilité de créer et éditer les(ses) flux
      if ($page_owner->isMember($_SESSION['guid'])) {
        add_submenu_item(elgg_echo('simplepie:new'), $CONFIG->url . "mod/simplepie/edit.php?container_guid=". $page_owner->guid);
      }
      $body = elgg_view_layout($layout, $area1, $area2);
      break;
    default:
      $body = elgg_view_layout('one_colum', $area2);
      break;
  }
}

// Draw it
echo page_draw($title, $body);
