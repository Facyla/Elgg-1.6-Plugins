<?php
/**
 * Elgg notifications plugin index
 * 
 * @package ElggNotifications
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */

// Load Elgg framework
require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');
global $CONFIG;

// Ensure only logged-in users can see this page
gatekeeper();

// Set the context to settings
set_context('settings');

global $SESSION;

$subscribers = array();
// Counts email subscribers
$email_subscribers = get_entities_from_relationship('notifyemail', $SESSION['user']->guid, true,'user','',0,'',999, false, 0);
foreach ($email_subscribers as $e) {$subscribers[] = $e;}
// Adds site subscribers
$site_subscribers = get_entities_from_relationship('notifysite', $SESSION['user']->guid, true,'user','',0,'',999, false, 0);
foreach ($site_subscribers as $s) { if (!in_array($s, $subscribers)) {$subscribers[] = $s;} }
$count = count($subscribers);


// Builds page
$body = elgg_view_title( ('subscribe:list:title') . page_owner_entity()->name ) . 'views<br />';
$viewlist = $CONFIG->views->extensions['owner_block/extend'];
foreach ($viewlist as $view) { $body .= elgg_get_view_location($view)."<br />";}
// inserts subscribers
$body .= elgg_view_entity_list($subscribers, $count, 0, 20, true, false, true); 

// Insert it into the correct canvas layout
$body = elgg_view_layout('two_column_left_sidebar', '', ''.$body);

// Draw the page
page_draw(elgg_echo('notifications:subscriptions:changesettings'), $body);

