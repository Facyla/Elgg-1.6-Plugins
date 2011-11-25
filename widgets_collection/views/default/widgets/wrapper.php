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
$title = elgg_echo("$title");

// Add title link, only if set
if (!empty($vars['entity']->widgetlink)) $title = '<a href="'.$vars['entity']->widgetlink.'">'.$title.'</a>';
// Add detailed description on hover, only if set
if (!empty($vars['entity']->widgetdetails)) $title = '<span class="tooltips-s" title="'.$vars['entity']->widgetdetails.'">'.$title.'</a>';
// 
if ($vars['entity']->defaultopen == 'yes') $startopen = true; else $startopen = false;

// Add opening wrapper if not a callback
if ($callback != "true") {
  ?>
  <div id="widget<?php echo $vars['entity']->getGUID(); ?>">
    
    <div class="collapsable_box">
      
      <div class="collapsable_box_header">
        <?php
        if ($startopen) {
          echo '<a href="javascript:void(0);" class="toggle_box_contents">-</a>';
        } else {
          echo '<a href="javascript:void(0);" class="toggle_box_contents">+</a>';
        }
        ?>
        <?php if (isloggedin() && $vars['entity']->canEdit()) {
          if ($startopen) {
            echo '<a href="javascript:void(0);" class="toggle_box_edit_panel">' . elgg_echo('edit') . '</a>';
          } else {
            echo '<a href="javascript:void(0);" class="toggle_box_edit_panel" style="display:none;">' . elgg_echo('edit') . '</a>';
          }
        } ?>
        <h1><?php echo $title; ?></h1>
      </div>
      
      <?php if (isloggedin() && $vars['entity']->canEdit()) { ?>
        <div class="collapsable_box_editpanel">
          <?php echo elgg_view('widgets/editwrapper', array( 'body' => elgg_view("widgets/{$handler}/edit", $vars), 'entity' => $vars['entity'] ) ); ?>
        </div><!-- /collapsable_box_editpanel -->
      <?php } ?>
      
      <?php
      if ($startopen) {
        echo '<div class="collapsable_box_content">';
      } else {
        echo '<div class="collapsable_box_content" style="display:none;">';
      }
      ?>
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
