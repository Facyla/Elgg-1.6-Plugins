<?php
echo '<label>' . elgg_echo('subscribe:settings:defaultnotifyemail') . '</label>';
echo elgg_view('input/pulldown', array(
    'internalname' => 'params[defaultnotifyemail]', 
    'options_values' => array('no' => elgg_echo('subscribe:no'), 'yes' => elgg_echo('subscribe:yes')), 
    'value' => $vars['entity']->defaultnotifyemail
  ));

echo '<br />';
echo '<label>' . elgg_echo('subscribe:settings:activatewidgets') . '</label>';
echo elgg_view('input/pulldown', array(
    'internalname' => 'params[activatewidgets]', 
    'options_values' => array('no' => elgg_echo('subscribe:no'), 'yes' => elgg_echo('subscribe:yes')), 
    'value' => $vars['entity']->activatewidgets
  ));

echo '<br />';
echo '<label>' . elgg_echo('subscribe:settings:popupongroupjoin') . '</label>';
echo elgg_view('input/pulldown', array(
    'internalname' => 'params[popupongroupjoin]', 
    'options_values' => array('no' => elgg_echo('subscribe:no'), 'yes' => elgg_echo('subscribe:yes')), 
    'value' => $vars['entity']->popupongroupjoin
  ));

