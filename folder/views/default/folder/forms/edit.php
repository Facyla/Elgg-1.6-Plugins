<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	if (isset($vars['entity'])) {
		$title = sprintf(elgg_echo("folder:edit"),$object->title);
		$action = "folder/edit";
		$title = $vars['entity']->title;
		$access_id = $vars['entity']->access_id;
	} else  {
		$title = elgg_echo("folder:create");
		$action = "folder/add";
		$title = "";
		if (defined('ACCESS_DEFAULT'))
			$access_id = ACCESS_PUBLIC;
		else
			$access_id = 0;
	}	

	$container = $vars['container_guid'];
	$container_hidden = elgg_view('input/hidden', array('internalname' => 'container_guid', 'value' => $vars['container_guid']));
	$title_label = elgg_echo('folder:title');
  $title_textbox = elgg_view('input/text', array('internalname' => 'foldertitle', 'value' => $title));
  $access_label = elgg_echo('Access');
  $access_input = elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
  if(isset($vars['entity']))
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('folder:edit')));
	else
		$submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('folder:add')));
	if (isset($vars['entity'])){
    $entity_hidden = elgg_view('input/hidden', array('internalname' => 'folderguid', 'value' => $vars['entity']->getGUID()));
  } else {
    $entity_hidden = '';
  }
	
	$form_body = <<< EOT
	<div id='add-folder-div'>
	<p>
		<label>$title_label</label><br/>
		$title_textbox
	</p>
	<p>
		<label>$access_label</label><br/>	
		$access_input
	<p>
	<p>
		$entity_hidden
		$container_hidden
		$submit_input
	</p>
	</div>
EOT;

	echo elgg_view('input/form', array('action' => "{$vars['url']}action/$action", 'body' => $form_body, 'internalid' => 'folderEditForm'));

?>