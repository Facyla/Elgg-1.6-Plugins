<?php
if ($vars['entity'] instanceof ElggGroup) {
  echo '<a href="'. $vars['entity']->getURL() .'" title="' . $vars['entity']->briefdescription . '">' . $vars['entity']->name . '</a>' 
    . '<p class="tags">' . elgg_view('output/tags', array('value' => $vars['entity']->tags)) . '</p>' // marche pas ??
//    . '<br />' . $vars['entity']->briefdescription
    . '<br />' . $vars['entity']->description;
}
