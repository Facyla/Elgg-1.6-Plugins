<?php
/**
 * Elgg pin for self action
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Elgg.fr
 * @copyright Elgg.fr
 * @link http://elgg.fr/
*/

require_once (dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();
action_gatekeeper();

$guid = get_input('guid', false);
$entity = get_entity($guid);
$user = $_SESSION['user'];
$callback = get_input('callback', false);

if (($entity instanceof ElggEntity) && ($user instanceof ElggUser)) {
  $action = get_input('action', 'memorize');
  switch($action) {
    case 'unmemorize':
      // La valeur doit exister pour être retirée
      if ($user->memorized) {
        $memorized = explode(';', $user->memorized);
        if (in_array($guid, $memorized)) {
          unset($memorized[array_search($guid, $memorized)]);
          $user->memorized = implode(';', $memorized);
          if ($callback) { header('HTTP/1.1 200 OK'); echo elgg_echo('pin:memorized:false'); exit; } else { system_message(elgg_echo('pin:memorized:false')); }
        } else {
          if ($callback) { header('HTTP/1.1 200 OK'); echo elgg_echo('pin:error:unmemorized'); exit; } else { register_error(elgg_echo('pin:error:unmemorized')); }
        }
      } else {
        if ($callback) { header('HTTP/1.1 200 OK'); echo elgg_echo('pin:error:unmemorized'); exit; } else { register_error(elgg_echo('pin:error:unmemorized')); }
      }
      break;
    case 'memorize':
    default:
      // On ajoute aux précédents
      if ($user->memorized) {
        $memorized = explode(';', $user->memorized);
        if (!in_array($guid, $memorized)) { $memorized[] = $guid; }
        $memorized = implode(';', $memorized);
      // Première fois ? plus facile
      } else {
        //system_message('Aucun contenu mémorisé');
        $memorized = $guid;
      }
      if ($user->memorized = $memorized) {
        if ($callback) { header('HTTP/1.1 200 OK'); echo elgg_echo('pin:memorized:true'); exit; } else { system_message(elgg_echo('pin:memorized:true')); }
      } else {
        if ($callback) { header('HTTP/1.1 200 OK'); echo elgg_echo('pin:error:memorized'); exit; } else { register_error(elgg_echo('pin:error:memorized')); }
      }
  }
}

/*
if ($guid > 0) {
  if ($entity = get_entity($guid)) {
    if ($entity->canEdit()) {
      if (add_entity_relationship($_SESSION['guid'], "memorize", $guid)) system_message(elgg_echo('pin:ok:memorize'));
      else register_error(elgg_echo('pin:error:memorize'));
    } else register_error(elgg_echo('pin:error:cantedit'));
  } else register_error(elgg_echo('pin:error:invalidentity'));
}
*/

forward($_SESSION['last_forward_from']);
