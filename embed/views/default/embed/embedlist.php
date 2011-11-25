<?php
$entity = $vars['entity'];
$friendlytime = friendly_time($entity->time_created);
?>
<div id="embedEntity<?php echo $entity->guid; ?>">
<?php
$title = $entity->title; if (empty($title)) $title = $entity->name;
$title = htmlentities($title, ENT_COMPAT, "UTF-8");
//$icon = elgg_view("user/icon", array("entity" => $entity->getOwnerEntity(), 'size' => 'small'));
$info = "<p><a href=\"{$entity->getURL()}\">$title</a></p>";
$info .= "<p class=\"owner_timestamp\">{$friendlytime}";

echo elgg_view('search/listing',array('icon' => $icon, 'info' => $info));
?>
</div>