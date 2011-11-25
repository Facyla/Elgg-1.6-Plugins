<?php
/**
 * Elgg pin action
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Elgg.fr
 * @copyright Elgg.fr
 * @link http://elgg.fr/
*/

// Start engine
require_once (dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");

gatekeeper();
action_gatekeeper();

$guid = get_input('guid');
$entity = get_entity($guid);
$callback = get_input('callback', false);

// Si déjà mis en avant
if ($entity->highlight) {
  // @todo voir si on annule la mise en avant, ou autre selon l'action demandée (par défaut : annuler)
  $action = get_input('action', 'unhighlight');
  switch($action) {
    case 'unhighlight':
    default:
      $entity->highlight = false;
      if ($callback) { header('HTTP/1.1 200 OK'); echo elgg_echo('pin:highlighted:false'); exit; } else { system_message(elgg_echo('pin:highlighted:false')); }
  }

// Si pas mis en avant, on le fait
} else {
  
  // @todo : utiliser plusieurs valeurs pour différencier différents types de mise en valeur ?
  $entity->highlight = true;
  if ($callback) { header('HTTP/1.1 200 OK'); echo elgg_echo('pin:highlighted:true'); exit; } else { system_message(elgg_echo('pin:highlighted:true')); }
  
}

forward($_SESSION['last_forward_from']);
