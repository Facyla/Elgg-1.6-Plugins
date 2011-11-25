<?php

	/**
	 * Elgg bookmarks add/save action
	 * 
	 * @package ElggBookmarks
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author facyla
	 * @facyla
	 * @link http://elgg.org/
	 */
	
	gatekeeper();
	action_gatekeeper();

		$title = get_input('title');
		$guid = get_input('feed_guid',0);
		$description = get_input('description');
		$feedurl = get_input('feedurl');
		$excerpt = get_input('excerpt'); 
        $num_items = get_input('num_items'); 
        $post_date = get_input('post_date'); 
		$access = get_input('access');
//		$shares = get_input('shares',array());
		
		$tags = get_input('tags');
		$tagarray = string_to_tag_array($tags);
		
		if ($guid == 0) {
			
			$entity = new ElggObject;
			$entity->subtype = "feed";
			$entity->owner_guid = $_SESSION['user']->getGUID();
			$entity->container_guid = (int)get_input('container_guid', $_SESSION['user']->getGUID());
			
		} else {
			
			$canedit = false;
			if ($entity = get_entity($guid)) {
				if ($entity->canEdit()) {
					$canedit = true;
				}
			}
			if (!$canedit) {
				system_message(elgg_echo('notfound'));
				forward("pg/feed");
			}
			
		}
		
		$entity->title = $title;
		$entity->feedurl = $feedurl;
		$entity->excerpt = $excerpt;
		$entity->num_items = $num_items;
		$entity->post_date = $post_date;
		$entity->description = $description;
		$entity->access_id = $access;
		$entity->tags = $tagarray;
		
		if ($entity->save()) {
			$entity->clearRelationships();
//			$entity->shares = $shares;
		
/*			if (is_array($shares) && sizeof($shares) > 0) {
				foreach($shares as $share) {
					$share = (int) $share;
					add_entity_relationship($entity->getGUID(),'share',$share);
				}
			}
*/
			system_message(elgg_echo('feed:save:success'));
			//add to river
//			add_to_river('river/object/feed/create','create',$_SESSION['user']->guid,$entity->guid);
			forward($entity->getURL());
		} else {
			register_error(elgg_echo('feed:save:failed'));
			forward("pg/feed");
		}

?>