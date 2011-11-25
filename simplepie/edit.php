<?php
/**
* Elgg feed plugin view page
* 
* @package Elggfeed
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

// Start engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// You need to be logged in for this one
gatekeeper();

$feed_guid = get_input('feed_guid');
$entity = get_entity($feed_guid);

$area2 .= elgg_view_title(elgg_echo('feed:this'), false);

if ($entity instanceof ElggObject) {
  // On édite
  if ($entity->canEdit()) {
    $container_guid = $entity->container_guid;
    $area2 .= elgg_view('feed/edit',array('entity' => $entity, 'container_guid' => $container_guid));
  } else register_error('feed:cantedit');
  
} else {
  // Sinon on crée l'objet et on a besoin de plus d'infos dans ce cas (groupe sinon user)
  $container_guid = get_input('container_guid', $_SESSION['guid']);
  $page_owner = get_entity($container_guid);
  if (($page_owner instanceof ElggGroup) || ($page_owner instanceof ElggUser)) {
    $area2 .= elgg_view('feed/edit', array('container_guid' => $container_guid));
  } else  register_error(elgg_echo('feed:invalidcontainer'));
}
if ($container_guid) set_page_owner($container_guid);
$container = get_entity($container_guid);

// Lien vers les flux du groupe ou du conteneur s'il y en a un
if ($container_guid) {
  add_submenu_item(elgg_echo('simplepie:group'), $CONFIG->url . "mod/simplepie/?container_guid=" . $container->guid);
}

set_context('simplepie');
// Format page
$body = elgg_view_layout('two_column_left_sidebar', $area1, $area2);

// Draw it
echo page_draw(elgg_echo('feed:edit'), $body);

