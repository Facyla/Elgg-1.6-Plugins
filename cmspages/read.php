<?php
/**
* Elgg read CMS page
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

// Load Elgg engine
define('cmspage', true);
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

//gatekeeper();

$pagetype = get_input('pagetype');

if($pagetype) {
  // cmspages/view view should return description only (and other elements should be hidden), as it's designed for inclusion into other views
  // cmspages/read may render more content
  $body = elgg_view('cmspages/read', array('pagetype' => $pagetype));
  
} else {
  // $body = elgg_echo('cmspages:notset');
  register_error(elgg_echo('cmspages:notset'));
  forward();
}


// Si externalblog est activé et qu'on a paramétré la prise en compte des layouts choisis, on applique ce layout
// @todo : On anticipe sur la possibilité de choisir divers blocs et le layout via les pages CMS...?
$exbloglayout = get_plugin_setting('layout', 'cmspages');
$exbloglayout = ($exbloglayout == "exbloglayout") ? true : false;
// Ca ne fonctionne que si externalblog est activé
if ($exbloglayout && is_plugin_enabled('externalblog') && ($layout = get_plugin_setting('layout', 'externalblog'))) {
  
  // On utilise alors les blocs définis via externalblog
  $content = '<div style="padding:5px 20px; margin:0; border:0;">' . $body . '</div>';
  $body = externalblog_layout_switch($content, array('title' => $title));
}


// Display page
page_draw($title, $body);

