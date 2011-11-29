<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   * Facyla : modified quotes to normalize code and avoid htmlentities into generated code
   */


	$page_owner = page_owner_entity();
	$page_owner_guid = $page_owner->guid;
	$icon = $CONFIG->wwwroot ."mod/folder/graphics/folders-tiny.jpg";
	if($container = $vars['container_guid'])
		$owner_guid = 0;
	else
		$owner_guid = $page_owner->guid;
  
	$folders = get_entities('object','folder',$owner_guid,'',10,0,false,0,$container);
	$numfolders = get_entities('object','folder',$owner_guid,'',10,0,true,0,$container);
	$html = elgg_view_entity_list($folders,$numfolders, 0, 10);
	
	$ts = time();
	$token = generate_action_token($ts);
	$unspecified = elgg_echo('folder:file:nofolder');
	$html .= <<< EOT
		<div id='none' class='search_listing'>
		<div class='search_listing_icon'>
		<a style='cursor:pointer' onclick=update_files_list("none","$page_owner_guid")><img src="$icon"/></a>
		</div>
		<div class='search_listing_info'>
		<p><a style='cursor:pointer' onclick=update_files_list("none","$page_owner_guid")><b>$unspecified</b></a></p>
		</div></div></div>
		<script type='text/javascript'>
		$('#none').droppable({
			hoverClass: 'ui-state-active',
			drop: function(event,ui){
				var fileguid = $(ui.draggable).attr('id');
				var cfolder = $("input[name='cfolder']").val();
				movefile("$token","$ts","none",fileguid,cfolder,"$page_owner_guid");
			},
		});
		</script>
EOT;
	echo $html;

?>