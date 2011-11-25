<?php
  /** Elgg content mapper tool by Facyla http://id.facyla.net/
  * 
  * Batch object transformation : select content, and choose the mapping to proceed
  * 
  * Notes :
  *  - some metadata may be lost in the process : we assume they wouldn't work properly
  * 
*/



/*
Le principe serait de sélectionner divers types de contenus, selon des critères relativement basiques (quel type de contenu, qui l'a créé, et où), afin de les "transformer" en un autre type d'objet.
   => en fait plutôt d'en créer un nouveau et de détruire l'ancien, pour se débarrasser au passage des métadonnées associées => je suppose qu'on ne pourra pas les gérer sous leur nouvelle forme (ex. mis dans un dossier ou liée à un type de donnée spécifique), donc autant s'en débarrasser au passage. Puis de définir ce qu'on va en faire : en gros dire où va chaque champ, et éventuellement comment on gère lorsqu'il y a plusieurs cibles (si ça ira avant où après le contenu existant s'il y en a déjà un)


Plan :

1 - form : critères de sélection des objets : subtype, container, owner (pas plus - ça suffit largement pour migrer ce qu'on veut)

2 - form si sélection : lister les propriétés de l'objet
  form = définir le mapping des new champs
  subtype = select (ou manuel ?)
  owner = select user ou group
  container = select user ou group
  access = select ou manuel ?
  lister les autres champs classiques
  (pas besoin de toucher aux timestamps)

3 - transtypage : action
  A = old_entity
  B = new_entity
  si B existe déjà
    si type de conflit défini
      si reconnu
        si Array => merge
        sinon
          A => B (append / append début / autre ?)
      sinon erreur et on conserve les paramètres
    sinon
      A => B (append)
  sinon
    A => B
  si tout est ok = chaque champ correctement mappé (on autorise les champs vides)
    on récupère toutes les infos (timestamps entre autres)
    si save le new object
      delete l'ancien


Questions :
- peut-être permettre d'avoir plusieurs champs cible (liste,de,champs,cibles) ?
- peut-être saisie d'une valeur possible en plus du mapping ?
- design : gestion des remplacements via un template dans laquelle on insère les anciens champs ?
- aller +loin sur les critères de sélection ?
- ...
*/


/*

// Start engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;

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
      $groupcontent = get_objects_in_group( $from_group_guid, "", 0, 0, "", 999999, 0, false); $success = 0; $error = 0;
      foreach ($groupcontent as $object) {
        $object->container_guid = $to_group_guid;
        if ($object->save()) { $success++; } else { $error++; }
      }
      
      if ($errors > 0) {
        $formresult .= sprintf(elgg_echo('group_migration:migration:objects:fail'), $error, $success) . '</li>';
      } else if (($success > 0) && ($errors < 1)) {
        $formresult .= sprintf(elgg_echo('group_migration:migration:objects:success'), $success) . '</li>';
      } else {
        $formresult .= sprintf(elgg_echo('group_migration:migration:objects:none'), $error, $success) . '</li>';
      }
    }
    
    // Déplacement des membres = rejoindre le nouveau groupe sans quitter l'ancien
    if ($move_members == "on") {
      $formresult .= '<li>' . elgg_echo('group_migration:members') . ' : ';
      $members = get_group_members($from_group_guid, 999999, 0, 0, false);
      $success = 0; $error = 0;
      $to_group = get_entity($to_group_guid);
      foreach ($members as $member) {
        if ($to_group->join($member)) { $success++; } else { $error++; }
      }
      
      if ($errors > 0) {
//          $formresult .= sprintf(elgg_echo('group_migration:migration:members:fail'), $error, $success, get_entity($to_group_guid)->name) . '</li>';
$formresult .= "$error erreurs se sont produites, $success succès";
      } else if (($success > 0) && ($errors < 1)) {
//          $formresult .= sprintf(elgg_echo('group_migration:migration:members:success'), $success, $from_group->name, get_entity($to_group_guid)->name) . '</li>';
$formresult .= "OK, $success membres inscrits au nouveau groupe";
      } else {
//          $formresult .= sprintf(elgg_echo('group_migration:migration:members:fail'), $error, $success) . '</li>';
$formresult .= "Membres déjà inscrits : $error échecs et $success succès.";
      }
    }
    
    $formresult .= '</ul>';
  }
}


// Partie formulaire
$area1 = '<div class="contentWrapper">';

if (strlen($formresult) > 0) { $area1 .= '<div style="border:1px solid green; background:#DDFFDD; padding:5px 10px; width:90%; margin:5px auto;">' . $formresult . '</div>'; }  // Résultats du formulaire

$nb_groups = get_entities("group", "", "", "", "", 0, true);
$area1 .= "<h3>" . sprintf(elgg_echo('group_migration:grouplist:title'), $nb_groups, $CONFIG->sitename) . "</h3>";

$groups = get_entities("group", "", "", "", 999999, 0, false);
$groups = array_reverse($groups , true); 
foreach ($groups as $group) { $options[$group->guid] = $group->name; }
$area1 .= "<ul>";
foreach ($groups as $group) {
  $subtype = ""; $owner_guid = ""; $site_guid = "";
  $nb_groupcontent = get_objects_in_group( $group->guid, $subtype, "", $site_guid, "", 999999, 0, true);
  $groupmembers = get_group_members($group->guid, 999999, 0, 0, true);
  
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
echo page_draw("Test migration",$body);
*/

