<?php
function breadcrumbtrail_init() {
  
  // Ajouts au menu pour utilisateurs enregistrés
  extend_view('css','breadcrumbtrail/css');
  extend_view('page_elements/header_contents','breadcrumbtrail/header_contents');

}


// Initialisation du plugin au démarrage du système
register_elgg_event_handler('init','system','breadcrumbtrail_init');	

