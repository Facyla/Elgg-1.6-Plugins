<?php
/**
 * Elgg Simple editing of CMS "static" pages
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2008-2010
 * @link http://id.facyla.net/
 */

function cmspages_init() {
  global $CONFIG;
  extend_view('css','cmspages/css');
  
  // Register entity type
  register_entity_type('object','cmspage');
  
  // Register a URL handler for CMS pages
  register_entity_url_handler('cmspage_url','object','cmspage');
  
  register_page_handler('cmspages','cmspages_page_handler'); // Register a page handler, so we can have nice URLs
}


/* Populates the ->getUrl() method for cmspage objects */
function cmspage_url($cmspage) {
  global $CONFIG;
  return $CONFIG->url . "pg/cmspages/read/" . $cmspage->pagetype;
}


function cmspages_page_handler($page) {
  global $CONFIG;
  if ($page[0]) {
    switch ($page[0]) {
      case "read":
        set_input('pagetype',$page[1]);
        @include(dirname(__FILE__) . "/read.php");
        break;
      default:
        include($CONFIG->pluginspath . "cmspages/index.php"); 
    }
  } else include($CONFIG->pluginspath . "cmspages/index.php"); 
}

/* Page setup. Adds admin controls to the admin panel. */
function cmspages_pagesetup() {
  global $CONFIG;
  if (get_context() === 'admin' && isadminloggedin()) add_submenu_item(elgg_echo('cmspages'), $CONFIG->url . 'pg/cmspages/');
  // Facyla: also allow local admins to use this tool
  if (get_context() === 'localmultisite') add_submenu_item(elgg_echo('cmspages'), $CONFIG->url . 'pg/cmspages/', 'tools');
  // Custom editor list
  if ((get_context() == 'cmspages_admin') && in_array($_SESSION['guid'], explode(',', get_plugin_setting('editors', 'cmspages')))) { add_submenu_item(elgg_echo('cmspages'), $CONFIG->url . 'pg/cmspages/', 'tools'); }
}

/* Permissions for the training context */
function cmspages_permissions_check($hook, $type, $returnval, $params) {
  if (get_context() === 'admin' && isadminloggedin()) return true;
  if (get_context() === 'localmultisite')  return true;
  if ( (get_context() == 'cmspages_admin') || in_array($_SESSION['guid'], explode(',', get_plugin_setting('editors', 'cmspages'))) )  return true;
	return NULL;
}



// Hooks
register_plugin_hook('permissions_check', 'object', 'cmspages_permissions_check');

// Initialise log browser
register_elgg_event_handler('init','system','cmspages_init');
register_elgg_event_handler('pagesetup','system','cmspages_pagesetup');

// Register actions
global $CONFIG;
register_action("cmspages/edit", false, $CONFIG->pluginspath . "cmspages/actions/edit.php");
register_action("cmspages/delete", false, $CONFIG->pluginspath . "cmspages/actions/delete.php");

