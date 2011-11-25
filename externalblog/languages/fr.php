<?php

$french = array(
  'externalblog:showhidecomments' => "Afficher/masquer les commentaires",
  
  /* Réglages */
  'externalblog:nosettings' => "Plugin 'externalblog' non configuré",
  'externalblog:configuration' => "Configuration Blog externe",
  'externalblog:settings:description' => "Paramètres",
  'externalblog:settings:title' => "Titre du blog",
  'externalblog:settings:title:help' => "Si vous souhaitez utiliser un autre titre que le nom du groupe (valeur par défaut), vous pouvez le définir ici",
  
  // Content selectors
  'externalblog:settings:contentselect' => "Choix des contenus du blog externe",
  'externalblog:settings:contentselect:help' => "Sélectionnez un ou plusieurs de filtres suivants : par communauté, groupe, type de contenu et tag",
  'externalblog:settings:site' => "Communauté : ",
  'externalblog:settings:site:help' => "Vous pouvez choisir une communauté dont vous souhaitez afficher les contenus sous forme de blog (facultatif ; aucune = pas de filtrage par site)",
  'externalblog:settings:nofilter' => "(pas de filtre)",
  'externalblog:settings:group' => "Blog du groupe : ",
  'externalblog:settings:group:help' => "Choisir le groupe dont vous souhaitez afficher le blog (facultatif ; aucun = pas de filtrage par groupe)",
  'externalblog:settings:owner' => "Auteur : ",
  'externalblog:settings:owner:help' => "Choisir l'auteur dont vous souhaitez afficher les publications blog (facultatif ; aucun = pas de filtrage par auteur)",
  'externalblog:settings:subtypes' => "Types de contenus : ",
  'externalblog:settings:subtypes:help' => "Types de contenus à afficher (facultatif ; aucun = pas de filtrage, plusieurs types d'objets possibles, séparés par des virgules, sauf si on filtre sur les tags).",
  'externalblog:settings:filtertag' => "Tag : ",
  'externalblog:settings:filtertag:help' => "Filtrer les contenus sur un tag particulier (1 seul tag facultatif ; aucun = pas de filtrage par tag). Attention : lorsqu'on filtre par tag, il n'est plus possible de trier par date de modification (seulement de création), et on ne peut filtrer que pour un seul type de contenu : n'en configurer qu'un seul, ou aucun (un filtre mal configuré n'est pas pris en compte).",
  'externalblog:settings:orderby' => "Trier par : ",
  'externalblog:settings:orderby:help' => "Dans quel ordre trier les contenus ainsi sélectionnés ? (défaut = date de création)",
  'externalblog:orderby:modifieddesc' => "Dernière modification",
  'externalblog:orderby:modifiedasc' => "Dernière modification (inversé)",
  'externalblog:orderby:createddesc' => "Date de création",
  'externalblog:orderby:createdasc' => "Date de création (inversé)",
  // Interface settings
  'externalblog:settings:mainpage' => "Page d'accueil",
  'externalblog:settings:mainpage:help' => "URL de la page d'accueil (relative, sans le http://nom.de.domaine/). Si vide, pointe par défaut sur le blog.",
  'externalblog:settings:header' => "Header et menu",
  'externalblog:settings:header:help' => "Code HTML de l'entête du site, y compris images, teaser, slideshow, menus, etc.",
  'externalblog:settings:footer' => "Pied de page",
  'externalblog:settings:footer:help' => "Code HTML du pied de page du site",
  'externalblog:settings:css' => "Style CSS",
  'externalblog:settings:css:help' => "Feuille de style en CSS (surcharge la feuille de style par défaut)",
  'externalblog:settings:metatags' => "Metatags complémentaires du header",
  'externalblog:settings:metatags:help' => "Permet de remplacer les balises link pour les flux RSS et ODD (remplace les flux par défaut si non vide)",
  
  // Layout & optional divs
  'externalblog:settings:layout' => "Mise en page",
  'externalblog:settings:layout:help' => "Mise en page : choisir le nombre de blocs utilisés dans la mise en page (en plus du haut et pied de page)",
  'externalblog:settings:layout:one_column' => "Pas de sidebar",
  'externalblog:settings:layout:right_column' => "Sidebar à droite",
  'externalblog:settings:layout:two_column' => "2 blocs",
  'externalblog:settings:layout:three_column' => "3 blocs",
  'externalblog:settings:layout:four_column' => "4 blocs",
  'externalblog:settings:layout:five_column' => "5 blocs",
  'externalblog:settings:layout:help' => "Choix du layout du blog",
  'externalblog:settings:sidebar' => "2e bloc / Sidebar (facultatif)",
  'externalblog:settings:sidebar:help' => "Contenu HTML de la sidebar ; id = externalblog_two",
  'externalblog:settings:divthree' => "3e bloc (facultatif)",
  'externalblog:settings:divthree:help' => "Contenu HTML du bloc configurable n°3 ; id = externalblog_three",
  'externalblog:settings:divfour' => "4e bloc (facultatif)",
  'externalblog:settings:divfour:help' => "Contenu HTML du bloc configurable n°4 ; id = externalblog_four",
  'externalblog:settings:divfive' => "5e bloc (facultatif)",
  'externalblog:settings:divfive:help' => "Contenu HTML du bloc configurable n°5 ; id = externalblog_five",
  
  // Search settings
  'externalblog:settings:searchscope' => "Etendue de la recherche",
  'externalblog:settings:searchscope:help' => "Définit à quels contenus s'étend la recherche : contenus de ce site seulement (locale), tous les contenus accessibles (globale), ou tous les contenus accessibles avec les contenus locaux à part et en premier (étendue).",
  'externalblog:settings:searchscope:localonly' => "Locale (par défaut)",
  'externalblog:settings:searchscope:all' => "Globale",
  'externalblog:settings:searchscope:extend' => "Etendue",
  'externalblog:search:reservedwords' => "Terme de recherche trop large, merci d'essayer une autre recherche.",
  'externalblog:search:noresult' => "Pas de résultat<br />",
  'externalblog:search:extendlink' => "&rarr;&nbsp;Rechercher dans tout le réseau",
  'externalblog:search:localsearch' => "Recherche sur ce site",
  'externalblog:search:globalsearch' => "Recherche globale dans le réseau",
  'externalblog:search:extendlink' => "&rarr;&nbsp;Rechercher dans tout le réseau",
  'externalblog:search:title' => "Recherche : %s",
  'externalblog:search:found' => "Résultat de votre recherche %s:",
  'externalblog:search:too_short' => "Les termes de la recherche sont trop courts (au moins %s caractères)",
  
  // Blog content wrapper
  'externalblog:settings:wrapper:before' => "Wrapper HTML avant le contenu",
  'externalblog:settings:wrapper:before:help' => "Code HTML placé juste après le bloc contenant les articles de blog.",
  'externalblog:settings:separator' => "Séparateur",
  'externalblog:settings:separator:help' => "Code HTML du séparateur entre articles",
  'externalblog:settings:wrapper:after' => "Wrapper HTML après le contenu",
  'externalblog:settings:wrapper:after:help' => "Code HTML placé juste après le bloc contenant les articles de blog.",
  
  
);
        
add_translation("fr",$french);
