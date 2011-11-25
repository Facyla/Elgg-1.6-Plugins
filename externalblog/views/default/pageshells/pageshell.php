<?php

/**
* Elgg pageshell
* The standard HTML page shell that everything else fits into
* 
* @package Elgg
* @subpackage Core
* @author Curverider Ltd
* @link http://elgg.org/
* 
* @uses $vars['config'] The site configuration settings, imported
* @uses $vars['title'] The page title
* @uses $vars['body'] The main content of the page
* @uses $vars['messages'] A 2d array of various message registers, passed from system_messages()
*/

if ($externalblog_css = get_plugin_setting('css', 'externalblog')) {} else { $externalblog_css = ""; }

header("Content-type: text/html; charset=UTF-8");

// Set title
if (empty($vars['title'])) { $title = $vars['config']->sitename; } 
  else if (empty($vars['config']->sitename)) { $title = $vars['title']; } 
  else { $title = $vars['config']->sitename . ": " . $vars['title']; }

echo elgg_view('page_elements/header', $vars);
echo "<style>$externalblog_css
#two_column_left_sidebar { width:200px !important; }
</style>";

if(isloggedin()) {
  echo elgg_view('page_elements/elgg_topbar', $vars);
  echo elgg_view('page_elements/header_contents', $vars);
  ?>
  
  <!-- main contents -->
  
  <!-- display any system messages -->
  <?php echo elgg_view('messages/list', array('object' => $vars['sysmessages'])); ?>
  
  <div id="externalblog_layout">
  <!-- inner (externalblog) header -->
  <?php 
  if ($header = get_plugin_setting('header', 'externalblog')) echo html_entity_decode($header, ENT_QUOTES, 'UTF-8');
  //echo elgg_view('expages/front_left');
  ?>
  <div style="clear:both;"></div>
  
  <!-- canvas -->
  <div id="layout_canvas">
  <?php echo $vars['body']; ?>
  <div class="clearfloat"></div>
  </div><!-- /#layout_canvas -->

  <!-- inner (externalblog) footer -->
  <?php if ($footer = get_plugin_setting('footer', 'externalblog')) echo html_entity_decode($footer, ENT_QUOTES, 'UTF-8'); ?>
  <div style="clear:both;"></div>
  
  </div>

  <!-- spotlight -->
  <?php echo elgg_view('page_elements/spotlight', $vars); ?>

  <!-- footer -->
  <?php echo elgg_view('page_elements/footer', $vars); ?>
  <div style="clear:both;"></div>
  
  <?php
} else {
  ?>
  <div id="externalblog_layout">
  <!-- header -->
  <?php 
  if ($header = get_plugin_setting('header', 'externalblog')) echo html_entity_decode($header, ENT_QUOTES, 'UTF-8');
  //echo elgg_view('expages/front_left');
  ?>
  <div style="clear:both;"></div>
    
  <!-- main contents -->
  <div id="externalblog_content">
    <?php echo $vars['body']; ?>
    <div style="clear:both;"></div>
  </div>

  <!-- footer -->
  <?php
  if ($footer = get_plugin_setting('footer', 'externalblog')) echo html_entity_decode($footer, ENT_QUOTES, 'UTF-8');
  //echo elgg_view('expages/front_right');
  echo '</div>';
}
