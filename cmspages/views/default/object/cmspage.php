<?php
/**
 * Elgg cmspages view
 * 
 * @package ElggExPages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 * 
 */



/*
if ($vars['full']) {
  echo elgg_view("cmspages/view",$vars);
} else {
  if (get_input('search_viewtype') == "gallery") {
    echo elgg_view('cmspages/pagegallery',$vars); 				
  } else {
    echo elgg_view("cmspages/pagelisting",$vars);
  }
}
*/


$entity = $vars['entity'];
$tags = $entity->tags;
$title = $entity->pagetitle;
if ($title) $title = "<h4>$title</h4>";
$pagetype = $entity->pagetype;
//$description = $entity->description;

$access = $entity->access_id;
$time_updated = $entity->time_created;

$owner_guid = $entity->owner_guid;
$owner = get_entity($owner_guid);
$container_guid = $cmspage->container_guid;
$parent_guid = $cmspage->parent_guid;
$sibling_guid = $cmspage->sibling_guid;

//if (!empty($description)) $description = elgg_view('output/longtext', array('value' => $description));
if (!empty($tags)) $tags = '<p class="tags">' . elgg_view('output/tags', array('tags' => $tags)) ; '</p>';

$icon = elgg_view( "graphics/icon", array( 'entity' => $vars['entity'], 'size' => 'small', ) );

$info = "<p><b><a href=\"" . $vars['entity']->getUrl() . "\">" . $title . "</a></b></p>";
$info .= "<p class=\"owner_timestamp\">".sprintf(elgg_echo("pages:strapline"), friendly_time($time_updated), "<a href=\"" . $owner->getURL() . "\">" . $owner->name ."</a>" ) . "</p>";


echo elgg_view_listing($icon, $info);
