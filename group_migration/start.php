<?php
  /** Elgg group content & members migration tool by Facyla http://id.facyla.net/
  * 
  * Batch migration of a group : select content and/or members, and choose the destination group to proceed. Also move groups between sites.
  * 
  * Notes :
  *  - please move one group at once : there are separate forms, so selecting multiple groups at the same time won't work
  *  - contents are transfered to the new group (= disapear from old group)
  *  - members are joined to the new group, but remain member of the old one
  *  - multisite-ready : modify feedback.php : $site_guid to change the scope and (dis)allow moving group content and members from one site to another
  */

function group_migration_init() {

  global $CONFIG;
  if ( (get_context() == 'admin' && isadminloggedin()) || (get_context() == 'localmultisite') ) {
    add_submenu_item(elgg_echo('group_migration:menu'), $CONFIG->url . 'mod/group_migration/group_migration.php');
    
    // Meaningful only in multisite context
    if (is_plugin_enabled('multisite')) { add_submenu_item(elgg_echo('group_migration:menu:transfer'), $CONFIG->url . 'mod/group_migration/group_transfer.php'); }
  }
}

// Make sure the plugin has been registered
register_elgg_event_handler('init','system','group_migration_init');	
