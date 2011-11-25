<?php
global $resume_menu;
if(!$resume_menu && get_context() != "resumes") {
  $page_owner = page_owner_entity();
  if ($page_owner === false || is_null($page_owner)) { $page_owner = get_loggedin_user(); }
  // Add link to resume option once (some views may list more than one resume element fullview at a time)
  add_submenu_item(sprintf(elgg_echo('resume:user'), $page_owner->name), $CONFIG->wwwroot . "pg/resumes/" . $page_owner->username, "main_resume");
  if (is_plugin_enabled('protovis')) {
    add_submenu_item(elgg_echo('resume:chronogram'), $CONFIG->wwwroot . "mod/resume/chronogramme.php?id=" . $page_owner->guid, "main_resume");
    //add_submenu_item(elgg_echo('resume:skillgraph'), $CONFIG->wwwroot . "mod/resume/skillgraph.php?id=" . $page_owner->guid, "main_resume"); // @todo
  }
  $resume_menu = true;
}
