<?php
  require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/vendors/iCalcreator.class.php');  // iCal class library
  
  if ($entity = $vars['entity']) {
    // Paramètres passés à cette vue
    $title = $entity['title'];
    $calendar = $entity['url'];
    $timeframe_before = $entity['timeframe_before'];
    $timeframe_after = $entity['timeframe_after'];
    $num_items = $entity['num_items'];
  }
  $full = $vars['full'];

  /* Paramètres par défaut du plugin */
  if (!isset($title)) { $title = "Agenda"; }
  if (!isset($calendar)) { $calendar = 'http://www.google.com/calendar/ical/e_2_en%23weeknum%40group.v.calendar.google.com/public/basic.ics'; }
  if (!isset($timeframe_before)) { $timeframe_before = 7; }
  if (!isset($timeframe_after)) { $timeframe_after = 366; }
  if (!isset($num_items)) { $num_items = 3; }
  $title = '<p><a href="' . $calendar . '" class="ical" title="Télécharger le fichier ical"><img src="' . $CONFIG->url. 'mod/ical_viewer/graphics/ical16green.png" alt="ical" style="border:0; padding:0: margin:3px 0 3px 3px; background:transparent;">ICAL</a></p>';
  
  // Gestion du décalage horaire en fonction de la timezone définie : O donne le décalage de timezone en heures, Z en secondes..
  // On ne garde que la partie qui nous intéresse, sans le +
//  $offset = (int) substr(date("O",time()), 1, 2);
  
  // Intervalle de temps concerné pour affichage
  $startyear = date('Y', time()-$timeframe_before*24*3600);
  $startmonth = date('n', time()-$timeframe_before*24*3600);
  $startday = date('j', time()-$timeframe_before*24*3600);
  $endyear = date('Y', time()+$timeframe_after*24*3600);
  $endmonth = date('n', time()+$timeframe_after*24*3600);
  $endday = date('j', time()+$timeframe_after*24*3600);
  $event_type = "vevent";

  $vcalendar = new vcalendar();  // create a new calendar instance
  $vcalendar->setConfig( 'unique_id', $SERVER['SERVER_NAME']);  // Unique id, based on site domain (required if any component UID is missing)
  $vcalendar->setConfig( 'url', $calendar );  // Remote input file
  $vcalendar->setConfig( 'language', 'fr' );  // Remote input file
  $vcalendar->setProperty( "X-WR-TIMEZONE", "Europe/Paris" );
  date_default_timezone_set('Europe/Paris');
  
/*
  $vcalendar->setProperty( 'method', 'PUBLISH' );
  $vcalendar->setProperty( "x-wr-calname", "Evénements" );
  $vcalendar->setProperty( "X-WR-CALDESC", $title);
*/
  $vcalendar->parse();
  $vcalendar->sort();  // Ensure start date order

  // Select events
  $events_arr = $vcalendar->selectComponents($startyear,$startmonth,$startday,$endyear,$endmonth,$endday,$event_type);
  
  $eventcount = 0;
  $undouble_events = array();
  
  $area1 = "";
  if ($full) { $area1 .= $title; }
  
  // Generate content
  foreach( $events_arr as $year => $year_arr ) {
    foreach( $year_arr as $month => $month_arr ) {
      foreach( $month_arr as $day => $day_arr ) {
        foreach( $day_arr as $event ) {
          $start = null; $end = null; $startdate = null; $enddate = null;
          $event_string = null;
          $startdate = $event->getProperty('dtstart');
          $enddate = $event->getProperty('dtend');
          
          // Gestion du décalage horaire en fonction de la timezone définie : O donne le décalage de timezone en heures, Z en secondes..
          // "Z" = date notée en GMT = pas de décalage dans l'heure donc application du offset (sinon offset = 0)
          if ($startdate['tz'] != "Z") { $offset  = 0; } else { $offset = (int) substr(date("O",time()), 1, 2); }
          
          /* Filtrage possible mais pas utilisé car impacterait d'autres vues, + parseur variable selon les fichiers ('\n') + à implémenter dans une autre vue "déployée", et dans la configuration
          $categories = explode('\n', $event->getProperty('categories'));
          $categories = $categories[0];
          if ($categories != "Correspondants") break;
          */
          // Vue complète (attention, vue par défaut utilisée pour listing)
          if ($full) {
            $description = $event->getProperty('description');
            $description = str_replace(array("\r ", "\r"), '', $description); // Nécessaire pour pouvoir parser correctement le contenu (CR + un espace)
            $search_a = array(
              '\n ', '\n', 
              '\r\n', '\n\n', 
              '\r ', '\r', 
              '"', "DQUOTE");
            $replace_a = array(
              "", " <br>", 
              " <br>", " <br>", 
              "", " <br>", 
              "", "\"");
            $description = '<br />' . str_replace($search_a, $replace_a, $description);
            // Location
            $location = $event->getProperty('location');
            $url = $event->getProperty('url');
            if (!empty($url)) $url = 'Lien : <a href="' . $url . '">' . $url . '</a><br />';
            $location = str_replace(array("\r ", "\r"), '', $location); // Nécessaire pour pouvoir parser correctement le contenu (CR + un espace)
            $location = '<br /><em><span class="location">' . $location . '</span></em><br />';
            // Title wrappers
            $wrap1 = '<h3 style="display:inline;">';
            $wrap2 = '</h3>';
            $separator = "<br />";
          }
          $summary = $event->getProperty('summary');
          $summary = str_replace(array("\r ", "\r"), '', $summary); // Nécessaire pour pouvoir parser correctement le contenu (CR + un espace)
          $summary = str_replace('DQUOTE', '"', $summary);
          $month = $startdate['month'];
          $endmonth = $enddate['month'];
          $num_months = array('/01/', '/02/', '/03/', '/04/', '/05/', '/06/', '/07/', '/08/', '/09/', '/10/', '/11/', '/12/');
          $fr_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
          $month = preg_replace($num_months, $fr_months, $month);
          $endmonth = preg_replace($num_months, $fr_months, $endmonth);
          // Parse links
          $summary = makeLinksFromText($summary);
          $description = makeLinksFromText($description);
          // Affichage clean des dates et heures : on affiche certaines infos minimales, en évitant de doublonner si possible
          // On affiche l'année SSI elle diffère
          if ($enddate["year"] != $startdate["year"]) {
            $start = ' ' . $startdate["year"];
            $end = ' ' . $enddate["year"];
            $addmonth = true;
          }
          // On affiche le mois, et le mois de fin SSI il diffère
          $start = ' ' . $month . $start;
          if ($addmonth || ($endmonth != $month)) {
            $end = ' ' . $endmonth . $end;
            $addday = true;
          }
          // On affiche le jour, et le jour de fin SSI il diffère
          $start = $startdate["day"] . $start;
          if ($addday || ($enddate["day"] != $startdate["day"])) {
            $end = $enddate["day"] . $end;
            $addhour = true;
          }
          // On affiche l'heure, et l'heure de fin SSI elle diffère
//          $start = $start . ', ' . $startdate["hour"] . "h{$startdate["min"]}";
          $start = $start . ', ' . ($startdate["hour"] + $offset) . "h{$startdate["min"]}";
          if ($addhour) { $end = $end . ', '; }
          if ($enddate["hour"] != $startdate["hour"]) {
            $end = $end . ($enddate["hour"] + $offset) . "h{$enddate["min"]}";
          }
          if (!empty($end)) $end = ' - ' . $end;
          $event_string = '<div class="vevent">' 
            . '<span class="dtstart" style="display:none;">' . "{$startdate["year"]}-{$startdate["month"]}-{$startdate["day"]}T" . ($startdate["hour"] + $offset) . ":{$startdate["min"]}:{$startdate["sec"]}" . '</span>' 
            . '<span class="dtend" style="display:none;">' . "{$enddate["year"]}-{$enddate["month"]}-{$enddate["day"]}T" . ($enddate["hour"] + $offset) . ":{$enddate["min"]}:{$enddate["sec"]}" . '</span>' 
            . $wrap1 . $start . $end . ' : ' . $wrap2 
//            . '<span class="summary">' . $wrap1 . $summary . $wrap2 . "</span>\n" 
            . '<span class="summary">' . $wrap1 . $summary . $wrap2 . "</span>\n" 
            . $location 
            . $url
            . '<span class="description">' . $description . '</span>' 
            . "</div>\n";
          
          if (!in_array($event_string, $undouble_events)) { $area1 .= $event_string . $separator; }
          $undouble_events[] = $event_string; // Dédoublonnage
          $eventcount++;
          if ($eventcount >= $num_items) break;
        }
        if ($eventcount >= $num_items) break;
      }
      if ($eventcount >= $num_items) break;
    }
    if ($eventcount >= $num_items) break;
  }

  // Displays the content
  echo $area1;
