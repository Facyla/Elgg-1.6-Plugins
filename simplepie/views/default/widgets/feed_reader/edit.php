<?php
$num_items = $vars['entity']->num_items;
if (!isset($num_items)) $num_items = 10;
$excerpt = $vars['entity']->excerpt;
$post_date = $vars['entity']->post_date;

$feedyesno_opt = array('no' => elgg_echo('simplepie:settings:no'), 'yes' => elgg_echo('simplepie:settings:yes'));
?>

<p>
  <?php echo elgg_echo("simplepie:feed_url"); ?>
  <input type="text" onclick="this.select();" name="params[feed_url]" value="<?php echo htmlentities($vars['entity']->feed_url); ?>" />  
</p>

<p>
<?php echo elgg_echo('simplepie:num_items'); ?>

<?php
echo elgg_view('input/pulldown', array(
    'internalname' => 'params[num_items]',
    'options_values' => array( '3' => '3', '5' => '5', '8' => '8', '10' => '10', '12' => '12', '15' => '15', '20' => '20' ),
    'value' => $num_items
  ));
?>
</p>

<p>
  <?php 
  //echo elgg_view('input/hidden', array('internalname' => 'params[excerpt]', 'js' => 'id="params[excerpt]"', 'value' => $excerpt ));
  echo elgg_echo('simplepie:excerpt') . ' : ';
  echo elgg_view('input/pulldown', array( 'internalname' => 'params[excerpt]', 'options_values' => $feedyesno_opt, 'value' => $excerpt ));
  ?>
</p>  

<p>
  <?php 
  //echo elgg_view('input/hidden', array('internalname' => 'params[post_date]', 'js' => 'id="params[post_date]"', 'value' => $post_date ));
  echo elgg_echo('simplepie:post_date');
  echo elgg_view('input/pulldown', array( 'internalname' => 'params[post_date]', 'options_values' => $feedyesno_opt, 'value' => $post_date ));
  ?>
</p>  
