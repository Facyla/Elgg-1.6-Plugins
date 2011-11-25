<?php

  // Get the Elgg engine
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
  
  /* Get the plugin settings */
  // Titre par défaut peut être défini via le fichier de langues
  $title = get_plugin_setting('calendartitle', 'ical_viewer');
  if (empty($title)) $title = elgg_echo('ical_viewer:title');
  
  // Main calendar URL
  $url = get_plugin_setting('defaulturl', 'ical_viewer');
  
  // How many events should be displayed
  $num_items = get_plugin_setting('num_items', 'ical_viewer');
  
  // Timeframe for valid events
  $timeframe_before = get_plugin_setting('timeframe_before', 'ical_viewer');
  if (!isset($timeframe_before)) { $timeframe_before = 7; }
  $timeframe_after = get_plugin_setting('timeframe_after', 'ical_viewer');
  if (!isset($timeframe_after)) { $timeframe_after = 366; }
  
  $entity = array(
      'url' => "$url", 
      'title' => "$title", 
      'timeframe_before' => $timeframe_before, 
      'timeframe_after' => $timeframe_after, 
      'num_items' => $num_items, 
    );
  $area1 = elgg_view('ical_viewer/read', array('entity' => $entity, 'full' => true) );
  
  // Setup page
	if (is_plugin_enabled('externalblog')) {
    $area1 = '<div style="padding:5px 20px; margin:0; border:0;">' . $area1 . '</div>';
    $body = externalblog_layout_switch($area1, array('title' => $title));
	} else {
    $body = elgg_view_layout('one_column', elgg_view_title($title) . '<div class="contentWrapper calendar" style="padding:5px 10px;">' . $area1 . '</div>');
	}
		
	// Display page
	echo page_draw(elgg_echo($title),$body);
