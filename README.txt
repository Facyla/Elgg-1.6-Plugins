PLUGINS LIST :


################################################################################################
BREADCRUMBTRAIL
- Fil d'Ariane / Breadcrumb trail
- http://community.elgg.org/pg/plugins/project/690106/developer/Facyla/breadcrumbtrail-fil-dariane

Ajoute un fil d'Ariane sous la barre de menu, avant le contenu de la page.

Permet de se repérer dans le site, en indiquant le chemin à suivre, depuis l'accueil, pour retrouver la page sur laquelle on est.

Ex. sur FormaVia : FormaVia > Outils et dispositifs > Wiki

Note : le rendu est fortement dépendant du thème, à styler en fonction.

---------

Adds a breadcrumb trail right under the top menu, telling users where they are (or how to get there back).

Current position into the site is based on page_owner (user or group) and context (blog, pages, etc.), and links are clickable.

You may need to adapt the CSS to get it fit right into your theme.

################################################################################################
CMSPAGES
- Static page, and reusable views editor (CMS tool for Elgg)
- http://community.elgg.org/pg/plugins/project/690138/developer/Facyla/cms-pages-editeur-de-pages-statiques

This plugin was developped after using modified versions of external pages, which didn't fit our needs for various reasons (number of pages, access rights, new subtypes for each new page.

Cmspages lets admins (and local admins when used in a multisite context) define static pages that are meant to be integrated into the web interface.

It uses 1 object subtype (instead of one per page), and lets admin define an unlimited number of static pages (just like any other object). Pages title and URL can be defined separately, and unfiltered HTML may be used (depending on your local configuration and plugins). It also adds basic access rights (no collection, neither groups' nor users'). It doesn't trigger any river or notification message (as it's meant to be used as an interface editor).

 

Further developpements (which are not planned yet) could include cmspages siblings and parents relations, which are already implemented in the cmspage object (not used).

The original idea was that the generated views could be used as interface blocks, and this plugins could be used to create admin-editable interfaces, when used in conjunction with a layout-plugin.

 

README.txt file content :

What are Static pages ?- have a specific URL (ex. mainpage)- are editable by any admin user (localadmin also in multisite context)- can then be linked from site menu..- don't trigger any notification- changes take effect immediately, but there's no history : care not to empty field before saving (empty fields are allowed)- access level can be set for each pageInstructionsHow to create a new page :- click on page title ("new page") or click "+" if you're already on a existing page- type page URL name (can't be changed)- press Enter (non-Javascript : click button)- edit form, then click the Create page buttonImportant notice : URL page name only accepts <strong>alphanum chars, and no space nor other signs except : "-", "_" and ".". Other characters will not be taken into accountHow to edit an existing page :- select a page through the dropdown- edit it, then saveCMS Pages use 2 views, so that their content can be embedded into a theme and make it customizable  - cmspages/read is used for fullview cmpages rendering, and may render more content (title, etc.)  - cmspages/view view should return only cmspage description (other elements should be hidden), and is designed for inclusion into other viewsHow to insert a CMS Page into interface ?- add following code where you want to insert the page content : elgg_view('cmspages/view', array('pagetype' => $pagetype));- replace $pagetype by the the unique string that is at the end of a CMS Page view URL : pg/cmspages/read/[PAGETYPE]

This plugin was funded by Fing's Citélabo program : http://fing.org/

--------

Ce plugin est un éditeur de pages statiques, utilisables directement ou sous la forme de blocs (vues) intégrables dans l'interface du site.

Il vise à remplacer externalpages, trop limité en termes de nombre de pages, et qui souffre de défauts de conception, notamment parce qu'il créé un sous-type d'objet pour chaque nouvelle page créée, et porte un titre identique à la terminaison de son URL...

Les "Pages CMS" permettent de générer des pages dans le site et de les éditer en html, avec un éditeur de texte à disposition, sans syntaxe particulière, avec un code non filtré (sauf si l’éditeur le filtre, mais celui-ci est désactivable, ou qu'un autre plugin activé filtre le code) et n’engendre pas de notification du tout à la création des pages. Les pages créées intègrent des droits d'accès volontairement limités aux droits par défaut.

Ce plugin a été réalisé à l'initiative du programme Citélabo de la Fing's : http://fing.org/

################################################################################################
CONTENT_MAPPER

Plugin "quick and dirty" développé pour transformer certains types de contenus "exotiques" en contenus plus standards. Utilisé sur Elgg.fr pour trasnformer les "ads" en articles de blog.
Non-développeur s'abstenir : l'utilisation de ce plugin nécessite de travailler autant côté code que via le site..


################################################################################################
EMBED

Une version modifiée à partir de l'embed standard, mais qui permet de charger tous types de contenus : objets, users, groups.
Plugin configurable et sélection des contenus embarquables.
Intègre également un "modalpicker", version du friendpicker permettant de sélectionner tous types d'entités (et non seulement des ElggUser).


################################################################################################
EXTERNALBLOG
- Easy set up external blogs/sites displaying selected content in a customizable layout.
- http://community.elgg.org/pg/plugins/project/690180/developer/Facyla/external-blogs-for-multisite-elgg-blogssites-externes

Les blogs (ou sites) externes visent à créer des sites externes, alimentés par des contenus provenant d'un ou plusieurs sites existant, en environnement multisite.

Ce plugin a été développé et testé pour Elgg 1.6.x, et nécessite l'utilisation du plugin multisite (il n'a guère de sens en contexte mono-site, sauf peut-être pour gérer une page d'accueil - si vous l'utilisez ainsi, vos retours m'intéressent !).

Il est à destination des admins et admins locaux exclusivement, et vise à fournir une interface de consultation externe de contenus produits au sein du (des) réseaux de l'installation multisite.

Il permet ainsi d'afficher dans un site spécifique, utilisé exclusivement à cet effet, des contenus provenant d'autres sites, filtrés selon plusieurs critères : site, groupe, auteur, tag, et de les lister dans une interface configurable directement en backoffice via une sélection de layouts et une série de blocs configurables acceptant du HTML non filtré (si utilisé sans éditeur et que les plugins activés le permettent).

 

Plugin développé pour le programme Citélabo de la Fing http://fing.org/ (sur une base existante)

-----------------

This plugin is meant to be used in multisite-context mainly (other usages are not tested, but feedback is very welcomed to keep this plugin as generic as possible in upcoming versions - if any).

It provides an admin-configurable interface to set up a public site (or blog, depending on to which extent it's used).

The external blog is not meant to have members, but only one or few admins who can configure the plugin : mainly select content, and display it in a configurable interface, that do not rely much on Elgg own CSS.

The chosen layout are configurable with (or without) a text editor, and accept raw HTML if the site plugins' allow it (note : filtering can be disabled on this site -multisite- as it doesn't have any other user, if you trust your admins of course^^).

Block configuration include top menu, footer, and various blocks depending on the chosen layout.

This plugin was developped and is used together with a few other plugins :

    CMS Pages : used to set up pages (that are used and linked from the configurable menu)
    iCal viewer : an iCal.. viewer (from file or feed)
    a modified Simplepie (not released yet, but should very soon) that lets admins configure a main incoming RSS feed (provides a RSS view that developpers can configure and include anywhere)

Note : test carrefully before using on a production site !!

Not e: The plugin was designed to display only blog posts from a selectable group at first, but was modified to let admins choose any source, depending on various filters (site, groupe, type of content, owner, tag...) : the result may vary and should probably be adapted for other content subtypes.

 
This plugin was funded by Citélabo Fing program, after an personal proof-of-concept.

################################################################################################
FOLDER

Modified version of txtan's "folder" plugin : configurable object types can be added to folders (not only files).


################################################################################################
GROUP_MIGRATION
- Migrates contents and/or members from one group to another (also from a site to another in a multisite context)
- http://community.elgg.org/pg/plugins/project/501038/developer/Facyla/group-migration-tool

Migrates group content and/or members from one group to another.

Install as usual : copy to mod/, activate.

Use of this plugin is restricted to admins and local admins (compatible with fcol multisite plugin) :

    view a full listing of groups via admin menu
    check content and/or members from the "departure" group
    choose target group
    Submit form : results appear before the groups list.

Notes :

    only one group at a time (1 form per group)
    all objects in the group that have a container_id will be transfered (ie. not if they are are linked to the group by another way - the old blogs from Elgg 1.5 blogextended mod won't move..)
    membres are joined to the target group, but they stil remain in the original group (and no notification rule is set)

 

Français :

Migration des contenus et/ou membres d'un groupe vers un autre groupe.

 Installation comme d'habitude : copier le dossier group_migration/ dans mod/ puis activer le plugin

Utilisation réservée aux admins et admins locaux (en mode multisite) :

    accéder au listing des groupes via le menu d'administration
    cocher les contenus et/ou les membres d'un groupe à transférer
    valider : les résultats apparaissent avant la liste.

Notes :

    on ne peut déplacer qu'un groupe à la fois (1 formulaire par groupe)
    les contenus sont changés de groupe (changement de contaimer_guid)
    les membres sont inscrits dans le nouveaux groupe, mais pas retirés de l'ancien


################################################################################################
ICAL_VIEWER
- http://community.elgg.org/pg/plugins/project/501028/developer/Facyla/ical-viewer

This plugin basically provides an ical calendar object that may be configured or used in other views or plugins. An admin configurable default view may also be used out-of-the-box.It integrates a small tool that make URL clickable (including email, ftp, or www.domain.tld addresses -without prefix)

    a configurable ical_viewer object that may be instanciated and uses wherever one want to ;
    an "instanciated" view is provided (index.php) with a demo calendar ; edit the file to configure ;
    ical_viewer.php script may be used to display calendars into "one_column" layout with a few modifications ;
    may use distant or local icla files - see readme.txt for examples.

 

Install & use :

    Copy into mod/ directory
    Activate the plugin
    Configure :
        default calendar URL
        events display timeframe : days before current date (default : 7), and days after (default : 366)
        number of events to display (default : 3)
    Integration and usage :
        default calendar page is at /mod/ical_viewer/index.php (no menu entry)
        default view is called by : elgg_view('ical_viewer/read', array('entity' => $entity, 'full'=>true) )
        you may use various input files and calendars by passing a new $entity with the following values :

          $entity = array(        'url' => "$url",         'title' => "$title",         'timeframe_before' => $timeframe_before, // Optional (default : 7 days)        'timeframe_after' => $timeframe_after,  // Optional (default : 366 days)        'num_items' => $num_items,  // Optional (default : 3 events)        );

See readme.txt file for code examples and local file input instead of distant URL.

 

Crédits :

    Devleopment supported by Innovations Democratic program.
    This plugin integrates iCalcreator class v2.6 library - copyright (c) 2007-2008 Kjell-Inge Gustafsson kigkonsult, www.kigkonsult.se/iCalcreator/index.php - ical@kigkonsult.se

 

Français

Ce plugin vise essentiellement à fournir un objet calendrier ical utilisable dans d'autres vues.Les URL spécifiées dans le fichier .ics source sont parsées et affichées sous forme de liens (y compris contacts mail, ftp, adresses non préfixées, etc.)

    un objet ical_viewer configurable peut être instancié et utilisé où bon vous semble ;
    une vue "instanciée" index.php est fournie avec un calendrier de démo, à titre d'exemple ;
    le fichier ical_viewer.php peut être utilisé pour afficher des calendriers en pleine page, avec quelques adaptations mineures.

 

Installation et utilisation :

    Copier le plugin dans mod/
    Activer le plugin
    Le configurer :
        URL du calendrier par défaut
        fenêtre de validité des événements par défaut (nombre de jours antérieurs et postérieurs à la date actuelle)
        nombre d'événements à afficher
    Intégrer et utiliser :
        le calendrier par défaut est accessible via la page /mod/ical_viewer/index.php
        la vue par défaut est appelée via : elgg_view('ical_viewer/read', array('entity' => $entity, 'full'=>true) )
        Pour l'utiliser, il faut instancier un objet $entity avec les valeurs suivantes :

          $entity = array(        'url' => "$url",         'title' => "$title",         'timeframe_before' => $timeframe_before, // Facultatif (7 jours par défaut)        'timeframe_after' => $timeframe_after,  // Facultatif (366 jours par défaut)        'num_items' => $num_items,  // Facultatif (3 événements par défaut)        );

Voir le fichier readme.txt pour des exemples de code.

 

Crédits :

    Développement financé par le programme Innovations Democratic.
    Ce plugin utilise la librairie iCalcreator class v2.6 - copyright (c) 2007-2008 Kjell-Inge Gustafsson kigkonsult, www.kigkonsult.se/iCalcreator/index.php - ical@kigkonsult.se


################################################################################################
MAILING
- HTML mailing tool : newsletter and mailing for members and non-members
- http://community.elgg.org/pg/plugins/project/739971/developer/Facyla/mailing-envoi-de-newsletter-html

Multisite-ready.

This tool lets admin send mailing and newsletters to a csv list of emails (comma, space or break separated list).

Emails pre-selections : site membres, multisite members, self and site's addresses, plus admin-set additional email.

Admin can also set a mailing template and choose whether local admins can access this tool or not (multisite-only feature).

Tips are detailled while using the plugin.

################################################################################################
NOTIFICATION_MESSAGES
- http://community.elgg.org/pg/plugins/project/501059/developer/Facyla/notification-messages

Description : This plugin intercepts notification messages and remplace them with more meaningful messages : title and message cotnent replacement.

Example : "You have a new message" becomes  "User_test has created page "Notifications" (in "Plugins" group)"

Contributeurs : Fabrice pour l'utilisation du hook

Ce plugin est encore dans sa première phase de développement ; à peu près fonctionnel, mais avec des modifications fonctionnelles et des optimisations prévues.

Si vous êtes intéressé pour y contribuer, n'hésitez pas à faire part de vos remarques, suggestions ou demandes, et à proposer des améliorations. Au besoin, nous pourrons mettre en place un espace spécifique pour cela (il existe déjà un espace google code pour la communauté francophone).

 

Installation :

Put into mod and enable in the admin panel. Place as the bottom of the list, as it overrides several plugins behaviours.

How to confirm the plugin is working ? Check the header of an email that was sent after the plugin was enabled. Title and message content should change from the default.

Handled object types : blog, bookmarks, event_calendar, file, groupforumtopic, izap_videos, multipublisher_comment, page, page_top, thewire (modify start.php arrays to add or remove object types)

Compatibility issues :

    fcol's multisite plugin compatible
    no known conflict ; only tested "low in the admin  panel"

Known bugs :

    messages are not diffeenciated between creation, update or annotation (TODO but no known release date - don't hesitate to involve into the project !) ;
    not all edition are notified : create events are, some comments too, but no update - this may to be configured directly into start.php file, but has not been extensively tested are adjusted.

 

Français :

Description : Le principe de ce plugin est de récupérer les notifications standard d'Elgg, pour les remplacer par des messages plus explicites : remplacement du sujet du message, et du contenu.

Contributeurs : Fabrice pour l'utilisation du hook

Ce plugin est encore dans sa première phase de développement ; à peu près fonctionnel, mais avec des modifications fonctionnelles et des optimisations prévues.

Si vous êtes intéressé pour y contribuer, n'hésitez pas à faire part de vos remarques, suggestions ou demandes, et à proposer des améliorations sur le site de la communauté Elgg francophone. Au besoin, nous pourrons mettre en place un espace spécifique pour cela (il existe déjà un espace google code pour la communauté francophone).

 

Installation : comme d'hab', le dossier du plugin dans le répertoire mod/, on active dans l'administration.

Compatibilité avec d'autres plugins :

    compatible multisite (fonctionne aussi en standard)
    pas de conflit de plugins constaté pour le moment, mais testé principalement assez "bas" dans la liste des plugins

Types de contenus pris en charge : blog, bookmarks, event_calendar, file, groupforumtopic, izap_videos, multipublisher_comment, page, page_top, thewire

Bugs connus :

    les messages ne sont pas différenciés selon qu'il s'agisse d'une mise à jour, d'un commmentaire ou de la création d'un nouveau contenu ;
    les créations de contenus sont notifiées, pas les mises à jour (trop de messages), et seulement certains contenus pour les commentaires - mais ce point n'a pas été testé de manière exhaustive


################################################################################################
PIN
- Pin : highlight objects (admin), memorize objects (users), remember first views per user and count public hits


################################################################################################
PROTOVIS
- Protovis (javascript library for data visualization)
- this plugin is intended for developpers to render graphically various data
- http://community.elgg.org/pg/plugins/project/739998/developer/Facyla/protovis-integration-js-data-visualization-framework

This plugin is mainly an integration of Stanford JS visualization library : http://vis.stanford.edu/protovis/docs/

It also features a few tests of network (global and user-centric), and resume visualization.

It was developped and tested on Elgg 1.6 only, and is released as an existing facility for developpers and other plugins, and particularly for the CV visualization feature of "resume" plugin.

################################################################################################
RESUME
- Resume - structured Europass CV tool + visualization
- http://community.elgg.org/pg/plugins/project/740021/developer/Facyla/resume-eportfolio-editor

This plugin was inspired and based on Pablo Borbon "Resume aka ePortfolio" plugin : http://community.elgg.org/pg/plugins/project/527419/developer/pablob86/resume-aka-eportfolio

This version was adapted for Elgg 1.6.1, based on FormaVia needs.

It was strongly adapted to fit FormaVia's needs :

    Modified data structure to meet Europass standards (Europass-compatible structure for most fields, except address)
    XML EUropass export
    Printable version
    Resume graphical visualization (requires "protovis" plugin, or "protovis" library integration, see my other plugins)
    Experience types : work, academic, other (not formal), languages, skills & C2i2e skills (2 latest are still in development)
    Admin settings : select functionnalities and experience types
    Major views changes for listings, search
    new "importance" (subjective rating) fileds for life, work and academic experiences

Please note that this plugin is still in (slow) development, and that some bugs may apppear (known bug : wrong user status on printable version, skill integration not done in Europass CV, and skill views not very clean yet..). Further versions may be released based on constructive feedback and suggestions. Thanks !

The "chronogram" visualization was inspired by "Le Jardin des Savoirs" work from "Asso BUG" in Rennes, France.

################################################################################################
SIMPLEPIE
- New version of simplepie, with plugin settings, feed object, and reusable views for developpers
- http://community.elgg.org/pg/plugins/project/690572/developer/Facyla/simplepie-reloaded-feed-objects-views

This plugin is based on Cash's SimplePie RSS Feed Integrator

This plugin is made for Elgg 1.6 (Elgg 1.7 and further versions not tested nor supported)

Modifications by @facyla and @sophiemaheo

Changes :

    better rendering of images and rich content
    new settings : activate [ widget ]  [ feed objects ], and set RSS main page default settings
    (if activated) adds a new page with an admin-configurable RSS feed
    (if activated) adds a new feed object, that group owner can activate

The feed objects rendering may be buggy depending on site configuration and feed url.. feedback is welcome !

 

Nouvelle version du plugin Simplepie :

    meilleure intégration des images et contenus riches dans les flux RSS
    ajout d'un nouveau type d'objet pour les groupes : "feed" (flux)
    nouvelles options de configuration :
        activation ou non des widgets RSS (seule fonctionnalité originelle du plugin "simplepie")
        activation des "objets" "feed": ils peuvent être activés pour chaque group. Par défaut : désactivé.
        une série de champs pour la configuration d'une page RSS "par défaut" pour le site

Le rendu des "objets" RSS bugge parfois (le flux ne s'affiche pas dans certains cas), tout feedback sur l'identification de ces bugs est bienvenu !

################################################################################################
SUBSCRIBE
- Inline subscription to sites, groups and members, default group notification by email, and widgets (following and followers)


################################################################################################
WIDGETS_COLLECTION
- Collection de widgets

################################################################################################


