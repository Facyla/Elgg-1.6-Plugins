<?php
//echo '<p style="font-weight:bold">' . elgg_echo('externalblog:settings:description') . '</p><br />';

echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:title') . ' :</label> ';
echo elgg_view('input/text', array('internalname' => 'params[blog_title]', 'js' => 'style="width:500px;"', 'value' => $vars['entity']->blog_title));
echo '<p>' . elgg_echo('externalblog:settings:title:help') . '</p><br />';


/* FILTRES DE CONTENU */

// SITES
$sites = get_entities("site", "", "", "", 99999, 0, false, -1); $sites = array_reverse($sites , true);
//foreach ($groups as $group_ent) { $group_options[$group_ent->guid] = substr($group_ent->name, 0, 36).'...'; }
$site_options[-1] = elgg_echo('externalblog:settings:nofilter');
foreach ($sites as $site_ent) { $site_options[$site_ent->guid] = $site_ent->name; }
$site_select = elgg_view('input/pulldown', array('internalname' => 'params[filtersite]', 'options_values' => $site_options, 'value' => $vars['entity']->filtersite));
echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:site') . $site_select . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:site:help') . '</p><br />';

// GROUPES
$groups = get_entities("group", "", "", "", 99999, 0, false, -1); $groups = array_reverse($groups , true);
//foreach ($groups as $group_ent) { $group_options[$group_ent->guid] = substr($group_ent->name, 0, 36).'...'; }
$group_options[null] = elgg_echo('externalblog:settings:nofilter');
foreach ($groups as $group_ent) { $group_options[$group_ent->guid] = $group_ent->name; }
$group_select = elgg_view('input/pulldown', array('internalname' => 'params[group_guid]', 'options_values' => $group_options, 'value' => $vars['entity']->group_guid));
echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:group') . $group_select . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:group:help') . '</p><br />';

// OWNERS (auteurs)
$owners = get_entities("user", "", "", "", 99999, 0, false, -1); $owners = array_reverse($owners , true);
//foreach ($owners as $owner_ent) { $owner_options[$owner_ent->guid] = substr($owner_ent->name, 0, 36).'...'; }
$owner_options[null] = elgg_echo('externalblog:settings:nofilter');
foreach ($owners as $owner_ent) { $owner_options[$owner_ent->guid] = $owner_ent->name; }
$owner_select = elgg_view('input/pulldown', array('internalname' => 'params[filterowner]', 'options_values' => $owner_options, 'value' => $vars['entity']->filterowner));
echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:owner') . $owner_select . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:owner:help') . '</p><br />';

// SUBTYPES
if ($object_types = get_registered_entity_types()) foreach($object_types as $object_type => $subtype_array)
    if (($object_type === "object") && is_array($subtype_array) && sizeof($subtype_array)) 
      foreach($subtype_array as $object_subtype) { $subtypes_list .= (empty($subtypes_list)) ? $object_subtype : ",$object_subtype"; }
echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:subtypes') . elgg_view('input/text', array('internalname' => 'params[subtypes]', 'js' => 'style="width:300px;"', 'value' => $vars['entity']->subtypes)) . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:subtypes:help') . " ($subtypes_list)" . '</p><br />';

// TAGS
echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:filtertag') . elgg_view('input/text', array('internalname' => 'params[filtertag]', 'js' => 'style="width:300px;"', 'value' => $vars['entity']->filtertag)) . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:filtertag:help') . '</p><br />';

// ORDER BY
$orderby_options = array( '' => elgg_echo('externalblog:settings:nofilter'), 
    'time_updated desc' => elgg_echo('externalblog:orderby:modifieddesc'), 'time_updated asc' => elgg_echo('externalblog:orderby:modifiedasc'), 
    'time_created desc' => elgg_echo('externalblog:orderby:createddesc'), 'time_created asc' => elgg_echo('externalblog:orderby:createdasc'), 
  );
echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:orderby') . elgg_view('input/pulldown', array('internalname' => 'params[orderby]', 'options_values' => $orderby_options, 'value' => $vars['entity']->orderby)) . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:orderby:help') . '</p><br />';



/* INTERFACE DU SITE EXTERNE */

// PAGE D'ACCUEIL
echo '<label style="clear:left;">' . elgg_echo('externalblog:settings:mainpage') . '</label><br />';
echo $CONFIG->url . elgg_view('input/text', array('internalname' => 'params[mainpage]', 'js' => 'style="width:400px;"', 'class' => "", 'value' => $vars['entity']->mainpage));
echo '<p>' . elgg_echo('externalblog:settings:mainpage:help') . '</p><br />';

// RECHERCHE
$searchscope_options = array( 
    'localonly' => elgg_echo('externalblog:settings:searchscope:localonly'), 
    'extend' => elgg_echo('externalblog:settings:searchscope:extend'), 
    'all' => elgg_echo('externalblog:settings:searchscope:all'), 
  );
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:searchscope') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[searchscope]', 'options_values' => $searchscope_options, 'value' => $vars['entity']->searchscope));
echo '<p>' . elgg_echo('externalblog:settings:searchscope:help') 
  . '<p>URL : ' . $CONFIG->url . 'mod/externalblog/search.php</p>' . '</p>';


// LAYOUT
$layout_options = array( 
    'one_column' => elgg_echo('externalblog:settings:layout:one_column'), 
    'right_column' => elgg_echo('externalblog:settings:layout:right_column'), 
    'two_column' => elgg_echo('externalblog:settings:layout:two_column'), 
    'three_column' => elgg_echo('externalblog:settings:layout:three_column'), 
    'four_column' => elgg_echo('externalblog:settings:layout:four_column'), 
    'five_column' => elgg_echo('externalblog:settings:layout:five_column'), 
  );
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:layout') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[layout]', 'options_values' => $layout_options, 'value' => $vars['entity']->layout));
echo '<p>' . elgg_echo('externalblog:settings:layout:help') . '</p>';

// CSS (surcharge la CSS globale)
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:css') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:css:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[css]', 'class' => 'NoEditor', 'value' => $vars['entity']->css));
echo '<textarea id="params[css]" class="NoEditor NoRichText mceNoeditor" name="params[css]" rows="3">' . $vars['entity']->css . '</textarea><br />';

// Metatags (remplace les liens RSS et ODD si défini)
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:metatags') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:metatags:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[metatags]', 'class' => 'NoEditor', 'value' => $vars['entity']->metatags));
echo '<textarea id="params[metatags]" class="NoEditor NoRichText mceNoeditor" name="params[metatags]" rows="3">' . $vars['entity']->metatags . '</textarea><br />';

// HEADER
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:header') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:header:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[header]', 'class' => "", 'value' => $vars['entity']->header));
echo '<textarea id="params[header]" class="NoEditor NoRichText mceNoeditor" name="params[header]">' . $vars['entity']->header . '</textarea><br />';

// SEPARATEUR (entre les articles)
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:separator') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:separator:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[separator]', 'class' => '', 'value' => $vars['entity']->separator));
echo '<textarea id="params[separator]" class="NoEditor NoRichText mceNoeditor" name="params[separator]">' . $vars['entity']->separator . '</textarea><br />';

// WRAPPER (avant la liste d'articles)
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:wrapper:before') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:wrapper:before:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[wrapper_before]', 'class' => "", 'value' => $vars['entity']->wrapper_before));
echo '<textarea id="params[wrapper_before]" class="NoEditor NoRichText mceNoeditor" name="params[wrapper_before]">' . $vars['entity']->wrapper_before . '</textarea><br />';

// WRAPPER (après la liste d'articles)
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:wrapper:after') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:wrapper:after:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[wrapper_after]', 'class' => "NoEditor NoRichText mceNoeditor", 'value' => $vars['entity']->wrapper_after));
echo '<textarea id="params[wrapper_after]" class="NoEditor NoRichText mceNoeditor" name="params[wrapper_after]">' . $vars['entity']->wrapper_after . '</textarea><br />';

// FOOTER
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:footer') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:footer:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[footer]', 'class' => "NoEditor NoRichText mceNoeditor", 'value' => $vars['entity']->footer));
echo '<textarea id="params[footer]" class="NoEditor NoRichText mceNoeditor" name="params[footer]">' . $vars['entity']->footer . '</textarea><br />';

// SIDEBAR
echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:sidebar') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:sidebar:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[sidebar]', 'class' => "", 'value' => $vars['entity']->sidebar));
echo '<textarea id="params[sidebar]" class="NoEditor NoRichText mceNoeditor" name="params[sidebar]">' . $vars['entity']->sidebar . '</textarea><br />';


echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:divthree') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:divthree:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[divthree]', 'class' => "", 'value' => $vars['entity']->divthree));
echo '<textarea id="params[divthree]" class="NoEditor NoRichText mceNoeditor" name="params[divthree]">' . $vars['entity']->divthree . '</textarea><br />';


echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:divfour') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:divfour:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[divfour]', 'class' => "", 'value' => $vars['entity']->divfour));
echo '<textarea id="params[divfour]" class="NoEditor NoRichText mceNoeditor" name="params[divfour]">' . $vars['entity']->divfour . '</textarea><br />';


echo '<br /><label style="clear:left;">' . elgg_echo('externalblog:settings:divfive') . '</label>';
echo '<p>' . elgg_echo('externalblog:settings:divfive:help') . '</p>';
//echo elgg_view('input/longtext', array('internalname' => 'params[divfive]', 'class' => "", 'value' => $vars['entity']->divfive));
echo '<textarea id="params[divfive]" class="NoEditor NoRichText mceNoeditor" name="params[divfive]">' . $vars['entity']->divfive . '</textarea><br />';


