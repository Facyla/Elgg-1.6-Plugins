<?php
$french = array(
  
  'pin:title'  =>  "Contenus mis en avant ou sélectionnés",
  
  // Settings
  'pin:settings'  =>  "Les fonctionnalités de ce plugin sont désactivées par défaut : veuillez choisir celles que vous souhaitez activer ci-dessous.",
  'pin:settings:extendfullonly'  =>  "Intégrer seulement dans la vue complète (défaut : oui)",
  'pin:settings:extendfullonly:help'  =>  "Ce réglage permet de choisir s'il faut intégrer les icônes correspondant aux fonctionnalités du plugin seulement en mode 'fullview' (oui => vue complète d'un contenu), ou également dans la vue 'réduite' (non => tous types des vues).<br />Note 1 : certains types de contenus sont toujours affichés en mode 'full', y compris lorsqu'ils sont dans un listing..<br />Note 2 : Ce réglage ne concerne pas le compteur de vues, qui fonctionne exclusivement en mode 'fullview'.",
  'pin:settings:highlight'  =>  "Activer les contenus mis en avant (défaut : non => désactivé)",
  'pin:settings:validhighlight'  =>  "Filtre des types d'entités concernées (liste de noms d'objets séparés par des virgules, ou vide = pas de filtre). Ex. de liste valide : ",
  'pin:settings:memorize'  =>  "Activer les contenus mémorisés (défaut : non => désactivé)",
  'pin:settings:validmemorize'  =>  "Filtre des types d'entités concernées (liste de noms d'objets séparés par des virgules, ou vide = pas de filtre). Ex. de liste valide : ",
  'pin:settings:footprint'  =>  "Activer le compteur de vues (défaut : non => désactivé)",
  'pin:settings:validfootprint'  =>  "Filtre des types d'entités concernées (liste de noms d'objets séparés par des virgules, ou vide = pas de filtre). Ex. de liste valide : ",
  'pin:settings:position'  =>  "Placer ces fonctionnalités après le contenu ? (défaut : non = au-dessus du contenu)",
  
  // Highlight
  'pin:highlighted:title'  =>  "Contenus épinglés (par un modérateur/admin)",
  'pin:highlighted'  =>  "Contenu épinglé par un modérateur/admin",
  'pin:highlight:true'  =>  "Epingler cette page",
  'pin:highlight:false'  =>  "Dé-épingler cette page",
  'pin:highlighted:true'  =>  "cette page a bien été épinglée",
  'pin:highlighted:false'  =>  "cette page n'est plus épinglée",
  
  // Memorize
  'pin:memorized:title'  =>  "Contenus mémorisés",
  'pin:memorized'  =>  "Contenu mémorisé",
  'pin:memorize:true'  =>  "Se souvenir de cette page",
  'pin:memorize:false'  =>  "Oublier cette page",
  'pin:memorized:true'  =>  "Cette page a bien été mémorisée dans votre liste.",
  'pin:memorized:false'  =>  "Cette page a bien été retirée de votre liste.",
  'pin:error:memorized'  =>  "Une erreur est survenue et cette page n'a pas pu être mémorisée.",
  'pin:error:unmemorized'  =>  "Une erreur est survenue et cette page n'a pas pu être retirée de votre liste.",
  
  // Remember (footprint + hits counter)
  'pin:footprint:title'  =>  "Compteurs de lectures et de vues publiques",
  'pin:footprint:neverread'  =>  "Personne n'a encore lu cette page",
  'pin:footprint:unread'  =>  "Vous n'avez pas lu cette page",
  'pin:footprint:first'  =>  "Vous êtes le premier lecteur de cette page !",
  'pin:footprint:new'  =>  "Première lecture de cette page",
  'pin:footprint:viewed'  =>  "Première lecture %s",
  'pin:footprint:readers'  =>  "Page lue par %s membre(s)",
  'pin:footprint:pubreaders'  =>  " et %s affichage(s) public(s)",
  'pin:footprint:entstats'  =>  "Lu par %s membres, %s vue(s) publique(s)",
  'pin:footprint:youread'  =>  ", votre première lecture a eu lieu %s",
  'pin:footprint:userhistory'  =>  "Première lecture %3\$s, lu par %s membre(s), %s vue(s) publique(s)",
  
);

add_translation('fr', $french);

