<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	$user = $_SESSION['user'];
	$container = page_owner_entity()->guid;
	//check if there is already a folder assigned
	//this is usualy for edit pages
	if(isset($vars['entity'])) 
		$cfolderguid = $vars['entity']->folder;
	
	$folders = get_entities('object','folder',$user->getGUID(),'',999,0,false,0,$container);
	$folder_name['none'] =  'unspecified';	
	foreach($folders as $folder) {
		$guid = $folder->getGUID();
		$folder_name[$guid] = $folder->title;
	}

	$folders_dropdown = elgg_view('input/pulldown',array('internalname'=>'folder','options_values'=>$folder_name, 'value'=>$cfolderguid));
?>

<div id='select_folders'>
	<p>
		<label><?php elgg_echo('folder:folder'); ?></label><br/>
		<?php  echo $folders_dropdown; ?>
	</p>
</div>

<script type='text/javascript'>
	$('#select_folders').insertBefore("p:contains('Tags')");	
</script>

