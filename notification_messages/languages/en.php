<?php
$english = array(

/* ************************************************ */
/* Variables utilisées :
  $content_link : lien vers l'objet
  $owner_name : nom de l'owner du contenu notifié (différencié si c'est an groupe)
  $editor : éditeur de l'objet : auteur du commentaire ou de la modification
  $sender : Auteur du message
  $title : Titre du message
  $sitename : Nom du site
  $site_url : URL du site (racine)

  * Variables pour les titres des notifications : $title, $editor, $container_name, $owner_name
  * Variables pour les notifications : $content_link, $title, $name, $container_name, $editor, $description, $owner_name

  * Variables pour les titres des messages : $title, $editor
  * Variables pour les messages : $content_link, $title, $name, $container_name, $editor, $description, $sender, $sitename, $msg_url, $reply_url, $owner_name

TODO : il serait plus logique de classer par type d'objet notifié plutôt que par méthode et type d'événement...
  [] = valeurs possibles
  () = facultatif (vide pour les valeurs par défaut)
  >> notification_messages :[SUBTYPE] :[EVENT] (:METHOD) :[subject|message] (:GROUP|)
*/
/* ************************************************ */


'notification_messages:settings:behaviour' => "Comportement pour les types de contenus non définis",
'notification_messages:settings:behaviour:help' => "Que fait-on si un type de contenu n'est pas défini ci-dessous (normalement parce qu'il n'est pas pris en charge correctement par ce plugin) ? FALSE (défaut) pour switcher sur le comportement standard d'Elgg, ou TRUE pour ne pas notifier d'autres contenus que ceux explicitement défini ici. Note : pour que cela fonctionne, vous devez définir le filtre global.",
'notification_messages:hookbehaviour:false' => "Notification standard (par défaut)",
'notification_messages:hookbehaviour:true' => "Bloque les notifications",

'notification_messages:settings:globalsubtypes' => "Types de contenus autorisés",
'notification_messages:settings:globalsubtypes:help' => "Filtre global pour les types de contenus pris en charge par les notifications. Facultatif : aucun = pas de filtrage (tout est notifié - risque d'erreur avec des plugins originaux), ou une liste des types de contenus (subtypes) séparés apr des virgules, sans espace. Ce filtre est appliqué après les filtres par types d'action.",

'notification_messages:settings:createsubtypes' => "Notifications sur les nouveaux contenus",
'notification_messages:settings:createsubtypes:help' => "Toute création d'un nouveau contenu.",

'notification_messages:settings:updatesubtypes' => "Notifications sur les mises à jour",
'notification_messages:settings:updatesubtypes:help' => "Les mises à jour des contenus peuvent générer un flux important de notifications, notamment avec les différentes versions des pages wiki : à utiliser avec modération !",

'notification_messages:settings:annotatesubtypes' => "Notifications sur les annotations",
'notification_messages:settings:annotatesubtypes:help' => "Les annotations correspondent généralement aux commentaires, mais sont aussi utilisées pour l'inscription dans les agendas, etc. Attention à ce qu'on notifie !",


/* **************************************** */
/* WRAPPER - PARTIES GÉNÉRIQUES (EMBALLAGE) */
/* **************************************** */

// MAIL = DEFAULT WRAPPER
'notification_messages:subject:wrapper' => "%1\$s",
'notification_messages:message:wrapper' => "Hi %2\$s,

%1\$s


Note: you may need to connect to the site first to access this content.

___________________________
This is an automated mail alert from '%3\$s', please do not reply by mail", 

// SITE
'notification_messages:subject:site:wrapper' => "%1\$s",
'notification_messages:message:site:wrapper' => "%1\$s", 

// SMS
'notification_messages:subject:sms:wrapper' => "%1\$s",
'notification_messages:message:sms:wrapper' => "%1\$s", 




/* ************************************************************************************ */
// SUJET ET MESSAGE PAR DEFAUT en cas de type d'event absent ou non pris en charge (n'est jamais censé arriver)
// Perso (par défaut)
'notification_messages:default:subject' => "%2\$s published '%1\$s'", 
'notification_messages:default:message' => "%5\$s published '%2\$s'

Read full content on %1\$s", 
// in an groupe
'notification_messages:default:subject:group' => "%2\$s published '%1\$s' (in '%3\$s')", 
'notification_messages:default:message:group' => "%5\$s published '%2\$s' in group '%4\$s'

Read full content on %1\$s", 





/* ************************************************************************************ */
/* COMMENTAIRES (notification sur ses propres contenus, celle qu'on ne peut bypasser... */
/* ************************************************************************************ */
'generic_comment:email:subject' => "You've got a comment!",
'generic_comment:email:body' => "%2\$s commented \"%1\$s\"

%3\$s

Read full content on %4\$s
Note: you may need to connect to the site first to access this content.

View %5\$s's profile on %6\$s

___________________________
This is an automated mail alert, please do not reply by mail", 
/* ************************************************************************************ */




/* ************************************************************************************ */
/* NOTIFICATIONS PAR MAIL : Utilisées par défaut - les autres méthodes sont spécifiques */
/* ************************************************************************************ */

/* ****** */
/* CREATE */

// Blogs persos (par défaut)
'notification_messages:blog:create:subject' => "%2\$s published '%1\$s' in son blog", 
'notification_messages:blog:create:message' => "%5\$s published an article in son blog : '%2\$s'

%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, click on %1\$s", 
// Blogs (de groupe)
'notification_messages:blog:create:subject:group' => "%2\$s published '%1\$s' (in le blog %3\$s)", 
'notification_messages:blog:create:message:group' => "%5\$s published an article in le blog '%4\$s' : '%2\$s'

%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, click on %1\$s", 


// Bookmarks persos (par défaut)
'notification_messages:bookmarks:create:subject' => "%2\$s bookmarked '%1\$s'", 
'notification_messages:bookmarks:create:message' => "%5\$s added a new bookmark : '%2\$s'

%6\$s

Pour accéder à la resource et la commenter, click on %1\$s", 
// Bookmarks (de groupe)
'notification_messages:bookmarks:create:subject:group' => "%2\$s bookmarked '%1\$s' (in '%3\$s')", 
'notification_messages:bookmarks:create:message:group' => "%5\$s added a new bookmark in group '%4\$s' : '%2\$s'

%6\$s

Pour accéder à la resource et la commenter, click on %1\$s", 

// Event calendar persos (par défaut)
'notification_messages:event_calendar:create:subject' => "%2\$s added an event '%1\$s'", 
'notification_messages:event_calendar:create:message' => "%5\$s published a new event : '%2\$s'

%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, click on %1\$s", 
// Event calendar (de groupe)
'notification_messages:event_calendar:create:subject:group' => "%2\$s added an event '%1\$s' (in '%3\$s')", 
'notification_messages:event_calendar:create:message:group' => "%5\$s published a new event in group '%4\$s' : '%2\$s'

%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, click on %1\$s", 

// File persos (par défaut)
'notification_messages:file:create:subject' => "%2\$s published '%1\$s'", 
'notification_messages:file:create:message' => "%5\$s addeda new file : '%2\$s'

%6\$s

Read full content on %1\$s", 
// File (de groupe)
'notification_messages:file:create:subject:group' => "%2\$s published '%1\$s' (in '%3\$s')", 
'notification_messages:file:create:message:group' => "%5\$s addeda new file in group '%4\$s' : '%2\$s'

%6\$s

Read full content on %1\$s", 

// Izap_videos persos (par défaut)
'notification_messages:izap_videos:create:subject' => "%2\$s published video '%1\$s'", 
'notification_messages:izap_videos:create:message' => "%5\$s published a new video : '%2\$s'

%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, click on %1\$s", 
// Izap_videos (de groupe)
'notification_messages:izap_videos:create:subject:group' => "%2\$s published video '%1\$s' (in '%3\$s')", 
'notification_messages:izap_videos:create:message:group' => "%5\$s published a new video in group '%4\$s' : '%2\$s'

%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, click on %1\$s", 

// Discussion (multipublisher) persos (par défaut)
'notification_messages:multipublisher:create:subject' => "%2\$s added a discussion on '%1\$s'", 
'notification_messages:multipublisher:create:message' => "%5\$s added a discussion on '%2\$s'

%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 
// Discussion (multipublisher) (de groupe)
'notification_messages:multipublisher:create:subject:group' => "%2\$s added a discussion on '%1\$s' (in '%3\$s')", 
'notification_messages:multipublisher:create:message:group' => "%5\$s added a discussion on '%2\$s' in group '%4\$s'

%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Discussion, commentaires persos (multipublisher_comment) (par défaut)
'notification_messages:multipublisher_comment:create:subject' => "%2\$s replied to the discussion on '%1\$s'", 
'notification_messages:multipublisher_comment:create:message' => "%5\$s a contribué à la discussion '%2\$s'

%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Discussion, commentaires (multipublisher_comment) (de groupe)
'notification_messages:multipublisher_comment:create:subject:group' => "%2\$s replied to the discussion on '%1\$s' (in '%3\$s')", 
'notification_messages:multipublisher_comment:create:message:group' => "%5\$s replied to the discussion on '%2\$s' in group '%4\$s'

%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages persos (page_top) (par défaut)
'notification_messages:page_top:create:subject' => "%2\$s created a new page : '%1\$s'", 
'notification_messages:page_top:create:message' => "%5\$s created a new page : '%2\$s'

%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 
// Pages (page_top) (de groupe)
'notification_messages:page_top:create:subject:group' => "%2\$s created a new page : '%1\$s' (in '%3\$s')", 
'notification_messages:page_top:create:message:group' => "%5\$s created a new page : '%2\$s' in group '%4\$s'

%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Pages persos (page) (par défaut)
'notification_messages:page:create:subject' => "%2\$s created a new page : '%1\$s'", 
'notification_messages:page:create:message' => "%5\$s created a new page : '%2\$s':

%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 
// Pages (page) (de groupe)
'notification_messages:page:create:subject:group' => "%2\$s created a new page : '%1\$s' (in '%3\$s')", 
'notification_messages:page:create:message:group' => "%5\$s created a new page :  '%2\$s' in group '%4\$s'

%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:create:subject' => "%2\$s changed status : %1\$s", 
'notification_messages:thewire:create:message' => "%5\$s changed status

%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Messages
'notification_messages:messages:create:subject' => "%2\$s wrote you: %1\$s",  
'notification_messages:messages:create:message' => "%5\$s sent you a message :

%6\$s


Access your mailbox on %9\$s

Pour répondre à %5\$s, veuillez vous connecter au site et cliquer sur %10\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'expéditeur - inutile in le mail (page blanche)

// Forum
'notification_messages:groupforumtopic:create:subject' => "%2\$s a écrit sur '%1\$s' (in '%3\$s')", 
'notification_messages:groupforumtopic:create:message' => "%5\$s a écrit sur '%2\$s' in le forum du groupe '%4\$s'

%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Default persos (undefined subtype - should not happen) (par défaut)
'notification_messages:default:create:subject' => "%2\$s published '%1\$s'", 
'notification_messages:default:create:message' => "%5\$s published '%2\$s'

%6\$s

Read full content on %1\$s", 

// Default (de groupe)
'notification_messages:default:create:subject:group' => "%2\$s published '%1\$s' (in '%3\$s')", 
'notification_messages:default:create:message:group' => "%5\$s published '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 





/* ****** */
/* UPDATE */

// Blogs
'notification_messages:blog:update:subject' => "%2\$s a mis à jour '%1\$s' (in le blog %3\$s)", 
'notification_messages:blog:update:message' => "%5\$s a mis à jour '%2\$s' in le blog '%4\$s'

%6\$s

Read full content on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:update:subject' => "%2\$s modified le marque-page '%1\$s' (in '%3\$s')", 
'notification_messages:bookmarks:update:message' => "%5\$s modified le marque-page '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Event calendar
'notification_messages:event_calendar:update:subject' => "%2\$s modified '%1\$s' (in '%3\$s')", 
'notification_messages:event_calendar:update:message' => "%5\$s modified event '%2\$s' in group '%4\$s'

%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, click on %1\$s", 

// File
'notification_messages:file:update:subject' => "%2\$s modified '%1\$s' (in '%3\$s')", 
'notification_messages:file:update:message' => "%5\$s modified le file '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:update:subject' => "%2\$s modified video '%1\$s' (in '%3\$s')", 
'notification_messages:izap_videos:update:message' => "%5\$s modified video '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:update:subject' => "%2\$s replied to the discussion on '%1\$s' (in '%3\$s')", 
'notification_messages:multipublisher:update:message' => "%5\$s a contribué à la discussion '%2\$s' in group '%4\$s'

%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:update:subject' => "%2\$s replied to the discussion on '%1\$s' (in '%3\$s')", 
'notification_messages:multipublisher_comment:update:message' => "%5\$s a contribué à la discussion '%2\$s' in group '%4\$s'

%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:update:subject' => "%2\$s modified the page '%1\$s' (in '%3\$s')", 
'notification_messages:page_top:update:message' => "%5\$s modified the page '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Pages (page)
'notification_messages:page:update:subject' => "%2\$s modified the page '%1\$s' (in '%3\$s')", 
'notification_messages:page:update:message' => "%5\$s modified the page '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:update:subject' => "%2\$s changed status: %1\$s", 
'notification_messages:thewire:update:message' => "%5\$s changed status

%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Messages
'notification_messages:messages:update:subject' => "%2\$s wrote you: %1\$s",  
'notification_messages:messages:update:message' => "%5\$s vous a envoyé an message

%6\$s


Pour accéder à la liste de vos messages, click on %9\$s

Pour répondre à %5\$s, veuillez vous connecter au site et cliquer sur %10\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'expéditeur - inutile in le mail (page blanche)

// Forum
'notification_messages:groupforumtopic:update:subject' => "%2\$s replied to '%1\$s' (in '%3\$s')", 
'notification_messages:groupforumtopic:update:message' => "%5\$s a répondu sur '%2\$s' in le forum du groupe '%4\$s'

%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Default (no defined subtype - should not happen)
'notification_messages:default:update:subject' => "%2\$s modified '%1\$s' (in '%3\$s')", 
'notification_messages:default:update:message' => "%5\$s modified '%2\$s' in group '%4\$s'

%6\$s

Pour y accéder click on %1\$s", 





/* ******** */
/* ANNOTATE */

// Blogs
'notification_messages:blog:annotate:subject' => "%2\$s a commenté '%1\$s' (in '%3\$s')", 
'notification_messages:blog:annotate:message' => "%5\$s a commenté  '%2\$s' in le blog de '%4\$s'

%6\$s

Read full content on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:annotate:subject' => "%2\$s a commenté le marque-page '%1\$s' (in '%3\$s')", 
'notification_messages:bookmarks:annotate:message' => "%5\$s a commenté le marque-page '%2\$s' publié in '%4\$s'

%6\$s

Read full content on %1\$s", 

// Event calendar
'notification_messages:event_calendar:annotate:subject' => "%2\$s a commenté '%1\$s' (in '%3\$s')", 
'notification_messages:event_calendar:annotate:message' => "%5\$s a commenté event '%2\$s' publié in '%4\$s'

%6\$s

Read full content on %1\$s", 

// File
'notification_messages:file:annotate:subject' => "%2\$s a commenté '%1\$s' (in '%3\$s')", 
'notification_messages:file:annotate:message' => "%5\$s a commenté le file '%2\$s' publié in '%4\$s'

%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:annotate:subject' => "%2\$s a commenté video '%1\$s' (in '%3\$s')", 
'notification_messages:izap_videos:annotate:message' => "%5\$s a commenté video '%2\$s' publiée in '%4\$s'

%6\$s

Read full content on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:annotate:subject' => "%2\$s replied to the discussion on '%1\$s' (in '%3\$s')", 
'notification_messages:multipublisher:annotate:message' => "%5\$s replied to the discussion on '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:annotate:subject' => "%2\$s a participé à une discussion sur '%1\$s' (in '%3\$s')", 
'notification_messages:multipublisher_comment:annotate:message' => "%5\$s a participé à la discussion '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:annotate:subject' => "%2\$s a commenté la page '%1\$s' (in '%3\$s')", 
'notification_messages:page_top:annotate:message' => "%5\$s a commenté la page '%2\$s' publiée in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Pages (page)
'notification_messages:page:annotate:subject' => "%2\$s a commenté la page '%1\$s' (in '%3\$s')", 
'notification_messages:page:annotate:message' => "%5\$s a commenté la page '%2\$s' publiée in group '%4\$s'

%6\$s

Read full content on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:annotate:subject' => "%2\$s changed status en '%1\$s'", 
'notification_messages:thewire:annotate:message' => "%5\$s changed status

%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Forum
'notification_messages:groupforumtopic:annotate:subject' => "%2\$s replied to '%1\$s' (in '%3\$s')", 
'notification_messages:groupforumtopic:annotate:message' => "%5\$s replied to '%2\$s' in le forum du groupe '%4\$s'

%6\$s

Read full content on %1\$s", 

// Messages
'notification_messages:messages:annotate:subject' => "%2\$s wrote you: %1\$s",  
'notification_messages:messages:annotate:message' => "%5\$s wrote you an message

%6\$s


Pour accéder à votre messagerie, click on %9\$s

Pour répondre à %5\$s, veuillez vous connecter au site et cliquer sur %10\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile in le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:annotate:subject' => "%2\$s a commenté '%1\$s' (in '%3\$s')", 
'notification_messages:default:annotate:message' => "%5\$s a commenté '%2\$s' in group '%4\$s'

%6\$s

Read full content on %1\$s", 





/* ************************* */
/* NOTIFICATIONS SUR LE SITE */
/* ************************* */

/* ****** */
/* CREATE */

// Blogs
'notification_messages:blog:create:site:subject' => "%2\$s published '%1\$s'", 
'notification_messages:blog:create:site:message' => "%6\$s

Read full content on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:create:site:subject' => "%2\$s bookmarked '%1\$s'", 
'notification_messages:bookmarks:create:site:message' => "%6\$s

Read full content on %1\$s", 

// Event calendar
'notification_messages:event_calendar:create:site:subject' => "%2\$s added an event '%1\$s'", 
'notification_messages:event_calendar:create:site:message' => "%6\$s

Pour ajouter cet date à votre agenda, click on %1\$s", 

// File
'notification_messages:file:create:site:subject' => "%2\$s published '%1\$s'", 
'notification_messages:file:create:site:message' => "%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:create:site:subject' => "%2\$s published video '%1\$s'", 
'notification_messages:izap_videos:create:site:message' => "%6\$s

Pour la visionner, click on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:create:site:subject' => "%2\$s added a discussion on '%1\$s'", 
'notification_messages:multipublisher:create:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 
// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:create:site:subject' => "%2\$s added a discussion on '%1\$s'", 
'notification_messages:multipublisher_comment:create:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:create:site:subject' => "%2\$s created a new page : '%1\$s'", 
'notification_messages:page_top:create:site:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Pages (page)
'notification_messages:page:create:site:subject' => "%2\$s created a new page : '%1\$s'", 
'notification_messages:page:create:site:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:create:site:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:create:site:message' => "%5\$s :

%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Forum
'notification_messages:groupforumtopic:create:site:subject' => "%2\$s a créé an sujet sur '%1\$s'", 
'notification_messages:groupforumtopic:create:site:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Messages
'notification_messages:messages:create:site:subject' => "%2\$s wrote you: %1\$s",  
'notification_messages:messages:create:site:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile in le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:create:site:subject' => "%2\$s published '%1\$s'", 
'notification_messages:default:create:site:message' => "%6\$s

Read full content on %1\$s", 




/* ****** */
/* UPDATE */

// Blogs
'notification_messages:blog:update:site:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:blog:update:site:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, click on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:update:site:subject' => "%2\$s a mis à jour le marque-page '%1\$s'", 
'notification_messages:bookmarks:update:site:message' => "%6\$s

Pour accéder à la resource et la commenter, click on %1\$s", 

// Event calendar
'notification_messages:event_calendar:update:site:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:event_calendar:update:site:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, click on %1\$s", 

// File
'notification_messages:file:update:site:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:file:update:site:message' => "%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:update:site:subject' => "%2\$s modified video '%1\$s'", 
'notification_messages:izap_videos:update:site:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, click on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:update:site:subject' => "%2\$s modified '%1\$s'", 
'notification_messages:multipublisher:update:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:update:site:subject' => "%2\$s modified sa contribution à '%1\$s'", 
'notification_messages:multipublisher_comment:update:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:update:site:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page_top:update:site:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Pages (page)
'notification_messages:page:update:site:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page:update:site:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:update:site:subject' => "%2\$s a mis à jour son statut: %1\$s", 
'notification_messages:thewire:update:site:message' => "%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Forum
'notification_messages:groupforumtopic:update:site:subject' => "%2\$s modified '%1\$s'", 
'notification_messages:groupforumtopic:update:site:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Messages
'notification_messages:messages:update:site:subject' => "%1\$s",  
'notification_messages:messages:update:site:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile in le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:update:site:subject' => "%2\$s modified '%1\$s'", 
'notification_messages:default:update:site:message' => "%6\$s

Pour accéder au contenu complet, click on %1\$s", 




/* ******** */
/* ANNOTATE */

// Blogs
'notification_messages:blog:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:blog:annotate:site:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, click on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:annotate:site:subject' => "%2\$s a commenté le marque-page '%1\$s'", 
'notification_messages:bookmarks:annotate:site:message' => "%6\$s

Pour accéder à la resource et la commenter, click on %1\$s", 

// Event calendar
'notification_messages:event_calendar:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:event_calendar:annotate:site:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, click on %1\$s", 

// File
'notification_messages:file:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:file:annotate:site:message' => "%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:izap_videos:annotate:site:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, click on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:annotate:site:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher:annotate:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:annotate:site:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher_comment:annotate:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:annotate:site:subject' => "%2\$s modified the page '%1\$s'", 
'notification_messages:page_top:annotate:site:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Pages (page)
'notification_messages:page:annotate:site:subject' => "%2\$s modified the page '%1\$s'", 
'notification_messages:page:annotate:site:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:annotate:site:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:annotate:site:message' => "%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Forum
'notification_messages:groupforumtopic:annotate:site:subject' => "%2\$s replied to '%1\$s'", 
'notification_messages:groupforumtopic:annotate:site:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Messages
'notification_messages:messages:annotate:site:subject' => "%1\$s",  
'notification_messages:messages:annotate:site:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile in le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:default:annotate:site:message' => "%6\$s

Read full content on %1\$s", 





/* ********************************************** */
/* NOTIFICATIONS PAR SMS : messages très courts ! */
/* ********************************************** */

/* ****** */
/* CREATE */

// Blogs
'notification_messages:blog:create:sms:subject' => "%2\$s published '%1\$s'", 
'notification_messages:blog:create:sms:message' => "%6\$s

Read full content on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:create:sms:subject' => "%2\$s bookmarked '%1\$s'", 
'notification_messages:bookmarks:create:sms:message' => "%6\$s

Read full content on %1\$s", 

// Event calendar
'notification_messages:event_calendar:create:sms:subject' => "%2\$s added an event '%1\$s'", 
'notification_messages:event_calendar:create:sms:message' => "%6\$s

Pour ajouter cet date à votre agenda, click on %1\$s", 

// File
'notification_messages:file:create:sms:subject' => "%2\$s published '%1\$s'", 
'notification_messages:file:create:sms:message' => "%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:create:sms:subject' => "%2\$s published video '%1\$s'", 
'notification_messages:izap_videos:create:sms:message' => "%6\$s

Pour la visionner, click on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:create:sms:subject' => "%2\$s added a discussion on '%1\$s'", 
'notification_messages:multipublisher:create:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 
// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:create:sms:subject' => "%2\$s added a discussion on '%1\$s'", 
'notification_messages:multipublisher_comment:create:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:create:sms:subject' => "%2\$s created a new page : '%1\$s'", 
'notification_messages:page_top:create:sms:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Pages (page)
'notification_messages:page:create:sms:subject' => "%2\$s created a new page : '%1\$s'", 
'notification_messages:page:create:sms:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:create:sms:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:create:sms:message' => "%5\$s :

%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Forum
'notification_messages:groupforumtopic:create:sms:subject' => "%2\$s a créé an sujet sur '%1\$s'", 
'notification_messages:groupforumtopic:create:sms:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Messages
'notification_messages:messages:create:sms:subject' => "%2\$s wrote you '%1\$s'",  
'notification_messages:messages:create:sms:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile in le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:create:sms:subject' => "%2\$s published '%1\$s'", 
'notification_messages:default:create:sms:message' => "%6\$s

Read full content on %1\$s", 




/* ****** */
/* UPDATE */

// Blogs
'notification_messages:blog:update:sms:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:blog:update:sms:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, click on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:update:sms:subject' => "%2\$s a mis à jour le marque-page '%1\$s'", 
'notification_messages:bookmarks:update:sms:message' => "%6\$s

Pour accéder à la resource et la commenter, click on %1\$s", 

// Event calendar
'notification_messages:event_calendar:update:sms:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:event_calendar:update:sms:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, click on %1\$s", 

// File
'notification_messages:file:update:sms:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:file:update:sms:message' => "%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:update:sms:subject' => "%2\$s modified video '%1\$s'", 
'notification_messages:izap_videos:update:sms:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, click on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:update:sms:subject' => "%2\$s modified '%1\$s'", 
'notification_messages:multipublisher:update:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:update:sms:subject' => "%2\$s modified sa contribution à '%1\$s'", 
'notification_messages:multipublisher_comment:update:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:update:sms:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page_top:update:sms:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Pages (page)
'notification_messages:page:update:sms:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page:update:sms:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:update:sms:subject' => "%2\$s a mis à jour son statut: %1\$s", 
'notification_messages:thewire:update:sms:message' => "%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Forum
'notification_messages:groupforumtopic:update:sms:subject' => "%2\$s modified '%1\$s'", 
'notification_messages:groupforumtopic:update:sms:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Messages
'notification_messages:messages:update:sms:subject' => "%1\$s",  
'notification_messages:messages:update:sms:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile in le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:update:sms:subject' => "%2\$s modified '%1\$s'", 
'notification_messages:default:update:sms:message' => "%6\$s

Pour accéder au contenu complet, click on %1\$s", 




/* ******** */
/* ANNOTATE */

// Blogs
'notification_messages:blog:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:blog:annotate:sms:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, click on %1\$s", 

// Bookmarks
'notification_messages:bookmarks:annotate:sms:subject' => "%2\$s a commenté le marque-page '%1\$s'", 
'notification_messages:bookmarks:annotate:sms:message' => "%6\$s

Pour accéder à la resource et la commenter, click on %1\$s", 

// Event calendar
'notification_messages:event_calendar:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:event_calendar:annotate:sms:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, click on %1\$s", 

// File
'notification_messages:file:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:file:annotate:sms:message' => "%6\$s

Read full content on %1\$s", 

// Izap_videos
'notification_messages:izap_videos:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:izap_videos:annotate:sms:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, click on %1\$s", 

// Discussion (multipublisher)
'notification_messages:multipublisher:annotate:sms:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher:annotate:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:annotate:sms:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher_comment:annotate:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, click on %1\$s", 

// Pages (page_top)
'notification_messages:page_top:annotate:sms:subject' => "%2\$s modified the page '%1\$s'", 
'notification_messages:page_top:annotate:sms:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Pages (page)
'notification_messages:page:annotate:sms:subject' => "%2\$s modified the page '%1\$s'", 
'notification_messages:page:annotate:sms:message' => "%6\$s

Read full content and modify page (if you also have write access to it), click on %1\$s", 

// Statuts (thewire)
'notification_messages:thewire:annotate:sms:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:annotate:sms:message' => "%6\$s

Pour accéder à la liste de ses statuts, click on %1\$s", 

// Forum
'notification_messages:groupforumtopic:annotate:sms:subject' => "%2\$s replied to '%1\$s'", 
'notification_messages:groupforumtopic:annotate:sms:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, click on %1\$s", 

// Messages
'notification_messages:messages:annotate:sms:subject' => "%1\$s",  
'notification_messages:messages:annotate:sms:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'expéditeur - inutile in le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:default:annotate:sms:message' => "%6\$s

Read full content on %1\$s", 



);
    
add_translation("en",$english);

?>