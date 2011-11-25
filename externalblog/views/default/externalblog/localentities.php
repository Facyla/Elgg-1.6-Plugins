<?php
// @todo : non opérationnel en l'état
// @purpose : prévu pour la recherche locale

// Pour la recherche
$limit = get_input('limit', 20);
$offset = get_input('offset', 0);
// Pour la sélection des contenus (avant recherche donc besoin de compter large)
$limit1 = $limit + 1;

/* Sélecteurs de contenu - pour obtenir la liste des entités concernées par le site sourant, on se base sur les paramètres, mais en sélectionnant tous les contenus pour effectuer des recherches dedans.. */

// Site, s'il est configuré (NOT an array)
$site = get_plugin_setting('filtersite', 'externalblog');
if (strlen($site) < 1 || $site === "all") $site = -1; // Default means all sites (-1), current site (0) is in the list

// Chargement du groupe à afficher, s'il est configuré (MIGHT be an array)
$group_guid = get_plugin_setting('group_guid', 'externalblog');
if (strlen($group_guid) < 1 || $group_guid === "all") $group_guid = null; // Default means all groups (0)
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
    /* Blog de groupe seulement
      $blogs_count = get_objects_in_group($group_guid,"blog", 0, -1, "", $limit1, 0, true);
      $blogs_ent = get_objects_in_group($group_guid,"blog", 0, -1, "", $limit1, 0, false);
    */
  } else {
    //if (!$md_type = stripslashes(get_input('tagtype'))) { $md_type = ""; } // Filtrage additionnel , pour classer par type de tag (lorsqu'on les utilise)
    // Pas d'arrays dans ces fonctions-là.. on garde la valeur s'il n'y en a qu'une, ou on enlève le filtre
//    if (is_array($subtypes)) $subtypes = $subtypes['object'][0];
    if (is_array($subtypes) && count($subtypes) === 1) $subtypes['object'][0]; else $subtypes = null;
    if (is_array($container) && count($container) === 1) $container = $container[0]; else $container = null;
    if (is_array($filtertag) && count($filtertag) === 1) $filtertag = $filtertag[0]; else $filtertag = null;

    if (strlen($container) < 1) {
      // TAG FILTER / mais pas de filtrage par container/groupe / Arrays = subtype, owner / String = site
      $blogs_ent = get_entities_from_metadata('tags', $filtertag, "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false);
      //$blogs_ent = get_entities_from_metadata_multi(array('tags' => $filtertag), "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false, 'and'); // Multi-critère
    } else if (strlen($site) < 1) {
      // TAG FILTER / mais pas de filtrage par site / Arrays = owner / String = subtype, container
      $blogs_ent = get_entities_from_annotations("", $subtypes, $owner, "tags", $filtertag, $owner, $container, $limit1, $offset, $orderby, false); // pas de filtrage par site
    } else {
      // TAG FILTER / Arrays = owner / String = subtype, container, site
      $blogs_ent = get_entities_from_metadata_groups($container, 'tags', $filtertag, "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false);
      //$blogs_ent = get_entities_from_metadata_groups_multi ($container, array('tags' => $tag), "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false); // Multi-critère
    }

  }
  
  foreach($blogs_ent as $blog) {
  }

  /* Construction de la page */
