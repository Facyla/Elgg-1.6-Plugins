<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	define('everyonepublication','true');
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	$page_owner = page_owner_entity();
	if ($page_owner === false || is_null($page_owner)) {
		$page_owner = $_SESSION['user'];
		set_page_owner($_SESSION['guid']);
	}
	if (!($page_owner instanceof ElggEntity)) forward();

  if($page_owner == $_SESSION['user']) {
		$area2 = elgg_view_title(elgg_echo('folder:friendsselect'));
	} else {
		$area2 = elgg_view_title( sprintf(elgg_echo('folder:friendsfolders'), $page_owner->username) ); // Facyla : modified for custom translation
	}
		
	$area2 .= '<div class="contentWrapper">';
	$friends = get_user_friends($_SESSION['user']->guid, ELGG_ENTITIES_ANY_VALUE, 9999); 	
	$area2 .= elgg_view('folder/friends_list',array('friends'=>$friends,'baseurl'=>$_SERVER['REQUEST_URI']));
	//$area3 = elgg_view('publication/search');
	$area2 .= '</div>';
	
  $body = elgg_view_layout("two_column_left_sidebar", '', $area1 . $area2, $area3);
	page_draw(elgg_echo('folder:friendsselect'), $body);

?>