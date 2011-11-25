<?php
/**
 * Elgg external blog view
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010
 * @link http://id.facyla.net/
 */

// Get the Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Limit = nb d'articles à afficher, mais on utilise $limit1 pour sélectionner les contenus, de manière à déterminer si on doit paginer sans charger tous les contenus (mais seulement 1 de plus)
$limit = get_input('limit', 5);
$limit1 = $limit + 1;
$offset = get_input('offset', 0);
$cuttag = '<!--suite//-->';

// Pour le filtrage par catégorie
$tag = get_input('tag', false);
// Comme on filtre après récupération des contenus, il faut sélectionner un nombre d'articles (nettement) plus important..
if ($tag) {
  $limit1 = 9999;
  $tag = elgg_strtolower($tag);
  $tag = str_replace("+", " ", $tag);
}
//set_context('search');

// Facyla 20110415 : used to control the RSS output (avoid injecting un-held content that doesn't fit into XML)
$viewtype = get_input('view');
if ($viewtype != "rss") {} else { $limit = 30; }


// Séparateur d'articles
if ($separator = get_plugin_setting('separator', 'externalblog')) {} else { $separator = '<br /><hr style="width:50%; height:1px; color:lightgrey;" />'; }

$area2 = "";

/* Sélecteurs de contenu - on veut utiliser une fonction standard unique en dernier lieu (mais pb des tags..) */

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
else $limit1 = 9999;

$orderby = trim(get_plugin_setting('orderby', 'externalblog'));
if (($orderby != "time_updated desc") && ($orderby != "time_updated asc") && ($orderby != "time_created desc") && ($orderby != "time_created asc")) { $orderby = ""; } // Evitons les pbs SQL...

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
    // Pas d'arrays dans ces fonctions-là.. on garde la première valeur seulement
    if (is_array($subtypes)) $subtypes = $subtypes['object'][0];
    if (is_array($container)) $container = $container[0];
    if (is_array($filtertag)) $filtertag = $filtertag[0];

    if (strlen($container) < 1) {
      // TAG FILTER / mais pas de filtrage par container/groupe / Arrays = subtype, owner / String = site
//      $blogs_ent = get_entities_from_metadata('tags', $filtertag, "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false);
      $blogs_ent = get_entities_from_metadata('tags', $filtertag, "object", $subtypes, $owner, $limit1, 0, $orderby, $site, false);
      // La fonction get_entities_from_metadata ne permet pas de trier correctement : force par date de création, et ne prend pas en compte l'ordre.. donc on inverse et on coupe pour n'afficher que les bons articles (sauf si on filtre a posteriori)
      if (!empty($orderby) && strpos($orderby, 'asc')) { $blogs_ent = array_reverse($blogs_ent); }
      if (!$tag) $blogs_ent = array_slice($blogs_ent, $offset, $limit + 1);
      
      //$blogs_ent = get_entities_from_metadata_multi(array('tags' => $filtertag), "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false, 'and'); // Multi-critère
    } else if (strlen($site) < 1) {
      // TAG FILTER / mais pas de filtrage par site / Arrays = owner / String = subtype, container
      $blogs_ent = get_entities_from_annotations("", $subtypes, $owner, "tags", $filtertag, $owner, $container, $limit1, $offset, $orderby, false); // pas de filtrage par site
    } else {
      // TAG FILTER / Arrays = owner / String = subtype, container, site
      $blogs_ent = get_entities_from_metadata_groups($container, 'tags', $filtertag, "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false);
      //$blogs_ent = get_entities_from_metadata_groups_multi ($container, array('tags' => $filtertag), "object", $subtypes, $owner, $limit1, $offset, $orderby, $site, false); // Multi-critère
    }

  }
  
  /* Ici on garde la vue par défaut
    $blogs = elgg_view_entity_list($blogs_ent, $blogs_count, 0, $limit1, true); // Avec l'affichage par défaut
  */
  /* Et ici on préfère réécrire l'article à notre manière.. (mais ne marche pas bien pour tous les types de contenus)
  */
  
  // Filtrage si tag fourni, on exclue les contenus qui ne correspondent pas (filtrage par catégorie)
  // On se contente de passer au suivant si ça ne correspond pas
  if ($tag) {
    foreach($blogs_ent as $blog) {
      if ($blog->tags) { if (in_array($tag, $blog->tags)) { $ents[] = $blog; } }
    }
    $blogs_ent = $ents;
  }


  $blogs .= elgg_view('externalblog/listing', array(
        'entities' => $blogs_ent, 
        'separator' => $separator, 
        'tag' => $tag, 
        'cuttag' => $cuttag,
        'limit' => $limit, 
        'offset' => $offset, 
        )
      );
  
  
  /* Construction de la page */
  $area2 = $blogs;
  //$group = get_entity($group_guid);
  //$title = $group->name;
  

  // Titre s'il est défini
  $title = get_plugin_setting('blog_title', 'externalblog');

} else {
  $title = elgg_echo('externalblog:nosettings');
  $area2 = elgg_view_title($title);
  $area1 = "";
}

// Setup page
// Facyla 20110415 : controls the RSS output (avoid injecting un-held content that doesn't fit into XML)
if ($viewtype != "rss") {
  $area2 = '<div style="padding:5px 20px; margin:0; border:0;">' . $area2 . '</div>';
  $body = externalblog_layout_switch($area2, array('title' => $title, 'wrappers' => true));
} else {
  $body = $blogs;
}

page_draw($title, $body);

