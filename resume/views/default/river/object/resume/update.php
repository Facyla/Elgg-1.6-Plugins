<?php
$performed_by = get_entity($vars['item']->subject_guid); // $statement->getSubject();
$object = get_entity($vars['item']->object_guid);

$url = '<a href="'.$performed_by->getURL().'">'.$performed_by->name.'</a>';

// Facyla : easier to handle more subtype, if ever
$subtype = $object->getSubtype();
$itemType = elgg_echo("resume:river:$subtype");

$string = sprintf(elgg_echo("resume:river:updated"), $url, $itemType) . " ";
$string .= elgg_echo('resume:menu:item') . '</a> : ';
if ($subtype == 'language') {
  $string .= '<a href="' . $object->getURL() . '">' . elgg_echo($object->language) . '</a>';
} else {
  $string .= '<a href="' . $object->getURL() . '">' . $object->title . '</a>';
}

echo $string;
