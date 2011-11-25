<p>
  <?php echo elgg_echo("iframe:iframe_url"); ?>
  <input type="text" onclick="this.select();" name="params[iframe_url]" value="<?php echo htmlentities($vars['entity']->iframe_url); ?>" />  
</p>

<p>
  <?php echo elgg_echo("iframe:iframe_title"); ?>
  <input type="text" onclick="this.select();" name="params[iframe_title]" value="<?php echo htmlentities($vars['entity']->iframe_title); ?>" />  
</p>

<?php
/*
<p>
  <?php echo elgg_echo("iframe:iframe_height"); ?>
  <input type="text" onclick="this.select();" name="params[iframe_height]" value="<?php echo htmlentities($vars['entity']->iframe_height); ?>" />  
</p>
*/
?>
