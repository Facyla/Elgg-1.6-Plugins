<p><?php echo elgg_echo('breadcrumbtrail:settings:description'); ?></p>

<p>
	<label><?php echo elgg_echo('breadcrumbtrail:settings:mainstyle'); ?> 
    <input type="text" name="params[mainstyle]" value="<?php echo $vars['entity']->mainstyle; ?>" />
  </label>
</p>

<p>
	<label><?php echo elgg_echo('breadcrumbtrail:settings:background'); ?> 
    <input type="text" name="params[background]" value="<?php echo $vars['entity']->background; ?>" />
  </label>
</p>

<p>
	<label><?php echo elgg_echo('breadcrumbtrail:settings:arrow'); ?> 
    <input type="text" name="params[arrow]" value="<?php echo $vars['entity']->arrow; ?>" />
  </label>
</p>

<p>
	<label><?php echo elgg_echo('breadcrumbtrail:settings:arrowhover'); ?> 
    <input type="text" name="params[arrowhover]" value="<?php echo $vars['entity']->arrowhover; ?>" />
  </label>
</p>

<p>
	<label><?php echo elgg_echo('breadcrumbtrail:settings:separator'); ?> 
    <input type="text" name="params[separator]" value="<?php echo $vars['entity']->separator; ?>" />
  </label>
</p>

