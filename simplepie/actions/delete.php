<?php

	/**
	 * Elgg bookmarks delete action
	 * 
	 * @package ElggBookmarks
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider <info@elgg.com>
	 * @copyright Curverider Ltd 2008-2009
	 * @link http://elgg.org/
	 */

		$guid = get_input('feed_guid',0);
		if ($entity = get_entity($guid)) {
			
			if ($entity->canEdit()) {
				
				if ($entity->delete()) {
					
					system_message(elgg_echo("feed:delete:success"));
					forward("pg/feed/");					
					
				}
				
			}
			
		}
		
		register_error(elgg_echo("feed:delete:failed"));
		forward("pg/feed/");

?>