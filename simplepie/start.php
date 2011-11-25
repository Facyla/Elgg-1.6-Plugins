<?php
/**
* Simplepie Plugin
* 
* Loads the simplepie feed parser library
* Adds a widget
* Sets a "feed" object and configurable views
* 
**/

global $CONFIG;

function simplepie_init() {    
  global $CONFIG;
  
  extend_view('css','feed/css');
  
  $enable_widget = get_plugin_setting('feedwidget', 'simplepie');
  $enable_object = get_plugin_setting('feedobject', 'simplepie');
  
  if ($enable_widget === "yes") {
    add_widget_type('feed_reader', elgg_echo('simplepie:widget'), elgg_echo('simplepie:description'));
  }
  
  // Register entity type
  if ($enable_object === "yes") {
    register_entity_type('object','feed');
    add_group_tool_option('feed',elgg_echo('feed:enablefeed'), false); // Add group menu option only if object activated..
    extend_view('groups/groupprofile', 'feed/group', 900);
    register_elgg_event_handler('pagesetup','system','simplepie_submenus');
  }
  
  if (isloggedin()) add_menu(elgg_echo('feed:add'), $CONFIG->url . "mod/simplepie/"); // Tools menu entry
  
//  register_page_handler('training','simplepie_page_handler'); // Register a page handler, so we can have nice URLs
  
}


function simplepie_submenus() {
  global $CONFIG;
  $page_owner = page_owner_entity();
  $context = get_context();
  if ($context == "simplepie") { add_submenu_item(elgg_echo('simplepie:mainpage'), $CONFIG->wwwroot . "mod/simplepie/"); }
  if ( (($context == "simplepie") || ($context == "groups")) && ($page_owner instanceof ElggGroup) && ($page_owner->feed_enable == "yes") ) {
    add_submenu_item(elgg_echo('simplepie:group'), $CONFIG->url . "mod/simplepie/?container_guid=" . $page_owner->guid);
/*
    // Tout membre d'un groupe a la possibilité de créer et éditer les(ses) flux
    if ($page_owner->isMember($_SESSION['guid'])) {
      add_submenu_item(elgg_echo('simplepie:new'), $CONFIG->url . "mod/simplepie/edit.php?container_guid=". $page_owner->guid);
    }
*/
  }
}

function simplepie_adminsubmenus() {
  global $CONFIG;
  if ( ( (get_context() == 'admin') && isadminloggedin() ) || (get_context() == 'localmultisite') ) {
    add_submenu_item(elgg_echo('simplepie:configuration'), $CONFIG->wwwroot . 'mod/simplepie/configuration.php');
  }
}

/* Simplepie page handler
function simplepie_page_handler($page) {
  global $CONFIG;
  // /pg/simplepie/CONTAINER/OBJECT/ACTION/TITLE
  // 0 : container_guid
  // 1 : action OU object_guid
  // 2 : action (string)
  $action = "mainpage"; // Cas général : on liste tout (interface de recherche)
  if (strlen($page[0]) > 0) { set_input('container_guid',$page[0]); $action = "listing"; } // Plutôt listing si on a un container
  if (strlen($page[1]) > 0) {
    // Plutôt affichage d'un flux si on a l'objet concerné, sauf cas de la création d'un nouveau flux
    if ($page[1] === "new") { $action = "new"; } else { set_input('feed_guid',$page[1]); $action = "view"; }
    if ($page[1] === "edit") { set_input('container_guid',$page[0]); $action = "edit"; } // Inutile de donner le container pour éditer
  }
  if (($action != "new") && ($action != "edit") && (strlen($page[2]) > 0)) { $action = $page[2]; } // Plutôt une autre action si on sait laquelle, et qu'on ne crée pas un nouvel objet
  switch($action) {
    case "mainpage":
      include($CONFIG->pluginspath . "simplepie/world.php");
      break;
    case "listing":
      include(dirname(dirname(dirname(__FILE__))) . "simplepie/index.php");
      break;
    case "view":
      include($CONFIG->pluginspath . "simplepie/view.php");
      break;
    case "new":
      include($CONFIG->pluginspath . "simplepie/edit.php");
      break;
    case "edit":
      include($CONFIG->pluginspath . "simplepie/edit.php");
      break;
    default:
      include($CONFIG->pluginspath . "simplepie/index.php");
      break;
  }
}
*/



register_elgg_event_handler('plugins_boot', 'system', 'simplepie_init');
register_elgg_event_handler('pagesetup','system','simplepie_adminsubmenus');

register_action('feed/edit',false,$CONFIG->pluginspath . "simplepie/actions/edit.php");
register_action('feed/delete',false,$CONFIG->pluginspath . "simplepie/actions/delete.php");

