<?php
$french = array(
  
  // Wrappers for content (other than generic elements separator - see css.php view)
  'breadcrumbtrail:root' => "Accueil",
  'breadcrumbtrail:site' => "%s",
  
  'breadcrumbtrail:container' => "%s",
  
  'breadcrumbtrail:subtype' => "%s",
  
  'breadcrumbtrail:content' => "%s",
  
  'breadcrumbtrail:action' => "%s",
  'breadcrumbtrail:action:edit' => "édition",
  
  // Settings
  'breadcrumbtrail:settings:description' => "Gestion des couleurs du Fil d'Ariane, pour remplacer les couleurs par défaut.
    <ul>
      <li>Le premier élément définit les styles du bloc qui contient le fil : on peut y définir notamment les couleurs et styles du texte, sous la forme de propriété CSS complètes (ex.: font: normal 11px Georgia,'DejaVu Serif',Norasi,serif; color:#666; )  (généralement soit identique au background, soit transparent, soit couleur de séparation)</li>
      <li>Les éléments suivants ne portent que sur les couleurs des éléments : couleur du fond, des cartouches par défaut et au survol, de l'inter-cartouche.</li>
    </ul>",
  'breadcrumbtrail:settings:mainstyle' => "Style du texte",
  'breadcrumbtrail:settings:background' => "Couleur du fond (transparent ou identique à celui de la page)",
  'breadcrumbtrail:settings:arrow' => "Couleur des cartouches",
  'breadcrumbtrail:settings:arrowhover' => "Couleur des cartouches au survol",
  'breadcrumbtrail:settings:separator' => "Couleur entre les flèches",
  
  // Subtypes that did not have a proper name
  'event_calendar' => "Agenda",
  
  
);

add_translation('fr', $french);

