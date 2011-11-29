<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	global $CONFIG;
	$page_owner = page_owner_entity();

	$addlink = $vars['url']."pg/folder/" . $page_owner->username . "/addfolder";
	$addfolder = elgg_echo('folder:create');
	$html = <<< EOT
	<a href="$addlink" rel='facebox' class='add-folder-button'>$addfolder</a>
EOT;

	echo $html;

?>