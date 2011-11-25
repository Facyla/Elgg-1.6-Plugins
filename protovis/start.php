<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 * modified by id.Facyla.net
 */

function protovis_init() {
  extend_view('css','protovis/css');
  //extend_view('metatags','protovis/metatags');
  
  // Add group menu option
//    add_group_tool_option('protovis', elgg_echo('protovis:enablegroupprotoviss'), true);
}


register_elgg_event_handler('init','system','protovis_init');

