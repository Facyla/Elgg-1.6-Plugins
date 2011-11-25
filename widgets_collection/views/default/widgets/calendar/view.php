<?php
/**
* Elgg multisite event calendar widget
*
* @package event_calendar
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Kevin Jardine <kevin@radagast.biz>
* @copyright Radagast Solutions 2008
* @link http://radagast.biz/
*
*/

if (is_plugin_enabled('event_calendar')) {
  
  // Load event calendar model
  require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/event_calendar/models/model.php");

    //the number of events to display
  $num = (int) $vars['entity']->num_display; if (!$num) $num = 5;
  $numpast = (int) $vars['entity']->numpast_display; if (!$numpast) $numpast = 3;
  
  // Events scope
  $scope = $vars['entity']->scope; if (!$scope) $scope = page_owner();
  
  // Get the events
  if ($scope == page_owner()) {
    $title = 'Agenda personnel';
    // Get future events
    $events = event_calendar_get_personal_events_for_user($scope,$num);
    // Get past events
    $pastevents = get_entities_from_annotations("object", "event_calendar", "personal_event", $scope, $scope, 0, 1000);
    $final_events = array();
    if ($pastevents) {
      $now = time();
      $one_day = 60*60*24;
      // show only events that have been over for more than a day
      foreach($pastevents as $event) {
        if (($event->start_date < $now-$one_day) || ($event->end_date && ($event->end_date < $now-$one_day))) {
          $final_events[] = $event;
        }
      }
      $sorted = event_calendar_vsort($final_events,'start_date');
      $pastevents = array_slice($sorted,0,$numpast);
    }
    
  } else {
    $title = 'Agenda global des sites';
    // Get future events
    $events = event_calendar_get_events_between( mktime(0,0,0,date("m"),date("d"),date("Y")), mktime(0,0,0,date("m"),date("d"),date("Y")+3), false, $num);
    // Get past events
    $pastevents = event_calendar_get_events_between( mktime(0,0,0,date("m"),date("d"),date("Y")-3), mktime(0,0,0,date("m"),date("d"),date("Y")), false, 1000);
    $pastevents = array_slice($pastevents, -$numpast);  // Réduit le nombre d'événements passés affichés à N (le 2e paramètre) : les N plus récents
    $pastevents = array_reverse($pastevents, true); // Les plus récents en premier
  }
  
  
  
  // If there are any events to view, view them
  echo '<div id="widget_calendar">';
    echo '<h3>' . $title . '</h3>';
    if (is_array($events) && sizeof($events) > 0) {
      foreach($events as $event) {
        echo elgg_view("object/event_calendar",array('entity' => $event));
      }
    } else echo '<p>Aucun événement prévu</p>';
    if (is_array($pastevents) && sizeof($pastevents) > 0) {
      echo '<hr />';
      echo '<h4>Evénements passés</h4>';
      foreach($pastevents as $event) {
        echo elgg_view("object/event_calendar",array('entity' => $event));
      }
    }
  echo '</div>';

}
