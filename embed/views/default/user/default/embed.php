<?php
if ($vars['entity'] instanceof ElggUser) {
  $info = '<a href="'. $vars['entity']->getURL() .'">' . $vars['entity']->name . '</a>';
  $info .= '<p class="tags">' . elgg_view('output/tags', array('value' => $vars['entity']->tags)) . '</p>';
  $icon = "<a href=\"{$vars['entity']->getURL()}\">" . elgg_view("profile/icon", array('entity' => $vars['entity'], 'size' => 'small')) . "</a>";
  echo elgg_view('search/listing',array('icon' => $icon, 'info' => $info));
}
