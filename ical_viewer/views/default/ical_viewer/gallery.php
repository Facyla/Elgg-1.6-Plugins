<?php
  $friendlytime = friendly_time($vars['entity']->time_created);
  $description = $vars['entity']->description;
  $icon = '<div class="search_listing_icon"><div class="usericon">';
  $icon .= '<a href=\"' . $vars['entity']->getURL() . '" class="icon"><img src="' . get_entity_icon_url($vars['entity'],'small') . '" border="0"></a></div></div>';

  $view_message = elgg_echo('ical_viewer:view');
  $info = '<p class="owner_timestamp"><a href="' . $vars['entity']->getURL() . '">' . $vars['entity']->name . '</a></p>';
  $info .= '<p style="text-align:justify;">' . $description . '</p>';
  
  echo elgg_view_listing($icon,$info);
?>