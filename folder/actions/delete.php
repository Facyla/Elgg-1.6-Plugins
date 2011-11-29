<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */
	
	gatekeeper();
//	action_gatekeeper();  // Facyla : disabled in 1.6.1 (token error), but needed in 1.7+
	$guid = (int) get_input('folderguid');
	if ($folder = get_entity($guid)) {
		if ($folder->canEdit()) {
			if (!$folder->delete()) 
				register_error(elgg_echo("folder:deletefailed"));
			else 
				system_message(elgg_echo("folder:deleted"));
		} else 
			register_error(elgg_echo("folder:deletenoperm"));
	} else 
		register_error(elgg_echo("folder:notfound"));
	forward($_SERVER['HTTP_REFERER']);

?>