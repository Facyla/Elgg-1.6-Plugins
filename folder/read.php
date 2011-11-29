<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   * smoe modifications by id.Facyla.net
   */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	group_gatekeeper();
	
	$container = get_input('page_owner');
	set_page_owner($container);
	set_context('search');
	$folderguid = get_input('folderguid', "none");  // Facyla : get value + set default at once
	
  // Facyla : define which subtypes are allowed into folders
  $subtypes = get_plugin_setting('subtypes', 'folder');  // Allowed subtypes
  $a_subtypes = (strlen($subtypes) > 0) ? array('object' => string_to_tag_array($subtypes)) : array( 'object' => array('file') );  // Default is files only
  
	// Case : No defined folder
	if($folderguid == 'none') {
		$title = elgg_echo('folder:file:nofolder');
		$area1 = elgg_view_title($title);
//		$tfiles = elgg_get_entities(array('types' => 'object', 'subtypes' => 'file', 'container_guid' => $container,'limit'=>9999)); // use for Elgg v1.7+
		$tfiles = get_entities('object', $a_subtypes, $container, '', 9999); // Facyla : backward compatibility for 1.6.1 + array of subtypes

    // Facyla : section's logic modified
    $files = array(); // Facyla : needed for some reason on 1.6.1
    $folder_files = get_entities_from_relationship('folder_of', $folderguid, false, 'object', $a_subtypes, $container, '', 9999, 0);  // Facyla :array of subtypes
    foreach($tfiles as $file) {
      if (!$folder_files || !in_array($file, $folder_files)) { $files[] = $file; }
    }

		if($files)
			$area1 .=  elgg_view('folder/file/filelist',array('viewtype'=>'all','files'=>$files));
		else
			$area1 .= '<p>' . elgg_echo('folder:unspecified') . '</p>';
	
	// Case : defined folder
	} else {
		$folder = get_entity($folderguid);	
		$area1 = elgg_view_title( sprintf( elgg_echo('folder:name'), $folder->title ) );
		// Facyla : Quicker syntax
		$files = get_entities_from_relationship('folder_of', $folderguid, false,'object', $a_subtypes, 0, '', 9999, 0);  // Facyla : array of subtypes
		if(count($files) > 0) {
			$area1 .= elgg_view('folder/file/filelist', array('viewtype'=>'singlefolder','files'=>$files));
		} else { $area1 .= '<p>' . elgg_echo('folder:nofile') . '</p>'; }
	}
	
	set_context('folder');
	$area1 .= elgg_view('input/hidden', array('internalname'=>'cfolder','value'=>$folderguid));	
	echo $area1;
?>
<script type='text/javascript'>
	$(document).ready(function(){
		var folderguid = "<?php echo $folderguid;?>";
		$('#'+folderguid).css('background-color','#e0e0e0');
	});
	$(this).click(function(event){
		if(event.target.nodeName == 'B' || event.target.nodeName == 'IMG'){
			var folderguid = "<?php echo $folderguid;?>";
			$('#'+folderguid).css('background-color','#FFFFFF');
		}
	});
</script>

