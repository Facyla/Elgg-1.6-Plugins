<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	global $CONFIG;

	$container = $vars['container_guid'];
	$page_owner = page_owner();
	$folders_list = elgg_view('folder/list',array('container_guid'=>$container));
	if(can_write_to_container($_SESSION['guid'],page_owner())){
		$addbutton = elgg_view("folder/add", array('container_guid' => $container));
		$usage_msg = "<p>" . elgg_echo('folder:usage') . "</p>";
	}
	$imgsrc = $CONFIG->wwwroot . "mod/folder/graphics/spinner.gif";
	$html = <<< EOT
	<div id='loading_div'>
		<img src="$imgsrc"/>
	</div>
	<div style='float:left;margin:0 10px 0 10px'>
	$usage_msg
	</div>
	<table style='width:100%;padding:0px'>
	<tr>
	<td style='width:30%'>
	<div id='folders_list' class='contentWrapper'>
		$folders_list
	</div>
	$addbutton
	</td><td style='width:70%'>
	<div id='files_list' class='contentWrapper'>
	</div>
	</td></tr></table>
EOT;
		
	echo $html;
?>
<script type='text/javascript'>
	$(document).ready(function(){
		all_files_list("<?php echo $page_owner;?>");
		$('#loading_div')
			.hide()
			.ajaxStart(function(){
				$(this).show();
			})
			.ajaxStop(function(){
				$(this).hide();
			});
			
	});
</script>
