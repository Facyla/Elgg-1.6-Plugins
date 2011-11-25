<?php
global $CONFIG;
$yesno_opt = array('no' => elgg_echo('widgets_collection:settings:no'), 'yes' => elgg_echo('widgets_collection:settings:yes'));


// webprofiles widget
echo '<br /><label style="clear:left;">' . elgg_echo('widgets_collection:settings:webprofiles') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[webprofiles]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->webprofiles));
echo '<p>' . elgg_echo('widgets_collection:settings:webprofiles:help') . '</p><br />';


// publications widget
echo '<br /><label style="clear:left;">' . elgg_echo('widgets_collection:settings:publications') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[publications]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->publications));
echo '<p>' . elgg_echo('widgets_collection:settings:publications:help') . '</p><br />';


// webprofiles widget
echo '<br /><label style="clear:left;">' . elgg_echo('widgets_collection:settings:friends') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[friends]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->friends));
echo '<p>' . elgg_echo('widgets_collection:settings:friends:help') . '</p><br />';

// anytext widget
echo '<br /><label style="clear:left;">' . elgg_echo('widgets_collection:settings:anytext') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[anytext]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->anytext));
echo '<p>' . elgg_echo('widgets_collection:settings:anytext:help') . '</p><br />';

/*
// ... widget
echo '<br /><label style="clear:left;">' . elgg_echo('widgets_collection:settings:CHANGE') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[CHANGE]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->CHANGE));
echo '<p>' . elgg_echo('widgets_collection:settings:CHANGE:help') . '</p><br />';
*/

