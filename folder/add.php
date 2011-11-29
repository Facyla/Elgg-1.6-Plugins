<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	if(!is_callable('elgg_view')) exit;

	$page_owner = page_owner_entity();	
	
	if ($page_owner instanceof ElggGroup)
		$container = $page_owner->guid;

	if($guid = get_input('guid'))
		$entity = get_entity($guid);
			
	echo elgg_view('folder/forms/edit', array('entity'=>$entity, 'container_guid'=>$container));
		
?>
