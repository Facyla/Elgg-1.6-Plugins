<?php
$page_owner = $vars['page_owner'];
$parent = $vars['parent'];
$owner_url = $CONFIG->wwwroot . "pg/pages/owned/" . get_entity($page_owner)->username;
$sep = $vars['sep'];
$wrap1 = $vars['wrap1'];
$wrap2 = $vars['wrap2'];

echo '<a href="'.$owner_url.'">' . elgg_echo('pages:user') . '</a>' . $wrap2;

//see if the new page's parent has a parent
$breadcrumbs = '';
$getparent = get_entity($parent->parent_guid);
while ($getparent instanceof ElggObject) {
  $breadcrumbs = "$wrap1 $sep " . '<a href="' . $getparent->getURL() . '">' . $getparent->title . '</a>' . $wrap2 . $breadcrumbs;
  $getparent = get_entity($getparent->parent_guid);
}

echo $breadcrumbs;

//if it is adding a page, make the last page a link, otherwise, don't
if ($parent instanceof ElggObject) {
  if($vars['add']) {
    echo $wrap1 . $sep . ' <a href="'.$parent->getURL().'">' . $parent->title . '</a>' . $wrap2 . $wrap1 . $sep . ' ' . elgg_echo('pages:new');
  } else {
    echo $wrap1 . $sep . ' ' . $parent->title;
  }
} else {
  if($vars['add']) echo $wrap1 . $sep . ' ' . elgg_echo('pages:new');
}

