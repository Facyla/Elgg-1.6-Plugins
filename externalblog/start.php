<?php
/**
 * Elgg external blog view (multisite)
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright (cc) Facyla 2010
 * @link http://id.facyla.net/
 * Description :
 */

function externalblog_init() {
  global $CONFIG;

  // Remplace la page d'accueil
  register_plugin_hook('index','system','externalblog_index');
  
  // Ajout des balises meta définies dans la config et désactivation des flux automatiques (SSI remplacement défini côté config) 
  // => cf. page_elements/header (pas moyen de le gérer direct via extend_view et global $autofeed d'ici)
  
  // Register a page handler, so we can have nice URLs
  register_page_handler('blog','externalblog_page_handler');
  register_page_handler('tag','externalblog_tag_page_handler');
  register_page_handler('search','externalblog_search_page_handler');
  
  // Facyla 20110208
  register_action("externalblog/plugins_settings_save",false, $CONFIG->pluginspath . "externablog/actions/plugins_settings_save.php");
  
}


function externalblog_index() {
  global $CONFIG;
  $mainpage = get_plugin_setting('mainpage', 'externalblog');
  if (!empty($mainpage)) {
    // Attention car on n'a plus rien si URL erronée !
    $url = @fopen($CONFIG->url . $mainpage, 'r'); 
    if ($url) forward($CONFIG->url . $mainpage);
    register_error(elgg_echo('externalblog:configuration:mainpage:badurl'));
  }
  if (!@include_once(dirname(__FILE__) . "/index.php")) return false;
  return true;
}

function externalblog_pagesetup() {
  if ( ( (get_context() == 'admin') && isadminloggedin() ) || (get_context() == 'localmultisite') ) {
    global $CONFIG;
    add_submenu_item(elgg_echo('externalblog:configuration'), $CONFIG->wwwroot . 'mod/externalblog/configuration.php');
  }
}

function externalblog_page_handler($page) {
  // The first component of a blog URL is the username
  if (isset($page[0])) { set_input('username',$page[0]); }
  // In case we have further input
  if (isset($page[2])) { set_input('param2',$page[2]); }
  // In case we have further input
  if (isset($page[3])) { set_input('param3',$page[3]); }
  // Override default blog page handler for read view
  if (isset($page[1]) && ($page[1] == "read")) {
    set_input('blogpost',$page[2]);
    include(dirname(__FILE__) . "/read.php");
    return true;
  }
  return false;
}

// En combinaison avec la réécriture de la vue output/tags, permet de renvoyer sur le filtrage par tag
// la recherche par tag ne donne rien de probant en multisite avec externalblog, les contenus ayant été créés ailleurs
function externalblog_tag_page_handler($page) {
  // The first component of a blog URL is the username
  if (isset($page[0])) { set_input('tag',$page[0]); }
  include(dirname(__FILE__) . "/index.php");
  return true;
}

function externalblog_search_page_handler($page) {
  include(dirname(__FILE__) . "/search.php");
  return true;
}


/* Layout switch - facility for use into views and other plugins
 * @description : utilise la config d'externalblog pour afficher le layout, sauf si les blocs définis par défaut sont overridés par d'autres params
 * @return : content string, usually for use into page_draw..
 * @params :
    - content : sets page content (area2)
    - $params (array) : other settings ; if not an array, sets the corresponding value to true
      * title : adds a title
      * $layout : overrides default layout name (set by externablog) ; must exist as a canvas/layout/ view
      * area1 : overrides default content
      * area3 : overrides default content
      * area4 : overrides default content
      * area5 : overrides default content
      * wrapper : adds wrappers if set
*/
function externalblog_layout_switch($content, $params) {
  if (!is_array($params)) { $params = array($params => true); }
  
  if ($content) $content = '<div style="padding:5px 20px; margin:0; border:0;">' . $content . '</div>';
  if (!empty($params['title'])) $content = elgg_view_title($title) . $content;
  
  if (!isset($params['layout'])) {
    if ($layout=get_plugin_setting('layout','externalblog')) { $params['layout'] = html_entity_decode($layout,ENT_QUOTES,'UTF-8'); }
  }
  
  if ($params['wrappers']) {
    $before = get_plugin_setting('wrapper_before', 'externalblog');
    $after = get_plugin_setting('wrapper_after', 'externalblog');
    $content = $before . $content . $after;
  }

  // On override SSI on a autre chose de fourni (même vide)
  if (!isset($params['area1']) && ($sidebar=get_plugin_setting('sidebar','externalblog'))) { $params['area1'] = html_entity_decode($sidebar,ENT_QUOTES,'UTF-8'); }
  if (!isset($params['area3']) && ($area3=get_plugin_setting('divthree','externalblog'))) { $params['area3'] = html_entity_decode($area3,ENT_QUOTES,'UTF-8'); }
  if (!isset($params['area4']) && ($area4=get_plugin_setting('divfour','externalblog'))) { $params['area4'] = html_entity_decode($area4,ENT_QUOTES,'UTF-8'); }
  if (!isset($params['area5']) && ($area5=get_plugin_setting('divfive','externalblog'))) { $params['area5'] = html_entity_decode($area5,ENT_QUOTES,'UTF-8'); }

  // Display the contents in chosen layout
  switch ($layout) {
    case "one_column" :
      $body = elgg_view_layout($layout, $content);
      break;
    case "right_column" :
      $body = elgg_view_layout($layout, $params['area1'], $content);
      break;
    case "two_column" :
      $body = elgg_view_layout($layout, $params['area1'], $content);
      break;
    case "three_column" :
      $body = elgg_view_layout($layout, $params['area1'], $content, $params['area3']);
      break;
    case "four_column" :
      $body = elgg_view_layout($layout, $params['area1'], $content, $params['area3'], $params['area4']);
      break;
    case "five_column" :
      $body = elgg_view_layout($layout, $params['area1'], $content, $params['area3'], $params['area4'], $params['area5']);
      break;
    default:
      $body = elgg_view_layout('right_column', $params['area1'], $content);
  }
  return $body;
}


register_elgg_event_handler('init','system','externalblog_init');
register_elgg_event_handler('pagesetup','system','externalblog_pagesetup');
