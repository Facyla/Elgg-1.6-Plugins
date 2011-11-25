<?php
/**
 * Subscriber
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Fabrice Collette
 * this plugin has been founded by Fondation Maison des Sciences de l'Homme - Paris	 
 * @copyright Fabrice Collette 2010
 * @link http://www.meleze-conseil.com
 *
 * @update by Facyla : clean code + add admin settings for easier behaviour configuration
 * @description : Adds a "subscribe" button in group's and user's owner_block
   - can be configured to force notification by email when joining a group (default : not activated)
   - can be configured to add following/followers widgets (default : not activated)
*/

function subscribe_plugin_init() {
  
  global $CONFIG;
  
  extend_view('css','subscribe/css'); // Mutisite caching issue - caching is OK, but retrieving CSS not.. so we include it straight
  if (isloggedin()) {
    extend_view('owner_block/extend','subscribe/extendownerblock', 100);
  
  extend_view('explore/explore_site','subscribe/extendownerblock', 100);
  extend_view('explore/explore_site','subscribe/extendprofilemenu', 400);
    
    // Extend hover-over menu	
    extend_view('profile/menu/links','subscribe/extendprofilemenu', 400);
  }
  
  // Load the language file
  register_translations($CONFIG->pluginspath . "subscribe/languages/");
  
  // add/remove  notification by email when joining/leaving a group
  register_elgg_event_handler('delete','member','subscribe_delete_member', 800); // Auto-remove when leaving a group is not an option !
  // Auto subscribe by email when joining a group IS an option
  if (get_plugin_setting('defaultnotifyemail', 'subscribe') === "yes") { register_elgg_event_handler('create','member','subscribe_create_member', 800); }
  // Notification popup when joining a group IS an option too
  if (get_plugin_setting('popupongroupjoin', 'subscribe') === "yes") { register_plugin_hook('action', 'groups/join', 'subscribe_joingroup_popup'); }
  
  // Widgets
  if (get_plugin_setting('activatewidgets', 'subscribe') === "yes") {
    add_widget_type('subscribers',elgg_echo("subscribe:subscribers:widget:title"),elgg_echo('subscribe:subscribers:widget:description'));
    add_widget_type('subscribed',elgg_echo("subscribe:subscribed:widget:title"),elgg_echo('subscribe:subscribed:widget:description'));
  }
}


function is_follower($member_guid) {
  $user_guid = $_SESSION['user']->guid;
  if ((check_entity_relationship($user_guid,'notifyemail', $member_guid)) || (check_entity_relationship($user_guid,'notifysite', $member_guid)) ) {
    return true;
  } else {
    return false;
  }
}

function subscribe_create_member($event, $object_type, $object) {
  global $CONFIG;
  if (isloggedin()) {
    if (($object instanceof ElggRelationship) && ($event == 'create') && ($object_type == 'member')) {
      add_entity_relationship($object->guid_one, 'notifyemail', $object->guid_two);
    }
  }
  return true;
}

function subscribe_delete_member($event, $object_type, $object) {
  global $CONFIG;
  if (isloggedin()) {
    if (($object instanceof ElggRelationship) && ($event == 'create') && ($object_type == 'member')) {
      remove_entity_relationship($object->guid_one, 'notifyemail', $object->guid_two);
    }
  }
  return true;
}

function subscribe_joingroup_popup($hook, $entity_type, $returnvalue, $params) {
  global $CONFIG;
  system_messages('dummy','subscribealert');
  return true;
}


register_elgg_event_handler('init','system','subscribe_plugin_init');

