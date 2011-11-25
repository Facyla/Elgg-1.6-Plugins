<?php
global $CONFIG;
$compat_url = $CONFIG->wwwroot . 'mod/simplepie/sp_compatibility_test.php';
$permit_url = $CONFIG->wwwroot . 'mod/simplepie/permissions.php';
$feedyesno_opt = array('no' => elgg_echo('simplepie:settings:no'), 'yes' => elgg_echo('simplepie:settings:yes'));


// WIDGET
echo '<br /><label style="clear:left;">' . elgg_echo('simplepie:settings:feedwidget') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[feedwidget]', 'options_values' => $feedyesno_opt, 'value' => $vars['entity']->feedwidget));
echo '<p>' . elgg_echo('simplepie:settings:feedwidget:help') . '</p><br />';

// FEED OBJECT
echo '<br /><label style="clear:left;">' . elgg_echo('simplepie:settings:feedobject') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[feedobject]', 'options_values' => $feedyesno_opt, 'value' => $vars['entity']->feedobject));
echo '<p>' . elgg_echo('simplepie:settings:feedobject:help') . '</p><br />';

// MAIN PAGE
/*
echo '<br /><label style="clear:left;">' . elgg_echo('simplepie:settings:feedpage') . '</label>';
echo elgg_view('input/pulldown', array('internalname' => 'params[feedpage]', 'options_values' => $feedyesno_opt, 'value' => $vars['entity']->feedpage));
echo '<p>' . elgg_echo('simplepie:settings:feedpage:help') . '</p><br />';
*/

// MAIN PAGE : TITLE
echo '<label style="clear:left;">' . elgg_echo('simplepie:settings:feedtitle') . ' ' . elgg_view('input/text', array('internalname' => 'params[feedtitle]', 'js' => 'style="width:300px;"', 'value' => $vars['entity']->feedtitle)) . '</label><br />';

// MAIN PAGE : URL
echo '<label style="clear:left;">' . elgg_echo('simplepie:feed_url') . ' ' . elgg_view('input/text', array('internalname' => 'params[feed_url]', 'js' => 'style="width:300px;"', 'value' => $vars['entity']->feed_url)) . '</label><br />';

// MAIN PAGE : NUM_ITEMS
echo '<label style="float:left; margin-right: 20px;">' . elgg_echo('simplepie:num_items') . elgg_view('input/pulldown',array('internalname' => 'params[feednum_items]', 'options_values' => array("1" => 1,"2" => 2,"3" => 3, "5" => 5, "7" => 7, "20" => 20, "50" => 50, "100" => 100, ), 'value' => $vars['entity']->feednum_items, )) . '</label>';

// MAIN PAGE : EXCERPT
echo '<label style="float:left; margin-right: 20px;">' . elgg_echo('simplepie:excerpt') . elgg_view('input/pulldown', array('internalname' => 'params[feedexcerpt]', 'options_values' => $feedyesno_opt, 'value' => $vars['entity']->feedexcerpt)) . '</label>';

// MAIN PAGE : POST_DATE
echo '<label style="float:left; margin-right: 20px;">' . elgg_echo('simplepie:post_date') . elgg_view('input/pulldown', array('internalname' => 'params[feedpost_date]', 'options_values' => $feedyesno_opt, 'value' => $vars['entity']->feedpost_date)) . '</label><br /><br />';

// MAIN PAGE : DESCRIPTION
echo '<label style="clear:left;">' . elgg_echo('description') . elgg_view('input/longtext', array('internalname' => 'params[feeddescription]', 'value' => $vars['entity']->feeddescription)) . '</label><br />';


?>
<br />
<div class="contentWrapper">
  <ul>
  <li><a href="<?php echo $CONFIG->url; ?>mod/simplepie/"><?php echo elgg_echo('simplepie:mainpageurl'); ?></a></li>
  <li><a href="<?php echo $compat_url; ?>"><?php echo elgg_echo('simplepie:compatibilitytest'); ?></a></li>
  <li><a href="<?php echo $permit_url; ?>"><?php echo elgg_echo('simplepie:permissioncheck'); ?></a></li>
  </ul>
</div>
