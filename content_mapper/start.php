<?php
  /** Elgg content mapper tool by Facyla http://id.facyla.net/
  * 
  * Batch object transformation : select content, and choose the mapping to proceed
  * 
  * Notes :
  *  - some metadata may be lost in the process : we assume they wouldn't work properly
  * 
  */

function content_mapper_init() {

  global $CONFIG;
  if ( isadminloggedin() && ((get_context() == 'content_mapper') || (get_context() == 'admin')) ) {
    add_submenu_item(elgg_echo('content_mapper:menu'), $CONFIG->url . 'mod/content_mapper/group_migration.php');
  }

}

// Make sure the plugin has been registered
register_elgg_event_handler('init','system','content_mapper_init');	

