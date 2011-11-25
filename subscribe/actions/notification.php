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

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/engine/start.php');

// Restrict to logged in users
action_gatekeeper();

// Load important global vars
global $SESSION;
global $NOTIFICATION_HANDLERS;

$group_guid = get_input('group');
$group_entity = get_entity($group_guid);

foreach($NOTIFICATION_HANDLERS as $method => $foo) {
  $subscriptions[$method] = get_input($method.'subscriptions');
  $personal[$method] = get_input($method.'personal');
  $collections[$method] = get_input($method.'collections');

  if (in_array($group_guid,$subscriptions[$method])) {
    add_entity_relationship($SESSION['user']->guid,'notify'.$method,$group_guid);
    if ($group_entity instanceof ElggUser) {
      $subject = sprintf(elgg_echo('subscribe:notify:subject'),$SESSION['user']->name);
      $message = sprintf(elgg_echo('subscribe:notify:message'),$SESSION['user']->name, $SESSION['user']->getURL());
      notify_user($group_guid, $SESSION['user']->guid, $subject, $message);
    }
  } else {
    remove_entity_relationship($SESSION['user']->guid,'notify'.$method,$group_guid);
  }
}

system_message(elgg_echo('notifications:subscriptions:success'));

// Avoid redirecting to a callback call
$url = $_SESSION['subscribe_url'];
$url = preg_replace('`callback=(\w+)`','',$url);
$url = preg_replace('`&&`','&',$url);

//forward($_SESSION['subscribe_url']);
forward($url);
