<?php
/* Widgets collection */

function widgets_collection_init() {
  
  // @DOC : add_widget_type ($handler, $name, $description, $context="all", $multiple=false, $positions="side,main");
  
  // Profils en ligne
  if (get_plugin_setting('webprofiles', 'widgets_collection') == "yes") 
  add_widget_type('webprofiles',elgg_echo('widgets_collection:webprofiles'),elgg_echo('widgets_collection:webprofiles:description'), 'profile', false);
  
  // @todo : sélecteur simple de contenus, quitte à en faire plusieurs widgets
  // Afficheur de contenus
  if (get_plugin_setting('publications', 'widgets_collection') == "yes") 
  add_widget_type('publications',elgg_echo('widgets_collection:publications'),elgg_echo('widgets_collection:publications:description'), 'all', true);
  
  // Contacts
  if (get_plugin_setting('friends', 'widgets_collection') == "yes") 
  add_widget_type('friends',elgg_echo("widgets_collection:friends"),elgg_echo('widgets_collection:friends:description'), 'all', false);
  
  // Contacts
  if (get_plugin_setting('anytext', 'widgets_collection') == "yes") 
  add_widget_type('anytext', elgg_echo('widgets_collection:anytext'), elgg_echo('widgets_collection:anytext:description'), 'all', true);
  
  // Iframe
  if (get_plugin_setting('iframe', 'widgets_collection') == "yes") 
  add_widget_type('iframe', elgg_echo('widgets_collection:iframe'), elgg_echo('widgets_collection:iframe:description'), 'all', true);
  
  
  // Test widgets.. - needs final surfacing & integration
  
  // Agenda multisite ~ pas besoin de l'enregistrer si remplace event_calendar
  add_widget_type('calendar', elgg_echo('widgets_collection:calendar'), elgg_echo('widgets_collection:calendar:description'), 'dashboard', true);

  // groupnews, version filtrable par groupe
  add_widget_type('groupnews', elgg_echo('widgets_collection:groupnews'), elgg_echo('widgets_collection:mynews:description'), 'dashboard', true);

  // Widget d'aide : visite guidée et infos utiles..
  add_widget_type('help', elgg_echo('widgets_collection:help'), elgg_echo('widgets_collection:help:description'), 'dashboard', true);
  
  
  // @todo : implement valid widgets
  
  // mynews, version filtrable par site
  add_widget_type('mynews', elgg_echo('widgets_collection:mynews'), elgg_echo('widgets_collection:mynews:description'), 'dashboard', true);
  // derniers micro-messages
  add_widget_type('recentwires', elgg_echo('widgets_collection:recentwires'), elgg_echo('widgets_collection:recentwires:description'), 'dashboard', true);
  // Messagerie : choix messages non lus, inbox, envoyés...
  add_widget_type('messagebox', elgg_echo('widgets_collection:messagebox'), elgg_echo('widgets_collection:alerts:messagebox'), 'dashboard', true);
  // Alertes : param = choix contacts, groupes, messages
  add_widget_type('alerts', elgg_echo('widgets_collection:alerts'), elgg_echo('widgets_collection:alerts:description'), 'dashboard', true);
  
  
}


// Initialise log browser
register_elgg_event_handler('init','system','widgets_collection_init');

