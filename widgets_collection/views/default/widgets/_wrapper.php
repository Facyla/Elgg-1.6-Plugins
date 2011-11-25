<?php
$callback = get_input('callback');

static $widgettypes;
if (!isset($widgettypes)) { $widgettypes = get_widget_types(); }

if ($vars['entity'] instanceof ElggObject && $vars['entity']->getSubtype() == 'widget') {
	$handler = $vars['entity']->handler;
	// Facyla 20110830 : implement generic custom widget titles
	$title = $vars['entity']->widgettitle;
	if (!$title) { $title = $widgettypes[$vars['entity']->handler]->name; }
	if (!$title) { $title = $handler; }
} else { return TRUE; }

// Add opening wrapper if not a callback
if ($callback != "true") {
  ?>
  <div id="widget<?php echo $vars['entity']->getGUID(); ?>">
    <div class="collapsable_box">
      <div class="collapsable_box_header">
        <a href="javascript:void(0);" class="toggle_box_contents">-</a>
        <?php if (isloggedin() && $vars['entity']->canEdit()) { ?>
            <a href="javascript:void(0);" class="toggle_box_edit_panel"><?php echo elgg_echo('edit'); ?></a>
        <?php } ?>
        <h1><?php echo $title; ?></h1>
      </div>
      
      <?php if (isloggedin() && $vars['entity']->canEdit()) { ?>
        <div class="collapsable_box_editpanel">
          <?php echo elgg_view('widgets/editwrapper', array( 'body' => elgg_view("widgets/{$handler}/edit", $vars), 'entity' => $vars['entity'] ) ); ?>
        </div><!-- /collapsable_box_editpanel -->
      <?php } ?>
      
      <div class="collapsable_box_content">
        <div id="widgetcontent<?php echo $vars['entity']->getGUID(); ?>">
  <?php
} else {
	// end if callback != "true"
	// this is a callback so we need script for avatar menu
	?>
  <script language="javascript">
    $(document).ready(function(){ setup_avatar_menu(); });
  </script>
  <?php
}

if (elgg_view_exists("widgets/{$handler}/view")) {
	echo elgg_view("widgets/{$handler}/view", $vars);
} else {
	echo elgg_echo('widgets:handlernotfound');
}

// Add closing wrapper if not a callback
if ($callback != "true") {
  ?>
			</div>
		</div><!-- /.collapsable_box_content -->
	</div><!-- /.collapsable_box -->
</div>	
  <?php
}
