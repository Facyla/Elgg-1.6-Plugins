<?php
/*
// Pratique pour tout lister automatiquement avec des beaux titres, mais on va faire ça plus bourrin et efficace
if ($object_types = get_registered_entity_types()) {
  // Note : les Sites ne sont pas listés de cette manière : les ajouter à la main si besoin..
  // et les dossiers donnent un nom inapproprié aux "object"
  foreach($object_types as $object_type => $subtype_array) {
    $label = elgg_echo('item:' . $object_type);
    $type_options[$label] = $object_type;
    if (($object_type === "object") && is_array($subtype_array) && sizeof($subtype_array)) {
      foreach($subtype_array as $object_subtype) {
        $label = 'item:' . $object_type;
        if (!empty($object_subtype)) $label .= ':' . $object_subtype;
        $label = elgg_echo($label);
        $subtype_options[$label] = $object_subtype;
      }
    }
  }
}

echo '<label>' . elgg_echo('embed:settings:allowed_types') . '</label><br />';
echo elgg_view('input/checkboxes', array('internalname' => 'params[allowed_types]', 'options' => $type_options, 'value' => $vars['entity']->allowed_types) );

echo '<br />';
echo '<label>' . elgg_echo('embed:settings:allowed_subtypes') . '</label><br />';
echo elgg_view('input/checkboxes', array('internalname' => 'params[allowed_subtypes]', 'options' => $subtype_options, 'value' => $vars['entity']->allowed_subtypes) );

*/

if ($object_types = get_registered_entity_types()) {
  // Note : les Sites ne sont pas listés de cette manière : les ajouter à la main si besoin..
  // et les dossiers donnent un nom inapproprié aux "object"
  foreach($object_types as $object_type => $subtype_array) {
    $type_options .= (empty($type_options)) ? $object_type : ',' . $object_type;
    if (($object_type === "object") && is_array($subtype_array) && sizeof($subtype_array)) {
      foreach($subtype_array as $object_subtype) {
        $subtype_options .= (empty($subtype_options)) ? $object_subtype : ',' . $object_subtype;
      }
    }
  }
}


echo '<label>' . elgg_echo('embed:settings:allowed_types') . '</label> : ' . $type_options . '<br />';
echo elgg_view('input/text', array('internalname' => 'params[allowed_types]', 'value' => $vars['entity']->allowed_types) );

echo '<br />';
echo '<label>' . elgg_echo('embed:settings:allowed_subtypes') . '</label> : ' . $subtype_options . '<br />';
echo elgg_view('input/text', array('internalname' => 'params[allowed_subtypes]', 'value' => $vars['entity']->allowed_subtypes) );

