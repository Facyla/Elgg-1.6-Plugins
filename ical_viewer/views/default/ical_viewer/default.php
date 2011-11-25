<?php
  /**
  * Elgg iCal plugin
  * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
  * @author Florian Daniel
  * @copyright Facyla 2010
  * @link http://id.facyla.net/
  */
  if (isset($vars['entity'])) {
    $title = $vars['entity']->name;
    if (get_context() == "search") {
      //display the correct layout depending on gallery or list view
      if (get_input('search_viewtype') == "gallery") {
        //display the gallery view
        echo elgg_view("ical_viewer/gallery",$vars);
      } else {
        echo elgg_view("ical_viewer/listing",$vars);
      }
    } else {
        echo elgg_view("ical_viewer/listing",$vars);
    }
  }
?>