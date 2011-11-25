<?php
/** Elgg group members transfer tool by Facyla http://id.facyla.net/
* 
* Transfer of a group's members from one site to another : select group and choose the destination site to proceed
* 
* Notes :
*  - please move one group at once : there are separate forms, so selecting multiple groups at the same time won't work
* 
*/

// Start engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;
$prefix = $CONFIG->dbprefix;

$site_guid = -1; // 0 = current site, -1 = all sites, other = specific site (guid)  // 0 en général car on ne transfère que depuis le site en cours

if (is_plugin_enabled('multisite')) { multisite_admin_gatekeeper(); } else { exit; } // Admin and local admin gatekeeper + nonsense if no multisite enabled

$title = elgg_view_title(elgg_echo('group_migration:menu:transfer:title'));



// TRAITEMENT DU FORMULAIRE
$move_group = get_input('move_group');
$from_group_guid = get_input('from_group_guid');
$to_site_guid = get_input('to_site_guid');

if ($move_group) {
  if ($to_site_guid && $from_group_guid) { // On ne fait rien sans toutes les infos utiles
    $to_site = get_entity($to_site_guid);
    $from_group = get_entity($from_group_guid);
    if ($to_site instanceOf ElggSite) {
      $formresult .= sprintf(elgg_echo('group_migration:migration:title'), $from_group->name, $to_site->name) . '<br /><ul>';
      
      // DÉPLACEMENT DU GROUPE = CHANGEMENT DE SITE_GUID
      $formresult .= '<li>' . elgg_echo('group_migration:site') . ' : ';
      $success = 0; $error = 0;
      $query = "UPDATE `".$prefix."entities` SET `site_guid` = '".$to_site_guid."' WHERE `".$prefix."entities`.`guid` =".$from_group_guid.";";
      $result = update_data("$query");
      if ($result) { $success++; } else { $error++; }
      // Résultats en clair
      if ($error > 0) {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:site:fail'), $error, $success) . '</li>';
      } else if (($success > 0) && ($error < 1)) {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:site:success'), $success) . '</li>';
      } else {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:site:none'), $error, $success) . '</li>';
      }
      
      
      // DÉPLACEMENT DES CONTENUS DU GROUPE = changement de site_guid
      //$groupcontent = get_objects_in_group( $from_group_guid, "", 0, $site_guid, "", 99999, 0, false);  // Un site_guid n'est utilisé que si >0
      $formresult .= '<li>' . elgg_echo('group_migration:objects') . ' : ';
      $groupcontent = get_objects_in_group( $from_group_guid, "", 0, -1, "", 99999, 0, false);  // site_guid utilisé ssi >0 => autant ne pas le mettre
      $success = 0; $error = 0; $query = null;
      set_time_limit(300); // En cas de très gros groupe..
      foreach ($groupcontent as $object) {
        $query = "UPDATE `".$prefix."entities` SET `site_guid` = '".$to_site_guid."' WHERE `".$prefix."entities`.`guid` =".$object->guid.";";
        $result = update_data("$query");
        if ($result) { $success++; } else { $error++; }
      }
      // Résultats en clair
      if ($error > 0) {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:objects:fail'), $error, $success, $to_site->name .' ('.$to_site_guid.')') . '</li>';
      } else if (($success > 0) && ($error < 1)) {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:objects:success'), $success, $from_group->name, $to_site->name .' ('.$to_site_guid.')') . '</li>';
      } else {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:objects:fail'), $error, $success, $to_site->name .' ('.$to_site_guid.')') . '</li>';
      }
      
      
      // CHANGEMENT SITE_GUID DE L'ACL
      ///UPDATE `elggformavia`.`elgg_access_collections` SET `site_guid` = '1' WHERE `elgg_access_collections`.`id` =37;
      $query = "UPDATE `".$prefix."access_collections` SET `site_guid` = '".$to_site_guid."' WHERE `".$prefix."access_collections`.`id` =".$from_group->group_acl.";";
      $result = update_data("$query");
      if ($result) {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:acl:success'), $from_group->group_acl, $from_group->name, $to_site->name.' ('.$to_site_guid.')') . '</li>';
      } else {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:acl:fail'), $from_group->group_acl, $from_group->name, $to_site->name.' ('.$to_site_guid.')') . '</li>';
      }
      
      
      // DÉPLACEMENT DES MEMBRES = rejoindre le nouveau site (ils sont déjà dans le groupe mais on peut le vérifier au passage)
      // Note : pour des raisons de consistance en cas de changement de méthode d'identification sur un site, on utilise ici les 2 méthodes 
      // = celle du plugin multisite + la méthode standard d'Elgg
      $formresult .= '<li>' . elgg_echo('group_migration:members') . ' : ';
      $members = get_group_members($from_group_guid, 99999, 0, -1, false);
      $adduser_success = 0; $adduser_error = 0;
      $addsitemember_success = 0; $addsitemember_error = 0;
      $joingroup_success = 0; $joingroup_error = 0;
      foreach ($members as $member) {
        // @todo : utiliser les fonctions du multisite plutôt que celles du core (register to site ou qqch comme ça)
        if ($to_site->addUser($member->guid)) { $adduser_success++; } else { $adduser_error++; }
        if (add_entity_relationship($member->guid,'member_of_site',$to_site)) { $addsitemember_success++; } else { $addsitemember_error++; }
        if ($from_group->join($member)) { $joingroup_success++; } else { $joingroup_error++; }
      }
      // Résultats en clair
      $success_count = $adduser_success + $addsitemember_success + $addsitemember_success;
      $error_count = $adduser_error + $addsitemember_error + $addsitemember_error;
      $error = "$adduser_error (site->addUser), $addsitemember_error (member_of_site), $joingroup_error (join group)";
      $success = "$adduser_success (site->addUser), $addsitemember_success (member_of_site), $joingroup_success (join group)";
      if ($error_count > 0) {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:members:fail'), $error, $success, $to_site->name.' ('.$to_site_guid.')') . '</li>';
      } else if (($success_count > 0) && ($error_count < 1)) {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:members:success'), $success, $from_group->name, $to_site->name.' ('.$to_site_guid.')') . '</li>';
      } else {
        $formresult .= sprintf(elgg_echo('group_migration:transfer:members:fail'), $error, $success, $to_site->name .' ('.$to_site_guid.')') . '</li>';
      }
      
      
      $formresult .= '</ul>';
    }
  }
}



// FORMULAIRE

// Listes pour sélecteurs
// Groupes
$nb_groups = get_entities("group", "", "", "", "", 0, true, $site_guid);
$groups = get_entities("group", "", "", "", 99999, 0, false, $site_guid);
$groups = array_reverse($groups , true);
// Sites
$sites = get_entities("site", "", "", "", 99999, 0, false, -1);
$sites = array_reverse($sites , true);
foreach ($sites as $site) {
  $options[$site->guid] = $site->name;
  $sitelist .= '<li>' . $site->name . ' : ' . $site->guid . '</li>';
}


$area1 = '<div class="contentWrapper">';
$area1 .= "Cet outil est réservé au mode 'multisite' : il permet de transférer un groupe et ses contenus d'un site vers un autre site, et d'inscrire à ce site les membres du groupe s'ils n'en font pas déjà partie.";

if (strlen($formresult)) { $area1 .= '<div style="border:1px solid green; background:#DDFFDD; padding:5px 10px; width:90%; margin:5px auto;">' . $formresult . '</div>'; }  // Résultats du formulaire

$area1 .= "<h3>" . sprintf(elgg_echo('group_migration:grouplist:title'), $nb_groups, $CONFIG->sitename) . "</h3>";

$area1 .= "<ul>";
foreach ($groups as $group) {
  $subtype = ""; $owner_guid = "";
  $site_guid = $group->site_guid;
  $site = get_entity($site_guid)->name;
  $area1 .= '<li>';
    $area1 .= '<form style="display:inline;" action="" method="POST">';
      $area1 .=  '<a href="' . $group->getURL() . '">' . $group->name . '</a> (' . $site . ', ACL '.$group->group_acl.') : ';
      $area1 .= elgg_view('input/hidden', array('internalname' => 'move_group', 'value' => true));  // action à effectuer ou pas ?
      $area1 .= elgg_view('input/hidden', array('internalname' => 'from_group_guid', 'value' => $group->guid));  // groupe d'origine
      $area1 .= ' vers ' . elgg_view('input/pulldown', array('internalname' => 'to_site_guid', 'options_values' => $options));  // groupe cible

      $area1 .= ' <input type="submit" value="' . elgg_echo('group_migration:submit') . '" /> ';
    $area1 .= '</form>';
  $area1 .= '</li>';
}
$area1 .= "</ul>";

$area1 .= '</div>';

// Format page
$body = elgg_view_layout('one_column', $title . $area1);
  
// Draw it
echo page_draw(elgg_echo('group_migration:menu:transfer'), $body);
