<?php
/**
 * Elgg simplepie configuration
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010
 * @link http://id.facyla.net/
 */

// Get the Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

global $CONFIG;

if (is_plugin_enabled('multisite')) { multisite_admin_gatekeeper(); set_context('localmultisite'); } 
else { admin_gatekeeper(); set_context('admin'); }

$title = elgg_echo('simplepie:settings:description');

$body .= elgg_view_title($title) 
  . '<div class="contentWrapper">' 
  . elgg_view('input/form', array(
    'body' => elgg_view('settings/simplepie/edit', array('entity' => find_plugin_settings('simplepie'))) 
      . elgg_view('input/securitytoken') 
      . '<input name="plugin" value="simplepie" type="hidden">'
      . '<input type="submit" value="' . elgg_echo('save') . '" />', 
    'action' => $CONFIG->url . 'action/plugins/settings/save')) 
  . '</div>';



// Display the contents
$body = elgg_view_layout("two_column_left_sidebar", '', $body);

page_draw($title, $body);

