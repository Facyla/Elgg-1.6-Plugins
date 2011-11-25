<?php
/**
 * Elgg feeds groupprofile block (feeds listing)
 * 
 * @package Elgg
 * @subpackage Feed
 * @author Facyla 2010
 * @copyright	
 * @license 	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
*/

global $CONFIG;

if ($vars['entity']->feed_enable == 'yes') {
  $group_guid = $vars['entity']->guid;
  $limit = get_input("limit", 5);
  $offset = get_input("offset", 0);

  // Listing des stages
  set_context('search');
  $feeds = get_entities('object', 'feed', 0, 'time_updated desc', $limit, $offset, false, -1, $group_guid, 0, 0);
  $totalcount = count($feeds);
  ?>

  <div id="group_pages_widget">
    <?php
    echo '<h3><a href="' . $CONFIG->url . "mod/simplepie/?container_guid=$group_guid" . '">' . elgg_echo('simplepie:group') . '</a></h3>';
    echo elgg_view_entity_list($feeds, $totalcount, $offset, $limit, false, false, true);
    // Tout membre d'un groupe a la possibilité de créer et éditer les(ses) flux
    if ($vars['entity']->isMember($_SESSION['guid'])) {
      echo '<a href="' . $CONFIG->url . 'mod/simplepie/edit.php?container_guid='. $vars['entity']->guid . '">»&nbsp;' . elgg_echo('simplepie:new') . '</a>';
    }
    ?>
  </div>

  <?php
}
