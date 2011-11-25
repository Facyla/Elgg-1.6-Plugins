<?php
// Facyla : override view only if not logged in !

if (isloggedin()) {
	/** Elgg 2 column left sidebar canvas layout */ ?>
  <!-- left sidebar -->
  <div id="two_column_left_sidebar">
    <?php echo elgg_view('page_elements/owner_block',array('content' => $vars['area1'])); ?>
    <?php if (isset($vars['area3'])) echo $vars['area3']; ?>
  </div><!-- /two_column_left_sidebar -->

  <!-- main content -->
  <div id="two_column_left_sidebar_maincontent">
    <?php if (isset($vars['area2'])) echo $vars['area2']; ?>
  </div><!-- /two_column_left_sidebar_maincontent -->
  <?php

} else {

	/** Elgg right_column  layout */
  if ($sidebar = get_plugin_setting('sidebar', 'externalblog')) { $sidebar = html_entity_decode($sidebar, ENT_QUOTES, 'UTF-8'); } else { $sidebar = ""; }
  ?>

  <!-- sidebar -->
<!--
  <div id="externalblog_right_column" style="float:right; margin:0 !important; padding:0 !important; border:0 !important; width:30% !important;">
//-->
  <div id="externalblog_right_column">
    <?php echo $sidebar; ?>
  </div><!-- /sidebar -->

  <!-- main content -->
<!--
  <div id="externalblog_left_column" style="float:left; margin:0 !important; padding:0 !important; border:0 !important; width:70% !important;">
//-->
  <div id="externalblog_left_column">
      <?php echo $vars['area2']; ?>
  </div><!-- /left_column -->


  <?php
}
?>
