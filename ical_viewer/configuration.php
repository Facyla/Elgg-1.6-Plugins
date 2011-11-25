<?php
/**
 * Elgg ical_viewer configuration
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

$title = elgg_echo('ical_viewer:settings:description');

$body .= elgg_view_title($title) 
  . '<div class="contentWrapper">' 
  . elgg_view('input/form', array(
    'body' => elgg_view('settings/ical_viewer/edit', array('entity' => find_plugin_settings('ical_viewer'))) 
      . elgg_view('input/securitytoken') 
      . '<input name="plugin" value="ical_viewer" type="hidden">'
      . '<input type="submit" value="' . elgg_echo('save') . '" />', 
//    'action' => $CONFIG->url . 'action/plugins/settings/save')) 
    'action' => $CONFIG->url . 'mod/ical_viewer/actions/icalviewer_settings_save.php')) 
  . '</div>';



// Display the contents
$body = elgg_view_layout("two_column_left_sidebar", '', $body);

page_draw($title, $body);

