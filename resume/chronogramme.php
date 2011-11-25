<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

// Requires protovis plugin (or the library at least)
if (!is_plugin_enabled('protovis')) forward();

$title = elgg_echo('resume:chronogram:title');

// Setup page
$body = elgg_view('resume/chronogram', array('full' => true));
  
  
// Display page
echo page_draw($title,$body);
