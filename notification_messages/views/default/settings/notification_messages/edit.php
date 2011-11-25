<?php
if ($object_types = get_registered_entity_types()) {
  foreach($object_types as $object_type => $subtype_array) {
    if (($object_type === "object") && is_array($subtype_array) && sizeof($subtype_array)) {
      foreach($subtype_array as $object_subtype) {
        $subtypes_list .= (empty($subtypes_list)) ? $object_subtype : ",$object_subtype";
      }
    }
  }
}

// Hook behaviour (what is returned to the hook after subtype filtering - not once done)
$hookbehaviour_opt = array( 
    'false' => elgg_echo('notification_messages:hookbehaviour:false'), 
    'true' => elgg_echo('notification_messages:hookbehaviour:true'), 
  );
echo '<br /><label style="clear:left;">' . elgg_echo('notification_messages:settings:behaviour') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[hookbehaviour]', 'options_values' => $hookbehaviour_opt, 'value' => $vars['entity']->hookbehaviour));
echo '<p>' . elgg_echo('notification_messages:settings:behaviour:help') . '</p><br />';

// GLOBAL subtypes filter (overrides event filters)
echo '<label style="clear:left;">' . elgg_echo('notification_messages:settings:globalsubtypes') . elgg_view('input/text', array('internalname' => 'params[globalsubtypes]', 'value' => $vars['entity']->globalsubtypes)) . '</label>';
echo '<p>' . elgg_echo('notification_messages:settings:globalsubtypes:help') . '<strong>' . $subtypes_list . '</strong></p><br /><br />';


// CREATE subtypes
echo '<label style="clear:left;">' . elgg_echo('notification_messages:settings:createsubtypes') . elgg_view('input/text', array('internalname' => 'params[createsubtypes]', 'value' => $vars['entity']->createsubtypes)) . '</label>';
echo '<p>' . elgg_echo('notification_messages:settings:createsubtypes:help') . '</p><br />';

// UPDATE subtypes
echo '<label style="clear:left;">' . elgg_echo('notification_messages:settings:updatesubtypes') . elgg_view('input/text', array('internalname' => 'params[updatesubtypes]', 'value' => $vars['entity']->updatesubtypes)) . '</label>';
echo '<p>' . elgg_echo('notification_messages:settings:updatesubtypes:help') . '</p><br />';

// ANNOTATE subtypes
echo '<label style="clear:left;">' . elgg_echo('notification_messages:settings:annotatesubtypes') . elgg_view('input/text', array('internalname' => 'params[annotatesubtypes]', 'value' => $vars['entity']->annotatesubtypes)) . '</label>';
echo '<p>' . elgg_echo('notification_messages:settings:annotatesubtypes:help') . '</p><br />';


// Debug mode (sends mail to admin (GUID 2) each time the notifiction system is triggered)
$debugmode_opt = array( 
    'false' => elgg_echo('notification_messages:debugmode:false'), 
    'true' => elgg_echo('notification_messages:debugmode:true'), 
  );
echo '<br /><label style="clear:left;">' . elgg_echo('notification_messages:settings:debugmode') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[debugmode]', 'options_values' => $debugmode_opt, 'value' => $vars['entity']->debugmode));
echo '<p>' . elgg_echo('notification_messages:settings:debugmode:help') . '</p><br />';

if ($vars['entity']->debugmode != 'true') $debug = ' disabled="disabled"';
// Debug settings : notified user(s)
echo '<label style="clear:left;">' . elgg_echo('notification_messages:settings:debugmails') . elgg_view('input/text', array('internalname' => 'params[debugmails]', 'js' => '"'.$debug, 'value' => $vars['entity']->debugmails)) . '</label>';
echo '<p>' . elgg_echo('notification_messages:settings:debugmails:help') . '</p><br />';

// Debug settings : time threshhold
echo '<label style="clear:left;">' . elgg_echo('notification_messages:settings:debugthreshold') . elgg_view('input/text', array('internalname' => 'params[debugthreshold]', 'js' => '"'.$debug, 'value' => $vars['entity']->debugthreshold)) . '</label>';
echo '<p>' . elgg_echo('notification_messages:settings:debugthreshold:help') . '</p><br />';


