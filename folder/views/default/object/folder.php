<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   * Facyla : some internationalization
   */

	global $CONFIG;
	if(isset($vars['entity'])) {
		$page_owner = page_owner_entity();
		$page_owner_guid = $page_owner->guid;
		$folder = $vars['entity'];
		$container = $folder->container_guid;	
		$edit = ""; $delete = ""; $containertext = ""; // Facyla : avoid some php errors
		if($page_owner->guid != $container){
			$container_entity = get_entity($container);
			$containertext = ' ('.$container_entity->name . ')';	
		}
		
		$foldertitle = "<b>" . $folder->title . "</b>";
		$folderguid = $vars['entity']->getGUID();
		$icon = $CONFIG->wwwroot . "mod/folder/graphics/folders-tiny.jpg"; 
		$editlink = $CONFIG->wwwroot . "pg/folder/$page_owner->username"."/editfolder/$folderguid";
		$deletelink = $CONFIG->wwwroot . "action/folder/delete?folderguid=$folderguid";
		if(isadminloggedin() || $_SESSION['guid'] == $folder->owner_guid){
			$delete = elgg_view('output/confirmlink', array('href'=>$deletelink, 'text'=>elgg_echo('delete')));
			$edit = "<a href='$editlink' rel='facebox'>" . elgg_echo('edit') . "</a>";
		}
	}
	
	$ts = time();
	$token = generate_action_token($ts);
	$html = <<< EOT
		<div id="$folderguid" class='search_listing'>
		<div class='search_listing_icon'>
		<a style='cursor:pointer' onclick=update_files_list("$folderguid","$page_owner_guid")><img src="$icon"/></a>
		</div>
		<div class='search_listing_info'>
		<p><a style='cursor:pointer' onclick=update_files_list("$folderguid","$page_owner_guid")>$foldertitle<br/> $containertext</a></p>
		<p>
		$edit $delete
		</div>
		</div>
		<script type='text/javascript'>
			$("#$folderguid").droppable({
				hoverClass: 'ui-state-active',
				drop: function(event,ui){
					var fileguid = $(ui.draggable).attr('id');
					var cfolder = $("input[name='cfolder']").val();
					movefile("$token","$ts","$folderguid",fileguid,cfolder,"$page_owner_guid");
				},
			});
		</script>
EOT;
	echo $html;
?>