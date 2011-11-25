<?php
/**
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla <facyla@gmail.com>
 * @copyright Facyla 2011
 * @link http://id.facyla.net/
 */

$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
  set_page_owner($page_owner->getGUID());
}

if (isset($vars['entity'])) {
  // Choix du groupe/site
  //set_input('', $vars['entity']->filter);
	echo '<div class="mynews_widget contentWrapper">';
	echo elgg_view('explore/mynews', array('nb_cols'=>1));
	echo '</div>';
	
}
