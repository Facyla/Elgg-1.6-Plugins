<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	global $CONFIG;
	$friends = $vars['friends'];
	$baseurl = $vars['baseurl'];	
	$count = sizeof($friends);
	$nav = elgg_view('navigation/pagination',array('baseurl' => $baseurl,'offset' => 0,'count' => $count,'limit' => 10,'word' => 'annoff','nonefound' => false));
	
	$html .= $nav;
	foreach($friends as $friend) {
		$html .= "<div class='search_listing'>";
		$html .= "<div class='search_listing_icon'>";
		$html .= elgg_view('profile/icon', array('entity'=>$friend, 'size'=>'small'));
		$html .= "</div><div class='search_listing_info'>";
		$username = $friend->username;
		$html .= "<a style='font-weight:600;' href='" . $CONFIG->wwwroot . "pg/folder/$username/yourfolder'>$friend->name</a><br/>"; // Facyla : suppressed a slash
		$html .= "</div></div>";
	}
	
	echo $html;
?>