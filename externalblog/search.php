<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
global $CONFIG;

if (!is_plugin_enabled('customsearch')) {
  function get_all_subtypes(){
    global $CONFIG;
    $rows = get_data("SELECT subtype as regsubtypes FROM {$CONFIG->dbprefix}entity_subtypes");
    return $rows;
  }
}

//$searchurl = "/mod/externalblog/search.php?tag=";
$searchurl = "pg/search/?tag=";

// Externalblog : on utilise les types définis le cas échéant, sinon les paramètres de customsearch, et à défaut les types enregistrés
$withelist		= array();
$subtypes = get_plugin_setting('subtypes', 'externalblog');
if (!empty($subtypes)) {
  $whitelist = string_to_tag_array($subtypes);
} else {
  $searchlist = get_plugin_setting('whitelist', 'customsearch');
  if (!empty($searchlist) ) {
    $whitelist = string_to_tag_array($searchlist);
  } else $whitelist = get_registered_entity_types();
}
$whitelist[]	= '';

/* Etendue de la recherche :
  - (défaut) ou extend : recherche locale seulement puis globale
  - all : ajoute recherche locale sans filtrer
  - localonly : recherche locale seulement
*/
// On prend les params sauf si forcé via l'URL
if ($searchscope = get_input('searchscope', false)) {} else {
  if ($searchscope = get_plugin_setting('searchscope', 'externalblog')) {} else { $searchscope = 'localonly'; }
}

set_context('search');

$searchstring = get_input('tag');
//$searchstring = strtr($searchstring,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
$searchstring = sanitise_string($searchstring);
$tag = trim($searchstring);
// @bug : si recherche == certains termes réservés, dépassement de mémoire..
$reserved_words = array('fing', 'blog', 'site');
$dosearch = true;
if (in_array($tag, $reserved_words)) {
  $body = elgg_echo('externalblog:search:reservedwords');
  $dosearch = false;
}

$search_min_size = 2;
$offset = get_input("offset", 0);
$limit = 9999;

if ($dosearch && !empty($tag) && (strlen($tag) >= $search_min_size)) {
  $allowedTypes	= array();
  $added = array();
  $allowedT = get_all_subtypes();
  foreach ($allowedT as $key => $subT) {
    foreach($subT as $k => $v) {
      // klermor 20101214 modif 
      // subtypes ... A repercuter dans search/index.php
      //$whitelist = array('file','pel','publication','blog','messages','bookmarks','event_calendar','page','page-top','training','');
      if (empty($whitelist) || in_array($v, $whitelist)){
        $allowedTypes[] = $v;
      }
    }
  }
  
  
  // SELECTION DES CONTENUS LOCAUX
  $filterents = array();
  // On utilise $limit1 pour sélectionner les contenus, de manière à pouvoir limiter les recherches aux contenus de ce site
  $limit1 = 99999;
  /* Sélecteurs de contenu - on veut utiliser une fonction standard unique en dernier lieu (mais pb des tags..) */

  // Site, s'il est configuré (NOT an array)
  $site = get_plugin_setting('filtersite', 'externalblog');
  if (strlen($site) < 1 || $site === "all") $site = -1; // Default means all sites (-1), current site (0) is in the list

  // Chargement du groupe à afficher, s'il est configuré (MIGHT be an array)
  $group_guid = get_plugin_setting('group_guid', 'externalblog');
  if (strlen($group_guid) < 1 || $group_guid == "all") $group_guid = null; // Default means all groups (0)
  $container = (strlen($group_guid) > 0) ? explode(',', trim($group_guid)) : null; // Default is no group (nor user) filter

  // Owner = créateur du contenu, s'il est configuré (IS an array, and CAN be a string)
  $owner_guid = get_plugin_setting('filterowner', 'externalblog');
  $owner = (strlen($owner_guid) > 0) ? explode(',', trim($owner_guid)) : null; // Default means all owners (0) - array may be allowed

  // Types de contenus (IS an array, and CAN be a string)
  $subtypes = get_plugin_setting('subtypes', 'externalblog');
  $subtypes = (strlen($subtypes) > 0) ? string_to_tag_array($subtypes) : "";  // Default is nothing (it's a filter)
  if ($subtypes) $subtypes = array('object' => $subtypes);

  // Tags (MIGHT be an array)
  $filtertag = trim(get_plugin_setting('filtertag', 'externalblog'));
  if (strlen($filtertag) < 1) $filtertag = null; // array is NOT allowed

  $orderby = trim(get_plugin_setting('orderby', 'externalblog'));
  if ($orderby != "time_updated desc" && $orderby != "time_updated asc" && $orderby != "time_created desc" && $orderby != "time_created asc") { $orderby = ""; } // Evitons les pbs SQL...

  // Si on a au moins une info pour sélectionner les contenus, on peut continuer
  if ($site || $container || $owner || $subtypes || $filtertag || $orderby) {
    if (strlen($filtertag) < 1) {
      // NO TAG FILTER (array-friendly) / Arrays = subtype, owner, container / String = site
      $blogs_ent = get_entities("", $subtypes, $owner, $orderby, $limit1, $offset, false, $site, $container);
      
      // Récupération des contenus du blog externe
    } else {
      //if (!$md_type = stripslashes(get_input('tagtype'))) { $md_type = ""; } // Filtrage additionnel , pour classer par type de tag (lorsqu'on les utilise)
      // Pas d'arrays dans ces fonctions-là.. on garde la valeur s'il n'y en a qu'une, ou on enlève le filtre
    //    if (is_array($subtypes)) $subtypes = $subtypes['object'][0];
      /* 20110920 : bug sur la recherche : différence du code de sélection avec le fichier index (qui fait référence)
      if (is_array($subtypes) && count($subtypes) === 1) $subtypes['object'][0]; else $subtypes = null;
      if (is_array($container) && count($container) === 1) $container = $container[0]; else $container = null;
      if (is_array($filtertag) && count($filtertag) === 1) $filtertag = $filtertag[0]; else $filtertag = null;
      */
      // Pas d'arrays dans ces fonctions-là.. on garde la première valeur seulement
      if (is_array($subtypes)) $subtypes = $subtypes['object'][0];
      if (is_array($container)) $container = $container[0];
      if (is_array($filtertag)) $filtertag = $filtertag[0];

      if (strlen($container) < 1) {
        // TAG FILTER / mais pas de filtrage par container/groupe / Arrays = subtype, owner / String = site
        //$blogs_ent = get_entities_from_metadata('tags', $filtertag, "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false);
        $blogs_ent = get_entities_from_metadata('tags', $filtertag, "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false);
        //$blogs_ent = get_entities_from_metadata_multi(array('tags' => $filtertag), "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false, 'and'); // Multi-critère
        // La fonction get_entities_from_metadata ne permet pas de trier correctement : force par date de création, et ne prend pas en compte l'ordre.. donc on inverse et on coupe pour n'afficher que les bons articles (sauf si on filtre a posteriori)
        if (!empty($orderby) && strpos($orderby, 'asc')) { $blogs_ent = array_reverse($blogs_ent); }
        
      } else if (strlen($site) < 1) {
        // TAG FILTER / mais pas de filtrage par site / Arrays = owner / String = subtype, container
        $blogs_ent = get_entities_from_annotations("", $subtypes, $owner, "tags", $filtertag, $owner, $container, $limit1, $offset, $orderby, false); // pas de filtrage par site
      } else {
        // TAG FILTER / Arrays = owner / String = subtype, container, site
        $blogs_ent = get_entities_from_metadata_groups($container, 'tags', $filtertag, "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false);
        //$blogs_ent = get_entities_from_metadata_groups_multi ($container, array('tags' => $filtertag), "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false); // Multi-critère
      }
    }
    // Filtrage a posteriori : la liste des contenus locaux sert de filtre par rapport à liste de la recherche fulltext
    foreach($blogs_ent as $blog) { $filterents[] = $blog->guid; }
  }
  // FIN : SELECTION DES CONTENUS LOCAUX
  
  
  
  // AJOUT DES RÉSULTATS "NORMAUX" PAR TAG
	// Get input
  $tag3 = stripslashes($tag);
  $subtype = stripslashes(get_input('subtype'));
  if (!$objecttype = stripslashes(get_input('object'))) { $objecttype = ""; }
  if (!$md_type = stripslashes(get_input('tagtype'))) { $md_type = ""; }
  $owner_guid = (int)get_input('owner_guid',0);
  if (substr_count($owner_guid,',')) { $owner_guid_array = explode(",",$owner_guid); } else { $owner_guid_array = $owner_guid; }
  $friends = (int) get_input('friends',0);
  if ($friends > 0) {
    if ($friends = get_user_friends($friends,'',9999)) {
      $owner_guid_array = array();
      foreach($friends as $friend) { $owner_guid_array[] = $friend->guid; }
    } else { $owner_guid = -1; }
  }
  if (empty($objecttype) && empty($subtype)) {
  } else {
    if (empty($objecttype)) $objecttype = 'object';
    $itemtitle = 'item:' . $objecttype;
    if (!empty($subtype)) $itemtitle .= ':' . $subtype;
    $itemtitle = elgg_echo($itemtitle);
  }
  if (!empty($tag3)) {
    $classicsearch = get_entities_from_metadata($md_type, elgg_strtolower($tag3), $objecttype, $subtype, $owner_guid_array, 99999, 0, "", -1, false);
    if ($classicsearch)
    foreach ($classicsearch as $entity) {
      if ( ($entity->type != 'site') && !array_key_exists($entity->guid, $added) ) { $added[$entity->guid] = $entity; }
    }
  }
  // FIN RECHERCHE CLASSIQUE
  
  
  // Search in Metadata
  $rows = get_data("SELECT a1.*,a2.* FROM {$CONFIG->dbprefix}metastrings as a1, {$CONFIG->dbprefix}metadata as a2  
    WHERE a1.string LIKE '%" . $searchstring . "%' AND a2.value_id=a1.id
    GROUP BY a2.entity_guid ORDER BY a2.time_created DESC");
  if(!empty($rows)){
    foreach($rows as $row){
      $entity_id = $row->entity_guid;
      $entities  = get_entity($entity_id);
      if((in_array(get_subtype_from_id($entities->subtype), $allowedTypes)) or (empty($entities->subtype))) {
        if($entities->type != 'site') {
          if(!array_key_exists($entities->guid, $added)){
            $added[$entities->guid] = $entities;
          }
        }
      }
    }
  }
  
  // Search in Annotations
  $rowsA = get_data("SELECT a1.*,a2.* FROM {$CONFIG->dbprefix}metastrings as a1, {$CONFIG->dbprefix}annotations as a2  
    WHERE a1.string LIKE '%" . $searchstring . "%' AND a2.value_id=a1.id 
    GROUP BY a2.entity_guid ORDER BY a2.time_created DESC");
  if(!empty($rowsA)) {
    foreach($rowsA as $rowA){
      $entity_idA = $rowA->entity_guid;
      $entitiesA  = get_entity($entity_idA);
      if((in_array(get_subtype_from_id($entitiesA->subtype), $allowedTypes)) or (empty($entitiesA->subtype))) {
        if($entitiesA->type != 'site') {
          if(!array_key_exists($entities->guid, $added)){
            $added[$entitiesA->guid] = $entitiesA;
          }
        }
      }
    }
  }
  
  // Search in Objects
  $rows2 = get_data("SELECT * FROM {$CONFIG->dbprefix}objects_entity 
    WHERE  title LIKE '%" . $searchstring . "%' OR description LIKE '%" . $searchstring . "%'");
  if(!empty($rows2)) {
    foreach($rows2 as $row2){
      $entity_id2 = $row2->guid;
      $entities2  = get_entity($entity_id2);
      if((in_array(get_subtype_from_id($entities2->subtype), $allowedTypes)) or (empty($entities2->subtype))) {  
        if($entities2->type != 'site') {
          if(!array_key_exists($entities2->guid, $added)) { $added[$entities2->guid] = $entities2; }
        }
      }
    }
  }
  
  // Search in Groups
  $rows3 = get_data("SELECT * FROM {$CONFIG->dbprefix}groups_entity 
    WHERE  name LIKE '%" . $searchstring . "%' OR description LIKE '%" . $searchstring . "%'");
  if(!empty($rows3)) {
    foreach($rows3 as $row3) {
      $entity_id3 = $row3->guid;
      $entities3  = get_entity($entity_id3);
      if((in_array(get_subtype_from_id($entities3->subtype), $allowedTypes)) or (empty($entities3->subtype))){ 
        if($entities3->type != 'site'){
          if(!array_key_exists($entities3->guid, $added)){ $added[$entities3->guid] = $entities3; }
        }
      }
    }
  }
  
  // Search for Users
  $user_count = search_for_user($tag, 0, 0, "", true);
  if(!empty($user_count)){
    $users = search_for_user($tag, $user_count);
    foreach($users as $user){
      if(!array_key_exists($user->guid, $added)){ $added[$user->guid] = $user; }
    }
  }
  
  // Filter search results
  $entitiesList = array();
  if(!empty($added)) {
    $objectType = $objecttype;
    foreach($added as $guid => $entity){
      if(empty($objectType) || (!empty($objectType) && $entity->type == $objectType)){
        if(empty($subtype) || (!empty($subtype) && $entity->getSubtype() == $subtype)){
          // Facyla : on filtre en fonction des entités enregistrées sur externablog, selon les params de la recherche
          switch ($searchscope) {
            case 'localonly':
              if (in_array($guid, $filterents)) { $entitiesList[] = $entity; }
              break;
            case 'all':
              $entitiesList[] = $entity;
              break;
            case 'extend':
            default: 
              if (in_array($guid, $filterents)) { $entitiesList[] = $entity; } else { $globalentitiesList[] = $entity; }
          }
        }
      }
    }
  }
  
  
  // Make search result view
  $total = count($entitiesList);
  $globaltotal = count($globalentitiesList);
  $offset = get_input("offset", 0);
  $limit = 10;
  $fullview = false;
  $viewToggle = false;
  $multiPage = true;
  
  $body .= '<div class="contentWrapper">';
  // Varie selon paramètres
  switch ($searchscope) {
    case 'localonly':
      $limitedEntities = array_slice($entitiesList, $offset, $limit);
      if (sizeof($limitedEntities) > 0) $body .= elgg_view_entity_list($limitedEntities, $total, $offset, $limit, $fullview, $viewToggle, $multiPage);
      else $body .= elgg_echo('externalblog:search:noresult');
//      $body .= '<br /><strong><a href="http://' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . '&searchscope=extend">' . elgg_echo('externalblog:search:extendlink') . '</a></strong>';
      break;
    case 'all':
      $limitedEntities = array_slice($entitiesList, $offset, $limit);
      $body .= elgg_view_entity_list($limitedEntities, $total, $offset, $limit, $fullview, $viewToggle, $multiPage);
      break;
    case 'extend':
    default: 
      $limitedEntities = array_slice($entitiesList, $offset, $limit);
      $globallimitedEntities = array_slice($globalentitiesList, $offset, $limit);
      $body .= '<h4>' . elgg_echo('externalblog:search:localsearch') . '</h4>';
      if (sizeof($limitedEntities) > 0) $body .= elgg_view_entity_list($limitedEntities, $total, $offset, $limit, $fullview, $viewToggle, $multiPage);
      else $body .= elgg_echo('externalblog:search:noresult');
      $body .= '<br /><h4>' . elgg_echo('externalblog:search:globalsearch') . '</h4>';
      if (sizeof($globallimitedEntities) > 0) $body .= elgg_view_entity_list($globallimitedEntities, $globaltotal, $offset, $limit, $fullview, $viewToggle, $multiPage);
      else $body .= elgg_echo('externalblog:search:noresult');
  }
  $body .= '</div>';
  
  // Show search result counter
  $results_found_message = '';
  if ($total) { $results_found_message = sprintf(elgg_echo('externalblog:search:found'), $total); }
  $body .= $results_found_message;
  
  
} else {
  // @todo : pb des mots réservés : cause ?
  if ($dosearch) {
    $body = sprintf(elgg_echo(empty($tag) ? 'externalblog:search:noresult' : 'externalblog:search:too_short'), $search_min_size);
  } else $body .= elgg_echo('externalblog:search:noresult');
}


// Set up submenus
if ($object_types = get_registered_entity_types()) {
  foreach($object_types as $object_type => $subtype_array) {
    if (is_array($subtype_array) && sizeof($subtype_array))
      foreach($subtype_array as $object_subtype) {
        $label = 'item:' . $object_type;
        if (!empty($object_subtype)) $label .= ':' . $object_subtype;
        global $CONFIG;
        add_submenu_item(elgg_echo($label), $CONFIG->wwwroot . $searchurl . urlencode($tag) ."&subtype=" . $object_subtype . "&object=". urlencode($object_type) ."&tagtype=" . urlencode($md_type) . "&owner_guid=" . urlencode($owner_guid));
      }
  }
  add_submenu_item(elgg_echo('all'), $CONFIG->wwwroot . $searchurl . urlencode($tag) ."&owner_guid=" . urlencode($owner_guid));
}

if ($itemtitle) $itemtitle = ' - '.$itemtitle;
$title = elgg_view_title( sprintf(elgg_echo("externalblog:search:title"), $tag) . $itemtitle );
$searchform = '<form id="searchform" action="' . $CONFIG->url . 'pg/search/" method="get">
	<input type="text" size="21" name="tag" value="' . $tag . '" onclick="if (this.value==\''.elgg_echo('search').'\') { this.value=\'\' }" class="search_input" />
	<input type="submit" value="'.elgg_echo('search').'" class="search_submit_button" />
</form>';

page_draw( elgg_echo('search'), elgg_view_layout('two_column_left_sidebar', '', $searchform . $title . $body) );

