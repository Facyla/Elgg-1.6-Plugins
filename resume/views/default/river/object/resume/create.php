<?php
/**
 * Resume
 *
 * @package Resume
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$object = get_entity($vars['item']->object_guid);

$url = '<a href="'.$performed_by->getURL().'">'.$performed_by->name.'</a>';

// Facyla : easier to handle more subtype, if ever
$subtype = $object->getSubtype();
$itemType = elgg_echo("resume:river:$subtype");

$string = sprintf(elgg_echo("resume:river:created"), $url, $itemType) . " ";
$string .= elgg_echo('resume:menu:item') . '</a> : ';
if ($subtype == 'language') {
  $string .= '<a href="' . $object->getURL() . '">' . elgg_echo($object->language) . '</a>';
} else {
  $string .= '<a href="' . $object->getURL() . '">' . $object->title . '</a>';
}

echo $string;
