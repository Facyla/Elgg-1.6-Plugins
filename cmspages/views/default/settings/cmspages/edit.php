<?php

/* @todo : ce serait intéressant de pouvoir le définir indépendament d'externalblog aussi - on verra à l'usage
$layout_options = array( 
    'one_column' => elgg_echo('externalblog:settings:layout:one_column'), 
    'right_column' => elgg_echo('externalblog:settings:layout:right_column'), 
    'two_column' => elgg_echo('externalblog:settings:layout:two_column'), 
    'three_column' => elgg_echo('externalblog:settings:layout:three_column'), 
    'four_column' => elgg_echo('externalblog:settings:layout:four_column'), 
    'five_column' => elgg_echo('externalblog:settings:layout:five_column'), 
  );
*/
$layout_options = array( 
    '' => elgg_echo('cmspages:settings:layout:default'), 
    'exbloglayout' => elgg_echo('cmspages:settings:layout:externalblog'), 
  );
echo '<br /><label style="clear:left;">' . elgg_echo('cmspages:settings:layout') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[layout]', 'options_values' => $layout_options, 'value' => $vars['entity']->layout));
echo '<p>' . elgg_echo('cmspages:settings:layout:help') . '</p>';

echo '<br /><label style="clear:left;">' . elgg_echo('cmspages:settings:editors') . '</label>';
echo elgg_view('input/text', array('internalname' => 'params[editors]', 'value' => $vars['entity']->editors));
echo '<p>' . elgg_echo('cmspages:settings:editors:help') . ' (' . $_SESSION['name'] . ': ' . $_SESSION['guid'] . ')</p>';

