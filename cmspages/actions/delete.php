<?php
/**
 * Elgg cmspage delete action
 * 
 * @package Elgg
 * @subpackage cmspage
 * @author Facyla 2010
 * @copyright	Copyright (C) 2010 Université Paris Descartes.
 * @license 	http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
*/

$cmspage_guid = (int) get_input('cmspage_guid');

if (is_plugin_enabled('multisite')) { multisite_admin_gatekeeper(); } else { admin_gatekeeper(); }

action_gatekeeper();

if ($cmspage = get_entity($cmspage_guid)) {
  $container_guid = $cmspage->getContainer();
  if ($cmspage->canEdit()) {
    if ( ($cmspage->getSubtype() == "cmspage") && ($cmspage->canEdit()) ) {
      if ($cmspage->delete()) { system_message(elgg_echo("cmspages:deleted")); } else { register_error(elgg_echo("cmspages:delete:fail")); }
    } else { register_error(elgg_echo("cmspages:delete:fail")); }
  }
} else register_error(elgg_echo("cmspages:delete:fail"));

forward("pg/cmspages/");
