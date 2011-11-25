<?php
/* iCal viewer */

/* Initialise le thème */
function ical_viewer_init() {
  extend_view('css','ical_viewer/css');
  register_page_handler('ical','ical_viewer_page_handler');
  
  // Facyla 20110214
  register_action("ical_viewer/icalviewer_settings_save",false, $CONFIG->pluginspath . "ical_viewer/actions/icalviewer_settings_save.php");
}

// URL plus propres
function ical_viewer_page_handler($page) {
  if (isset($page[0])) {
    switch($page[0]) {
      case "read":
        include(dirname(__FILE__) . "/ical_viewer.php"); return true;
        break;
      default:
        include(dirname(__FILE__) . "/ical_viewer.php"); return true;
    }
  } else {
    @include(dirname(__FILE__) . "/ical_viewer.php");
    return true;
  }
  return false;
}

function makeLinksFromText($text) {
  // Credits : http://www.expreg.com/lire-URL-source
  $in = array(
    '`((?:https?|ftp)://\S+[[:alnum:]]/?)`si',
    '`((?<!//)(www\.\S+[[:alnum:]]/?))`si'
    );
  $out = array(
    '<a href="$1">$1</a>',
    '<a href="http://$1">$1</a>'
    );
  return preg_replace($in,$out,$text);
}

function ical_viewer_pagesetup() {
  if ( ( (get_context() == 'admin') && isadminloggedin() ) || (get_context() == 'localmultisite') ) {
    global $CONFIG;
    add_submenu_item(elgg_echo('ical_viewer:configuration'), $CONFIG->wwwroot . 'mod/ical_viewer/configuration.php');
  }
}


// Initialise log browser
register_elgg_event_handler('init','system','ical_viewer_init');
register_elgg_event_handler('pagesetup','system','ical_viewer_pagesetup');
