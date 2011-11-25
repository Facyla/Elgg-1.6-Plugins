<?php
// This page can only be run from within the Elgg framework
if (!is_callable('elgg_view')) exit;
if (!isloggedin()) exit;
global $SESSION;

// Get plugin config : set what we're gonna feed the embed selector with
// Types : array('object', 'group', 'user', 'site')
$allowed_types = get_plugin_setting('allowed_types', 'embed');
$a_types = (strlen($allowed_types) > 0) ? string_to_tag_array($allowed_types) : 'object';  // Default is objects only
// Subtypes : array('object', 'group', 'user', 'site')
$allowed_subtypes = get_plugin_setting('allowed_subtypes', 'embed');
$a_subtypes = (strlen($allowed_subtypes) > 0) ? string_to_tag_array($allowed_subtypes) : 'file';  // Default is files only
$entity_subtypes = $a_types;
if (in_array('object', $a_types)) $entity_subtypes['object'] = $a_subtypes; // Add subtypes filters

$internalname = get_input('internalname'); // Get the name of the form field we need to inject into
$offset = (int) get_input('offset', 0);
$limit = (int) get_input('limit', 10);
$simpletype = get_input('simpletype', 'file');

// File types
$types = get_tags(0, 10, 'simpletype', 'object', 'file', $SESSION['user']->guid);
foreach ($types as $type) $simpletypes[] = $type->tag;

$is_filetype = false;
// Also filter simpletype, just in case there's a simpletype with an object type or subtype name so we don't miss it
//if ( !empty($simpletype) && !in_array($simpletype, $types) ) {
if (!empty($simpletype)) {
  switch($simpletype) {
    case "site": $a_types = 'site'; $entity_subtypes = ''; break;
    case "group": $a_types = 'group'; $entity_subtypes = ''; break;
    case "user": $a_types = 'user'; $entity_subtypes = ''; break;
    case "object": $a_types = 'object'; $entity_subtypes = array('object' => $a_subtypes); break;
    default:
      if(!in_array($simpletype, $simpletypes)) { $a_types = 'object'; $entity_subtypes = $simpletype; } else { $is_filetype = true; }
      break;
  }
}

if ($is_filetype) {
  // We're retrieving only a special file (simple)type
  $count = get_entities_from_metadata('simpletype', $simpletype, 'object', 'file', $SESSION['user']->guid, $limit, $offset, '', 0, true);
  $entities = get_entities_from_metadata('simpletype', $simpletype, 'object', 'file', $SESSION['user']->guid, $limit, $offset, '', 0, false);
} else {
  // Get specified types and subtypes
  $count = get_entities($a_types, $entity_subtypes, $SESSION['user']->guid, '', null, null, true);
  $entities = get_entities($a_types, $entity_subtypes, $SESSION['user']->guid, '', $limit, $offset);
}

// Echo the upload + embed view
echo elgg_view('embed/mediaupload', array(
    'entities' => $entities, 
    'internalname' => $internalname, 
    'offset' => $offset, 
    'count' => $count, 
    'simpletype' => $simpletype, 
    'limit' => $limit, 
    'simpletypes' => $types, 
  ));

