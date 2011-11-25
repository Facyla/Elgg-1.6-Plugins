<?php
  /** Elgg group content & members migration tool by Facyla http://id.facyla.net/
  * 
  * Batch migration of a group : select content and/or members, and choose the destination group to proceed
  * 
  * Notes :
  *  - please move one group at once : there are separate forms, so selecting multiple groups at the same time won't work
  *  - contents are transfered to the new group (= disapear from old group)
  *  - members are joined to the new group, but remain member of the old one
  * 
  */

	// Start engine
	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
	global $CONFIG;
	// Migration scope : 0 = current site, -1 = all sites, other = specific site (guid)
	// 0 en général car on ne transfère que depuis le site en cours (ou alors il faut d'abord inscrire les membres au nouveau site)
	// Mais -1 lorsqu'on doit intervenir ponctuellement pour déplacer de nombreux groupes entre sites
	$site_guid = -1;
	
  if (is_plugin_enabled('multisite')) { multisite_admin_gatekeeper(); } else { admin_gatekeeper(); } // Admin and local admin gatekeeper

	$title = elgg_view_title(elgg_echo('group_migration:title'));

	// Partie traitement du formulaire
	$move_groupcontent = get_input('move_groupcontent');
  $move_objects = get_input('move_objects');
  $move_members = get_input('move_members');
  $from_group_guid = get_input('from_group_guid');
  $to_group_guid = get_input('to_group_guid');
	
	if ($move_groupcontent) {
    if (($move_objects || $move_members) && $from_group_guid && $from_group_guid) { // On ne fait rien sans toutes les infos utiles
      $formresult .= sprintf(elgg_echo('group_migration:migration:title'), get_entity($from_group_guid)->name, get_entity($to_group_guid)->name) . '<br /><ul>';
      
      // Déplacement des contenus = changement de container_guid
      if ($move_objects == "on") {
        $formresult .= '<li>' . elgg_echo('group_migration:objects') . ' : ';
        $groupcontent = get_objects_in_group( $from_group_guid, "", 0, $site_guid, "", 999999, 0, false); $success = 0; $error = 0;
        foreach ($groupcontent as $object) {
          $object->container_guid = $to_group_guid;
          if ($object->save()) { $success++; } else { $error++; }
        }
        
        if ($error > 0) {
          $formresult .= sprintf(elgg_echo('group_migration:migration:objects:fail'), $error, $success) . '</li>';
        } else if (($success > 0) && ($error < 1)) {
          $formresult .= sprintf(elgg_echo('group_migration:migration:objects:success'), $success) . '</li>';
        } else {
          $formresult .= sprintf(elgg_echo('group_migration:migration:objects:none'), $error, $success) . '</li>';
        }
      }
      
      // Déplacement des membres = rejoindre le nouveau groupe sans quitter l'ancien
      if ($move_members == "on") {
        $formresult .= '<li>' . elgg_echo('group_migration:members') . ' : ';
        $members = get_group_members($from_group_guid, 999999, 0, $site_guid, false);
        $success = 0; $error = 0;
        $to_group = get_entity($to_group_guid);
        foreach ($members as $member) {
          if ($to_group->join($member)) { $success++; } else { $error++; }
        }
        
        if ($error > 0) {
          $formresult .= sprintf(elgg_echo('group_migration:migration:members:fail'), $error, $success, get_entity($to_group_guid)->name) . '</li>';
        } else if (($success > 0) && ($error < 1)) {
          $formresult .= sprintf(elgg_echo('group_migration:migration:members:success'), $success, get_entity($from_group_guid)->name, get_entity($to_group_guid)->name) . '</li>';
        } else {
          $formresult .= sprintf(elgg_echo('group_migration:migration:members:fail'), $error, $success) . '</li>';
        }
      }
      
      $formresult .= '</ul>';
    }
	}
	
	
	// Partie formulaire
	$area1 = '<div class="contentWrapper">';

  if (strlen($formresult)) { $area1 .= '<div style="border:1px solid green; background:#DDFFDD; padding:5px 10px; width:90%; margin:5px auto;">' . $formresult . '</div>'; }  // Résultats du formulaire
  
  $nb_groups = get_entities("group", "", "", "", "", 0, true, $site_guid);
	$area1 .= "<h3>" . sprintf(elgg_echo('group_migration:grouplist:title'), $nb_groups, $CONFIG->sitename) . "</h3>";
	
  $groups = get_entities("group", "", "", "", 999999, 0, false, $site_guid);
  $groups = array_reverse($groups , true); 
  foreach ($groups as $group) { $options[$group->guid] = $group->name . ' (' . get_entity($group->site_guid)->name . ')'; }
	$area1 .= "<ul>";
  foreach ($groups as $group) {
    $subtype = ""; $owner_guid = "";
    $nb_groupcontent = get_objects_in_group( $group->guid, $subtype, "", $site_guid, "", 999999, 0, true);
    $groupmembers = get_group_members($group->guid, 999999, 0, $site_guid, true);
    
    $area1 .= '<li>';
      $area1 .= '<form style="display:inline;" action="#" method="POST">';
        $area1 .=  sprintf(elgg_echo('group_migration:grouplist:item'), $nb_groupcontent, $groupmembers) . ' <a href="' . $group->getURL() . '">' . $group->name . '</a> : ';
        $area1 .= '<input name="move_objects" type="checkbox" />' . elgg_echo('group_migration:objects') . ' ';
        $area1 .= '<input name="move_members" type="checkbox" />' . elgg_echo('group_migration:members') . ' ';
        
        $area1 .= elgg_view('input/hidden', array('internalname' => 'move_groupcontent', 'value' => true));  // action à effectuer ou pas ?
        $area1 .= elgg_view('input/hidden', array('internalname' => 'from_group_guid', 'value' => $group->guid));  // groupe d'origine
        $area1 .= ' vers ' . elgg_view('input/pulldown', array('internalname' => 'to_group_guid', 'options_values' => $options));  // groupe cible

        $area1 .= ' <input type="submit" value="' . elgg_echo('group_migration:submit') . '" /> ';
      $area1 .= '</form>';
    $area1 .= '</li>';
  }
	$area1 .= "</ul>";

	$area1 .= '</div>';

	// Format page
	$body = elgg_view_layout('one_column', $title . $area1);
		
	// Draw it
	echo page_draw(elgg_echo('group_migration:menu'), $body);
