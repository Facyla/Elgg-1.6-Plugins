<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;

$limit = 999;

$title = elgg_echo('pin:title');
$body = '';


// Highlighted - for everybody
$usehighlight = get_plugin_setting('highlight', 'pin');
if ($usehighlight == 'yes') {
  $body .= '<h3>' . elgg_echo('pin:highlighted:title') . '</h3>';
  $ents = get_entities_from_metadata('highlight', '', 'object', '', 0, $limit, 0, '', -1);
  //$ents = get_entities_from_metadata('highlight', '', 'object', '', 0, 10);
  //get_entities_from_annotations ($entity_type="", $entity_subtype="", $name="", $value="", $owner_guid=0, $group_guid=0, $limit=10, $offset=0, $order_by="asc", $count=false, $timelower=0, $timeupper=0);
  //$ents = get_entities_from_annotations("object", "", "memorize", "", 0, 0, 10, 0, "asc", false, 0, 0);
  $body .= '<ul>';
  foreach ($ents as $ent) {
    $linktext = $ent->title;
    if (empty($linktext)) $linktext = $ent->description;
    if (empty($linktext)) $linktext = elgg_echo('item:object:'.$ent->getSubtype());
    $body .= '<li><a href="' . $ent->getURL() . '">' . $linktext . '</a> - <small>' . get_entity($ent->container_guid)->name . '</small></li>';
  }
  $body .= '</ul>';
}


// Memorized : global
$usememorize = get_plugin_setting('memorize', 'pin');
if ($usememorize == 'yes') {
  if (isadminloggedin()) {
    $body .= '<h3>' . elgg_echo('pin:memorized:title') . '</h3>';
    $users = get_entities_from_metadata('memorized', '', 'user', '', 0, $limit, 0, '', -1);
    $body .= '<ul>';
    foreach ($users as $user) {
      $memorized = explode(';', $user->memorized);
      $body .= '<li><a href="' . $user->getURL() . '">' . $user->name . '</a><ul>';
      foreach ($memorized as $entguid) {
        if ($ent = get_entity($entguid)) {
          $linktext = $ent->title;
          if (empty($linktext)) $linktext = $ent->description;
          if (empty($linktext)) $linktext = elgg_echo('item:object:'.$ent->getSubtype());
          $body .= '<li><a href="' . $ent->getURL() . '">' . $linktext . '</a> - <small>' . get_entity($ent->container_guid)->name . '</small></li>';
        }
      }
      $body .= '</ul></li>';
    }
    $body .= '</ul>';
  }
}


// Memorized : loggedin user
$usememorize = get_plugin_setting('memorize', 'pin');
if ($usememorize == 'yes') {
  if (isloggedin()) {
    $user = $_SESSION['user'];
    $body .= '<h3>' . elgg_echo('pin:memorized:title') . ' : ' . $user->username . '</h3>';
    $memorized = explode(';', $user->memorized);
    $body .= '<a href="' . $user->getURL() . '">' . $user->name . '</a><ul>';
    foreach ($memorized as $entguid) {
      if ($ent = get_entity($entguid)) {
        $linktext = $ent->title;
        if (empty($linktext)) $linktext = $ent->description;
        if (empty($linktext)) $linktext = elgg_echo('item:object:'.$ent->getSubtype());
        $body .= '<li><a href="' . $ent->getURL() . '">' . $linktext . '</a> - <small>' . get_entity($ent->container_guid)->name . '</small></li>';
      }
    }
    $body .= '</ul>';
  }
}


// User footprint - for information but better used in context (in a "what i read" listing)
$usefootprint = get_plugin_setting('footprint', 'pin');
if ($usefootprint == 'yes') {
  if (isloggedin()) {
    $user = $_SESSION['user'];
    $body .= '<h3>' . elgg_echo('pin:footprint:title') . '</h3>';
    $ents = get_entities_from_metadata('footprint', '', 'object', '', 0, $limit, 0, '', -1);
    $body .= '<ul>';
    foreach ($ents as $ent) {
      if (empty($ent->title)) $body .= '<li><a href="' . $ent->getURL() . '">[ ' . $ent->getSubtype() . ' ' . $ent->guid . ' ]</a> : ';
      else $body .= '<li><a href="' . $ent->getURL() . '">' . $ent->title . ' [' . $ent->guid . ']</a> : ';
      if (empty($ent->footprint)) {
          $body .= elgg_echo('pin:footprint:neverread') . ', ';
      } else {
        // Lecture du contenu
        $footprint = unserialize($ent->footprint);
        $numreaders = sizeof($footprint);
        if (isset($footprint['0'])) {
          $pubreaders = $footprint['0'];
          $numreaders--; // Retire 1 lecteur (= compteur hits publics)
        }
        // Si déjà consulté
        if (isset($footprint[$_SESSION['guid']])) {
          $youread = sprintf(elgg_echo('pin:footprint:youread'), friendly_time($footprint["{$_SESSION['guid']}"]));
        }
        $body .= sprintf(elgg_echo('pin:footprint:entstats'), $numreaders, $pubreaders) . $youread;
      }
      $body .= '</li>';
    }
    $body .= '</ul>';
  }
}


// Build page content
$body = elgg_view_title($title) . '<div class="contentWrapper">' . $body . '</div>';
$body = elgg_view_layout('one_column', $body);

// Finally draw the page
page_draw($title, $body);

