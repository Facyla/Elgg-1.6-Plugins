<?php
function pin_init() {
  global $CONFIG;
  
  extend_view('css','pin/css');
  extend_view('page_elements/deferred_js','pin/js');
  
  // Note : always extend, but actions are available only to valid loggedin users
  $extendfullonly = get_plugin_setting('extendfullonly ', 'pin');
  if ($extendfullonly == 'no') {
    extend_view('search/gallery','pin/extend_entity');
    extend_view('search/listing','pin/extend_entity');
  }
  
  // Highlight - displayed only for loggedin users
  $usehighlight = get_plugin_setting('highlight', 'pin');
  if (($usehighlight == 'yes') && isloggedin()) {
    // Types d'entités concernées
    $validhighlight = get_plugin_setting('validhighlight', 'pin');
    if (!empty($validhighlight)) $validhighlight = explode(',', $validhighlight);
    else $validhighlight = get_registered_entity_types('object');
    // Extend chosen entities views
    foreach($validhighlight as $type) {
      $type = trim($type);
      if ($type == 'groupforumtopic') extend_view("forum/viewposts",'pin/highlight_extend', 0);
      else extend_view("object/$type",'pin/highlight_extend', 300);
    }
  }
  
  // Memorize - displayed only for loggedin users
  $usememorize = get_plugin_setting('memorize', 'pin');
  if (($usememorize == 'yes') && isloggedin()) {
    // Types d'entités concernées
    $validmemorize = get_plugin_setting('validmemorize', 'pin');
    if (!empty($validmemorize)) $validmemorize = explode(',', $validmemorize);
    else $validmemorize = get_registered_entity_types('object');
    // Extend chosen entities views
    foreach($validmemorize as $type) {
      $type = trim($type);
      if ($type == 'groupforumtopic') extend_view("forum/viewposts",'pin/memorize_extend', 0);
      else extend_view("object/$type",'pin/memorize_extend', 300);
    }
  }
  
  // Footprint - has to be used both publicly and for loggedin users - precise display should be handled in extend view
  $usefootprint = get_plugin_setting('footprint', 'pin');
  if ($usefootprint == 'yes') {
    // Types d'entités concernées
    $validfootprint = get_plugin_setting('validfootprint', 'pin');
    if (!empty($validfootprint)) $validfootprint = explode(',', $validfootprint);
    else $validfootprint = get_registered_entity_types('object');
    // Extend chosen entities views
    foreach($validfootprint as $type) {
      $type = trim($type);
      if ($type == 'groupforumtopic') extend_view("forum/viewposts",'pin/footprint_extend', 0);
      else extend_view("object/$type",'pin/footprint_extend', 300);
      //else extend_view("object/$type",'pin/footprint_extend', 501);
    }
  }
  
  
  register_action("pin/highlight",false,$CONFIG->pluginspath . "pin/actions/highlight.php");
  register_action("pin/memorize",false,$CONFIG->pluginspath . "pin/actions/memorize.php");
  
}

register_elgg_event_handler('init','system','pin_init');
