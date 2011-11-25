<?php
/**
 * Subscriber
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Fabrice Collette
 * this plugin has been founded by Fondation Maison des Sciences de l'Homme - Paris	 
 * @copyright Fabrice Collette 2010
 * @link http://www.meleze-conseil.com
*/

// Load Elgg framework
require_once(dirname(dirname(dirname(__FILE__))) . '/engine/start.php');

$group_guid = get_input('guid');

// Ensure only logged-in users can see this page
gatekeeper();


// Get the form
global $SESSION, $CONFIG;
$people = array();

$group = get_entity($group_guid);

$body = elgg_view('input/form', array(
    'body' => elgg_view('subscribe/setsubscribenotification', array( 'group' => $group )),
    'method' => 'post',
    'action' => $CONFIG->wwwroot . 'mod/subscribe/actions/notification.php?group='.$group_guid
  ));

echo $body;

