<?php
global $CONFIG;
$yesno_opt = array('no' => elgg_echo('resume:settings:no'), 'yes' => elgg_echo('resume:settings:yes'));


// Activate Widget (instead of extending userdetails view)
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:resumewidget') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[resumewidget]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->resumewidget));
echo '<p>' . elgg_echo('resume:settings:resumewidget:help') . '</p><br />';


// workexperience
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:workexperience') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[workexperience]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->workexperience));
echo '<p>' . elgg_echo('resume:settings:workexperience:help') . '</p><br />';

// education
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:education') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[education]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->education));
echo '<p>' . elgg_echo('resume:settings:education:help') . '</p><br />';

// experience (other experience or reference)
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:experience') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[experience]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->experience));
echo '<p>' . elgg_echo('resume:settings:experience:help') . '</p><br />';

// language
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:language') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[language]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->language));
echo '<p>' . elgg_echo('resume:settings:language:help') . '</p><br />';

// skill
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:skill') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[skill]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->skill));
echo '<p>' . elgg_echo('resume:settings:skill:help') . '</p><br />';

// skill_ciiee
echo '<br /><label style="clear:left;">' . elgg_echo('resume:settings:skill_ciiee') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[skill_ciiee]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->skill_ciiee));
echo '<p>' . elgg_echo('resume:settings:skill_ciiee:help') . '</p><br />';
