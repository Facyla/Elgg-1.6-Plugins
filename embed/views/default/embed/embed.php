<?php
if ($vars['entity'] instanceof ElggEntity) {
  $title = $vars['entity']->title; if (empty($title)) $title = $vars['entity']->name;
  echo '<a href="'. $vars['entity']->getURL() .'">' . $title . '</a>';
}
