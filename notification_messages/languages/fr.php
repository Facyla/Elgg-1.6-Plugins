<?php
$french = array(

/* ************************************************ */
/* Variables utilisées :
  $content_link : lien vers l'objet
  $owner_name : nom de l'owner du contenu notifié (différencié si c'est un groupe)
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


/* SETTINGS */
'notification_messages:settings:behaviour' => "Comportement pour les types de contenus non définis",
'notification_messages:settings:behaviour:help' => "Comportement à adopter si un type de contenu n'est pas dans la liste des contenus autorisés ci-dessous (normalement parce qu'il n'est pas pris en charge correctement par ce plugin).<br />Note : ce réglage a un effet seulement si le filtre global est utilisé (non vide).<ul><li>FALSE (défaut) pour switcher sur le comportement standard d'Elgg,</li><li>ou TRUE pour ne pas notifier d'autres contenus que ceux explicitement défini ici.</li></ul>",
'notification_messages:hookbehaviour:false' => "Utiliser les notifications standards (par défaut)",
'notification_messages:hookbehaviour:true' => "Pas de notification du tout",

'notification_messages:settings:globalsubtypes' => "Types de contenus autorisés (filtre global)",
'notification_messages:settings:globalsubtypes:help' => "Filtre global pour les types de contenus pris en charge par les notifications.<ul><li>aucun = pas de filtrage = tout est notifié (risque d'erreur avec des plugins originaux),</li><li>ou une liste des types de contenus à notifier (subtypes) séparés par des virgules, sans espace.</li></ul><em>Ce filtre est appliqué après les filtres par types d'action, et sert de filtre global, qui s'ajoute aux filtres particuliers.<br />Note 1 : les 'messages' sont exclus des notifications pour éviter les envois multiples.<br />Note 2 : il est recommandé de lister les types de contenus que l'on souhaite effectivement notifier, car certains contenus n'ont pas à l'être et peuvent causer des notifications inutiles (par ex. les paramètres d'un plugin qui sont bien un 'objet' et sont donc interceptés).</em><br />Liste des 'subtypes' de contenus 'enregistrés' (c'est-à-dire qui apparaissent dans la recherche) : ",

'notification_messages:settings:createsubtypes' => "Notifications sur les nouveaux contenus (filtre)",
'notification_messages:settings:createsubtypes:help' => "Filtre facultatif pour toute création d'un nouveau contenu : vide ou liste des subtypes autorisés.",

'notification_messages:settings:updatesubtypes' => "Notifications sur les mises à jour (filtre)",
'notification_messages:settings:updatesubtypes:help' => "<em>Les mises à jour des contenus peuvent générer un flux important de notifications, notamment avec les différentes versions des pages wiki : à utiliser avec modération !</em><br />Filtre facultatif des mises à jour à notifier : vide ou liste des subtypes autorisés.",

'notification_messages:settings:annotatesubtypes' => "Notifications sur les annotations (filtre)",
'notification_messages:settings:annotatesubtypes:help' => "<em>Les annotations correspondent généralement aux commentaires, mais sont aussi utilisées pour l'inscription dans les agendas, les forums, les mises à jour des wikis, etc. Attention à ce qu'on notifie !</em><br />Filtre facultatif des annotations à notifier : vide ou liste des subtypes autorisés.",

'notification_messages:settings:debugmode' => "Mode debug",
'notification_messages:settings:debugmode:help' => "En mode de débuggage, un email est envoyé chaque fois que le système de notification est utilisé. Cet email est adressé par défaut à l'administrateur principal du site (admin de GUID 2), avec diverses informations sur les notifications : temps de calcul utilisé, nombre de destinataires, mails et GUIDS des destinataires.<br />Diverses autres informations peuvent être incluses à la suite, selon les besoins des développeurs.",
'notification_messages:debugmode:false' => "Non (par défaut)",
'notification_messages:debugmode:true' => "Oui",

'notification_messages:settings:debugmails' => "Destinataires des mails de debug",
'notification_messages:settings:debugmails:help' => "Le destinataire par défaut des mails de debug est l'admin principal (user de GUID 2). Il est possible de le remplacer par un mail ou une liste de mails séparés par des virugules, sans aucun espace entre les mails, par ex.: mail1@dom.tld,mail2@dom.tld,mail3@dom.tld.",

'notification_messages:settings:debugthreshold' => "Restriction des mails de debug (durée mini en secondes)",
'notification_messages:settings:debugthreshold:help' => "Durée de temps d'éxécution du script (en secondes) au-delà de laquelle les mails de debug sont envoyés : 0 ou (vide) = dans tous les cas, sinon une valeur entière en secondes (par exemple : 10). A titre d'étalon, les serveurs mutualisés sont fréquemment configurés pour une limite du temps d'exécution des scripts de 30 secondes.",

// Filtre pour les résumés des contenus
'notification_messages:settings:shortfilter' => "<a><p><ul><ol><li><em><strong><i><u><br>",
// Filtre pour les extraits courts (plus compact et en italique)
'notification_messages:settings:extractfilter' => "<a><p><ul><ol><li><em><strong><u><br>",

/* System messages */
'notification_messages:send:success' => "%s notification(s) envoyée(s) par mail aux personnes qui vous suivent (ou suivent le groupe, le cas échéant), et %s via la messagerie interne du site.",
'notification_messages:send:error' => "Erreur lors de l'envoi des notifications. Veuillez signaler ce problème à l'administrateur du site.",



/* **************************************** */
/* WRAPPER - PARTIES GÉNÉRIQUES (EMBALLAGE) */
/* **************************************** */

// MAIL = DEFAULT WRAPPER
'notification_messages:subject:wrapper' => "%1\$s",
//'notification_messages:message:wrapper' => "Bonjour %2\$s,

// Emballage général de message
'notification_messages:message:wrapper' => '<div style="width:620px; margin:0 auto 0 auto; padding:0; border:0;">
<div style="width:600px; margin:20px auto 10px auto; padding:10px; border:1px solid #9CDD64; background:#EDEDEE; -webkit-border-radius: 8px; -moz-border-radius: 8px;">' 
. "Bonjour,<br /><br />
%1\$s<br />
<i>(vous pouvez avoir besoin de vous identifier sur le site pour accéder au contenu en ligne)</i><br />
</div>
<small>Vous recevez ce message de notification automatique en tant que membre de <a href=\"%4\$s\">%3\$s</a> - merci de ne pas répondre par mail.<br />
<br />
Vous pouvez régler vos préférences pour les notifications via <a href=\"%4\$smod/notifications/\">%4\$smod/notifications/</a>, ainsi que vos alertes pour les groupes via <a href=\"%4\$smod/notifications/groups.php\">%4\$smod/notifications/groups.php</a>
</small><br />
</div>",

// Emballage du contenu notifié
'notification_messages:wrapper:content' => "<blockquote style=\"padding-left:1ex; margin-left:2ex; border-left:5px solid lightgrey;\">%1\$s</blockquote>",

// SITE
'notification_messages:subject:site:wrapper' => "%1\$s",
'notification_messages:message:site:wrapper' => "%1\$s", 

// SMS
'notification_messages:subject:sms:wrapper' => "%1\$s",
'notification_messages:message:sms:wrapper' => "%1\$s", 

// Titre et message pour l'admin en mode debug
'notification_messages:wrapper:debugsubject' => "%1\$s envoi(s) par mail et %3\$s via le site, %2\$s ms",
'notification_messages:wrapper:debugmessage' => "%1\$s, concernant %6\$s\n\nMails notifiés : %2\$s\n\nGUIDs notifiés via le site : %3\$s\n\n%5\$sRapport envoyé par %4\$s",



/* ***************************************** */
/* WRAPPER - Eléments pour certains contenus */
/* ***************************************** */
'notification_messages:readmore' => " [... <a href=\"%1\$s\">lire la suite</a>]<br />",

// Contenu originel
'notification_messages:wrapper:originalpost' => "<br /><u>Rappel du contenu commenté :</u> <span style=\"padding-left:1ex; margin-left:1ex; font-size:small; font-style:italic;\">%1\$s</span><br />",
// Premier sujet de forum
'notification_messages:wrapper:firstforum' => "<u>Rappel du sujet de forum initial :</u> <span style=\"padding-left:1ex; margin-left:1ex; font-size:small; font-style:italic;\">%1\$s</span><br />",
// Précédent sujet de forum
'notification_messages:wrapper:previousforum' => "<u>Précédente réponse :</u> <span style=\"padding-left:1ex; margin-left:1ex; font-size:small; font-style:italic;\">%1\$s</span><br />",
// Précédente version de la page wiki
'notification_messages:wrapper:previouspage' => "<br /><u>Précédente version de la page wiki :</u><span style=\"padding-left:1ex; margin-left:1ex; font-size:small; font-style:italic;\">%1\$s</span>",




/* ************************************************************************************ */
// SUJET ET MESSAGE PAR DEFAUT en cas de type d'event absent ou non pris en charge (n'est jamais censé arriver)
// Perso (par défaut)
'notification_messages:default:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:default:message' => "%5\$s a publié '%2\$s'

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Dans un groupe
'notification_messages:default:subject:group' => "%2\$s a publié '%1\$s' (dans '%3\$s')", 
'notification_messages:default:message:group' => "%5\$s a publié '%2\$s' dans le groupe '%4\$s'

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 




/* ************************************************************************************ */
/* COMMENTAIRES (notification sur ses propres contenus, celle qu'on ne bypasse pas...)  */
/* ************************************************************************************ */
'generic_comment:email:subject' => 'Vous avez un nouveau commentaire !',
'generic_comment:email:body' => "%2\$s a commenté \"%1\$s\"

%3\$s

Pour accéder à ce commentaire sur le site, cliquez sur %4\$s
Note: vous pouvez avoir besoin de vous identifier sur le site pour accéder au contenu en ligne.

Pour voir le profil de %5\$s, cliquez sur %6\$s

___________________________
Ceci est une notification automatique, merci de ne pas y répondre par retour de mail", 
/* ************************************************************************************ */




/* ************************************************************************************ */
/* NOTIFICATIONS PAR MAIL : Utilisées par défaut - les autres méthodes sont spécifiques */
/* ************************************************************************************ */

/* ****** */
/* CREATE */

// Blogs persos (par défaut)
'notification_messages:blog:create:subject' => "%2\$s a publié '%1\$s' dans son blog", 
'notification_messages:blog:create:message' => "%5\$s a publié un article dans son blog : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour accéder à l'article complet et avoir accès aux commentaires, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Blogs (de groupe)
'notification_messages:blog:create:subject:group' => "%2\$s a publié '%1\$s' (dans le blog %3\$s)", 
'notification_messages:blog:create:message:group' => "%5\$s a publié un article dans le blog '%4\$s' : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour accéder à l'article complet et avoir accès aux commentaires, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 


// Bookmarks persos (par défaut)
'notification_messages:bookmarks:create:subject' => "%2\$s a mis en marque-page '%1\$s'", 
'notification_messages:bookmarks:create:message' => "%5\$s a ajouté un marque-page : '%2\$s'<br />
<br />
%6\$s<br />
<br />
URL du lien : <a href=\"%8\$s\">%8\$s</a><br />
<br />
Pour accéder à la resource et la commenter, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Bookmarks (de groupe)
'notification_messages:bookmarks:create:subject:group' => "%2\$s a mis en marque-page '%1\$s' (dans '%3\$s')", 
'notification_messages:bookmarks:create:message:group' => "%5\$s a ajouté un marque-page dans le groupe '%4\$s' : '%2\$s'<br />
<br />
%6\$s<br />
<br />
URL du lien : <a href=\"%8\$s\">%8\$s</a><br />
<br />
Pour accéder à la resource et la commenter, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar persos (par défaut)
'notification_messages:event_calendar:create:subject' => "%2\$s vous annonce '%1\$s'", 
'notification_messages:event_calendar:create:message' => "%5\$s a publié un nouvel événement : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Event calendar (de groupe)
'notification_messages:event_calendar:create:subject:group' => "%2\$s vous annonce '%1\$s' (dans '%3\$s')", 
'notification_messages:event_calendar:create:message:group' => "%5\$s a publié un nouvel événement dans le groupe '%4\$s' : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File persos (par défaut)
'notification_messages:file:create:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:file:create:message' => "%5\$s a ajouté un nouveau document : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Téléchargement direct : <a href=\"%8\$s\">%8\$s</a> (fonctionne si le fichier est public ou après connexion)<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// File (de groupe)
'notification_messages:file:create:subject:group' => "%2\$s a publié '%1\$s' (dans '%3\$s')", 
'notification_messages:file:create:message:group' => "%5\$s a ajouté un nouveau document dans le groupe '%4\$s' : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Téléchargement direct : <a href=\"%8\$s\">%8\$s</a> (fonctionne si le fichier est public ou après connexion)<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos persos (par défaut)
'notification_messages:izap_videos:create:subject' => "%2\$s a publié la vidéo '%1\$s'", 
'notification_messages:izap_videos:create:message' => "%5\$s a publié une nouvelle vidéo : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour visionner cette vidéo et accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Izap_videos (de groupe)
'notification_messages:izap_videos:create:subject:group' => "%2\$s a publié la vidéo '%1\$s' (dans '%3\$s')", 
'notification_messages:izap_videos:create:message:group' => "%5\$s a publié une nouvelle vidéo dans le groupe '%4\$s' : '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour visionner cette vidéo et accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher) persos (par défaut)
'notification_messages:multipublisher:create:subject' => "%2\$s a lancé une discussion sur '%1\$s'", 
'notification_messages:multipublisher:create:message' => "%5\$s a lancé une discussion sur '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Discussion (multipublisher) (de groupe)
'notification_messages:multipublisher:create:subject:group' => "%2\$s a lancé une discussion sur '%1\$s' (dans '%3\$s')", 
'notification_messages:multipublisher:create:message:group' => "%5\$s a lancé une discussion sur '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires persos (multipublisher_comment) (par défaut)
'notification_messages:multipublisher_comment:create:subject' => "%2\$s a contribué à la discussion sur '%1\$s'", 
'notification_messages:multipublisher_comment:create:message' => "%5\$s a contribué à la discussion '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires (multipublisher_comment) (de groupe)
'notification_messages:multipublisher_comment:create:subject:group' => "%2\$s a contribué à la discussion sur '%1\$s' (dans '%3\$s')", 
'notification_messages:multipublisher_comment:create:message:group' => "%5\$s a contribué à la discussion sur '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages persos (page_top) (par défaut)
'notification_messages:page_top:create:subject' => "%2\$s a créé la page '%1\$s'", 
'notification_messages:page_top:create:message' => "%5\$s a créé la page '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Pages (page_top) (de groupe)
'notification_messages:page_top:create:subject:group' => "%2\$s a créé la page '%1\$s' (dans '%3\$s')", 
'notification_messages:page_top:create:message:group' => "%5\$s a créé la page '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages persos (page) (par défaut)
'notification_messages:page:create:subject' => "%2\$s a créé la page '%1\$s'", 
'notification_messages:page:create:message' => "%5\$s a créé la page '%2\$s':<br />
<br />
%6\$s<br />
<br />
Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Pages (page) (de groupe)
'notification_messages:page:create:subject:group' => "%2\$s a créé la page '%1\$s' (dans '%3\$s')", 
'notification_messages:page:create:message:group' => "%5\$s a créé la page  '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:create:subject' => "%2\$s a changé son statut : %1\$s", 
'notification_messages:thewire:create:message' => "%5\$s a changé son statut<br />
<br />
%6\$s<br />
<br />
Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:create:subject' => "%2\$s vous a écrit: %1\$s",  
'notification_messages:messages:create:message' => "%5\$s vous a envoyé le message suivant :<br />
<br />
%6\$s<br />
<br />

Pour accéder à la liste de vos messages, veuillez cliquer sur %9\$s

Pour répondre à %5\$s, veuillez vous identifier sur le site et cliquer sur %10\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'expéditeur - inutile dans le mail (page blanche)

// Forum
'notification_messages:groupforumtopic:create:subject' => "%2\$s a écrit sur '%1\$s' (dans '%3\$s')", 
'notification_messages:groupforumtopic:create:message' => "%5\$s a écrit sur '%2\$s' dans le forum du groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Default persos (undefined subtype - should not happen) (par défaut)
'notification_messages:default:create:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:default:create:message' => "%5\$s a publié '%2\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Default (de groupe)
'notification_messages:default:create:subject:group' => "%2\$s a publié '%1\$s' (dans '%3\$s')", 
'notification_messages:default:create:message:group' => "%5\$s a publié '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 





/* ****** */
/* UPDATE */

// Blogs
'notification_messages:blog:update:subject' => "%2\$s a mis à jour '%1\$s' (dans le blog %3\$s)", 
'notification_messages:blog:update:message' => "%5\$s a mis à jour '%2\$s' dans le blog '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:update:subject' => "%2\$s a modifié le marque-page '%1\$s' (dans '%3\$s')", 
'notification_messages:bookmarks:update:message' => "%5\$s a modifié le marque-page '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
URL du lien : <a href=\"%8\$s\">%8\$s</a><br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:update:subject' => "%2\$s a modifié '%1\$s' (dans '%3\$s')", 
'notification_messages:event_calendar:update:message' => "%5\$s a modifié l'événement '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:update:subject' => "%2\$s a modifié '%1\$s' (dans '%3\$s')", 
'notification_messages:file:update:message' => "%5\$s a modifié le document '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Téléchargement direct : <a href=\"%8\$s\">%8\$s</a> (fonctionne si le fichier est public ou après connexion)<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:update:subject' => "%2\$s a modifié la vidéo '%1\$s' (dans '%3\$s')", 
'notification_messages:izap_videos:update:message' => "%5\$s a modifié la vidéo '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:update:subject' => "%2\$s a contribué à la discussion sur '%1\$s' (dans '%3\$s')", 
'notification_messages:multipublisher:update:message' => "%5\$s a contribué à la discussion '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:update:subject' => "%2\$s a contribué à la discussion sur '%1\$s' (dans '%3\$s')", 
'notification_messages:multipublisher_comment:update:message' => "%5\$s a contribué à la discussion '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:update:subject' => "%2\$s a modifié la page '%1\$s' (dans '%3\$s')", 
'notification_messages:page_top:update:message' => "%5\$s a modifié la page '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:update:subject' => "%2\$s a modifié la page '%1\$s' (dans '%3\$s')", 
'notification_messages:page:update:message' => "%5\$s a modifié la page '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:update:subject' => "%2\$s a changé son statut: %1\$s", 
'notification_messages:thewire:update:message' => "%5\$s a changé son statut<br />
<br />
%6\$s<br />
<br />
Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:update:subject' => "%2\$s vous a écrit: %1\$s",  
'notification_messages:messages:update:message' => "%5\$s vous a envoyé un message<br />
<br />
%6\$s<br />
<br />

Pour accéder à la liste de vos messages, veuillez cliquer sur %9\$s

Pour répondre à %5\$s, veuillez vous identifier sur le site et cliquer sur %10\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'expéditeur - inutile dans le mail (page blanche)

// Forum
'notification_messages:groupforumtopic:update:subject' => "%2\$s a répondu à '%1\$s' (dans '%3\$s')", 
'notification_messages:groupforumtopic:update:message' => "%5\$s a répondu sur '%2\$s' dans le forum du groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Default (no defined subtype - should not happen)
'notification_messages:default:update:subject' => "%2\$s a modifié '%1\$s' (dans '%3\$s')", 
'notification_messages:default:update:message' => "%5\$s a modifié '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 





/* ******** */
/* ANNOTATE */

// Blogs
'notification_messages:blog:annotate:subject' => "%2\$s a commenté '%1\$s' (dans '%3\$s')", 
'notification_messages:blog:annotate:message' => "%5\$s a commenté  '%2\$s' dans le blog de '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:annotate:subject' => "%2\$s a commenté le marque-page '%1\$s' (dans '%3\$s')", 
'notification_messages:bookmarks:annotate:message' => "%5\$s a commenté le marque-page '%2\$s' publié dans '%4\$s'<br />
<br />
%6\$s<br />
<br />
URL du lien : <a href=\"%8\$s\">%8\$s</a><br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:annotate:subject' => "%2\$s a commenté '%1\$s' (dans '%3\$s')", 
'notification_messages:event_calendar:annotate:message' => "%5\$s a commenté l'événement '%2\$s' publié dans '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:annotate:subject' => "%2\$s a commenté '%1\$s' (dans '%3\$s')", 
'notification_messages:file:annotate:message' => "%5\$s a commenté le document '%2\$s' publié dans '%4\$s'<br />
<br />
%6\$s<br />
<br />
Téléchargement direct : <a href=\"%8\$s\">%8\$s</a> (fonctionne si le fichier est public ou après connexion)<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:annotate:subject' => "%2\$s a commenté la vidéo '%1\$s' (dans '%3\$s')", 
'notification_messages:izap_videos:annotate:message' => "%5\$s a commenté la vidéo '%2\$s' publiée dans '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:annotate:subject' => "%2\$s a contribué à la discussion sur '%1\$s' (dans '%3\$s')", 
'notification_messages:multipublisher:annotate:message' => "%5\$s a contribué à la discussion sur '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:annotate:subject' => "%2\$s a participé à une discussion sur '%1\$s' (dans '%3\$s')", 
'notification_messages:multipublisher_comment:annotate:message' => "%5\$s a participé à la discussion '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:annotate:subject' => "%2\$s a commenté la page '%1\$s' (dans '%3\$s')", 
'notification_messages:page_top:annotate:message' => "%5\$s a commenté la page '%2\$s' publiée dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:annotate:subject' => "%2\$s a commenté la page '%1\$s' (dans '%3\$s')", 
'notification_messages:page:annotate:message' => "%5\$s a commenté la page '%2\$s' publiée dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:annotate:subject' => "%2\$s a changé son statut en '%1\$s'", 
'notification_messages:thewire:annotate:message' => "%5\$s a changé son statut<br />
<br />
%6\$s<br />
<br />
Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Forum
'notification_messages:groupforumtopic:annotate:subject' => "%2\$s a répondu à '%1\$s' (dans '%3\$s')", 
'notification_messages:groupforumtopic:annotate:message' => "%5\$s a répondu à '%2\$s' dans le forum du groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:annotate:subject' => "%2\$s vous a écrit: %1\$s",  
'notification_messages:messages:annotate:message' => "%5\$s vous a écrit un message<br />
<br />
%6\$s<br />
<br />

Pour accéder à votre messagerie, veuillez cliquer sur %9\$s

Pour répondre à %5\$s, veuillez vous identifier sur le site et cliquer sur %10\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile dans le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:annotate:subject' => "%2\$s a commenté '%1\$s' (dans '%3\$s')", 
'notification_messages:default:annotate:message' => "%5\$s a commenté '%2\$s' dans le groupe '%4\$s'<br />
<br />
%6\$s<br />
<br />
Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 





/* ************************* */
/* NOTIFICATIONS SUR LE SITE */
/* ************************* */

/* ****** */
/* CREATE */

// Blogs
'notification_messages:blog:create:site:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:blog:create:site:message' => "%6\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:create:site:subject' => "%2\$s a mis en marque-page '%1\$s'", 
'notification_messages:bookmarks:create:site:message' => "%6\$s

URL du lien : %8\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:create:site:subject' => "%2\$s vous annonce '%1\$s'", 
'notification_messages:event_calendar:create:site:message' => "%6\$s

Pour ajouter cet date à votre agenda, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:create:site:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:file:create:site:message' => "%6\$s

Téléchargement direct : %8\$s (fonctionne si le fichier est public ou après connexion)

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:create:site:subject' => "%2\$s a publié la vidéo '%1\$s'", 
'notification_messages:izap_videos:create:site:message' => "%6\$s

Pour la visionner, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:create:site:subject' => "%2\$s a lancé une discussion sur '%1\$s'", 
'notification_messages:multipublisher:create:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:create:site:subject' => "%2\$s a lancé une discussion sur '%1\$s'", 
'notification_messages:multipublisher_comment:create:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:create:site:subject' => "%2\$s a créé la page '%1\$s'", 
'notification_messages:page_top:create:site:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:create:site:subject' => "%2\$s a créé la page '%1\$s'", 
'notification_messages:page:create:site:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:create:site:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:create:site:message' => "%5\$s :<br />
<br />
%6\$s<br />
<br />
Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Forum
'notification_messages:groupforumtopic:create:site:subject' => "%2\$s a créé un sujet sur '%1\$s'", 
'notification_messages:groupforumtopic:create:site:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:create:site:subject' => "%2\$s vous a écrit: %1\$s",  
'notification_messages:messages:create:site:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile dans le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:create:site:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:default:create:site:message' => "%6\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 




/* ****** */
/* UPDATE */

// Blogs
'notification_messages:blog:update:site:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:blog:update:site:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:update:site:subject' => "%2\$s a mis à jour le marque-page '%1\$s'", 
'notification_messages:bookmarks:update:site:message' => "%6\$s

URL du lien : %8\$s

Pour accéder à la resource et la commenter, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:update:site:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:event_calendar:update:site:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:update:site:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:file:update:site:message' => "%6\$s

Téléchargement direct : %8\$s (fonctionne si le fichier est public ou après connexion)

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:update:site:subject' => "%2\$s a modifié la vidéo '%1\$s'", 
'notification_messages:izap_videos:update:site:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:update:site:subject' => "%2\$s a modifié '%1\$s'", 
'notification_messages:multipublisher:update:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:update:site:subject' => "%2\$s a modifié sa contribution à '%1\$s'", 
'notification_messages:multipublisher_comment:update:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:update:site:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page_top:update:site:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:update:site:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page:update:site:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:update:site:subject' => "%2\$s a mis à jour son statut: %1\$s", 
'notification_messages:thewire:update:site:message' => "%6\$s

Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Forum
'notification_messages:groupforumtopic:update:site:subject' => "%2\$s a modifié '%1\$s'", 
'notification_messages:groupforumtopic:update:site:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:update:site:subject' => "%1\$s",  
'notification_messages:messages:update:site:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile dans le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:update:site:subject' => "%2\$s a modifié '%1\$s'", 
'notification_messages:default:update:site:message' => "%6\$s

Pour accéder au contenu complet, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 




/* ******** */
/* ANNOTATE */

// Blogs
'notification_messages:blog:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:blog:annotate:site:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:annotate:site:subject' => "%2\$s a commenté le marque-page '%1\$s'", 
'notification_messages:bookmarks:annotate:site:message' => "%6\$s

URL du lien : %8\$s

Pour accéder à la resource et la commenter, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:event_calendar:annotate:site:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:file:annotate:site:message' => "%6\$s

Téléchargement direct : %8\$s (fonctionne si le fichier est public ou après connexion)

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:izap_videos:annotate:site:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:annotate:site:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher:annotate:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:annotate:site:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher_comment:annotate:site:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:annotate:site:subject' => "%2\$s a modifié la page '%1\$s'", 
'notification_messages:page_top:annotate:site:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:annotate:site:subject' => "%2\$s a modifié la page '%1\$s'", 
'notification_messages:page:annotate:site:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:annotate:site:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:annotate:site:message' => "%6\$s

Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Forum
'notification_messages:groupforumtopic:annotate:site:subject' => "%2\$s a répondu à '%1\$s'", 
'notification_messages:groupforumtopic:annotate:site:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:annotate:site:subject' => "%1\$s",  
'notification_messages:messages:annotate:site:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile dans le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:annotate:site:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:default:annotate:site:message' => "%6\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 





/* ********************************************** */
/* NOTIFICATIONS PAR SMS : messages très courts ! */
/* ********************************************** */

/* ****** */
/* CREATE */

// Blogs
'notification_messages:blog:create:sms:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:blog:create:sms:message' => "%6\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:create:sms:subject' => "%2\$s a mis en marque-page '%1\$s'", 
'notification_messages:bookmarks:create:sms:message' => "%6\$s

URL du lien : %8\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:create:sms:subject' => "%2\$s vous annonce '%1\$s'", 
'notification_messages:event_calendar:create:sms:message' => "%6\$s

Pour ajouter cet date à votre agenda, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:create:sms:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:file:create:sms:message' => "%6\$s

Téléchargement direct : %8\$s (fonctionne si le fichier est public ou après connexion)

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:create:sms:subject' => "%2\$s a publié la vidéo '%1\$s'", 
'notification_messages:izap_videos:create:sms:message' => "%6\$s

Pour la visionner, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:create:sms:subject' => "%2\$s a lancé une discussion sur '%1\$s'", 
'notification_messages:multipublisher:create:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 
// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:create:sms:subject' => "%2\$s a lancé une discussion sur '%1\$s'", 
'notification_messages:multipublisher_comment:create:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:create:sms:subject' => "%2\$s a créé la page '%1\$s'", 
'notification_messages:page_top:create:sms:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:create:sms:subject' => "%2\$s a créé la page '%1\$s'", 
'notification_messages:page:create:sms:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:create:sms:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:create:sms:message' => "%5\$s :<br />
<br />
%6\$s<br />
<br />
Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Forum
'notification_messages:groupforumtopic:create:sms:subject' => "%2\$s a créé un sujet sur '%1\$s'", 
'notification_messages:groupforumtopic:create:sms:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:create:sms:subject' => "%2\$s vous a écrit '%1\$s'",  
'notification_messages:messages:create:sms:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile dans le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:create:sms:subject' => "%2\$s a publié '%1\$s'", 
'notification_messages:default:create:sms:message' => "%6\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 




/* ****** */
/* UPDATE */

// Blogs
'notification_messages:blog:update:sms:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:blog:update:sms:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:update:sms:subject' => "%2\$s a mis à jour le marque-page '%1\$s'", 
'notification_messages:bookmarks:update:sms:message' => "%6\$s

URL du lien : %8\$s

Pour accéder à la resource et la commenter, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:update:sms:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:event_calendar:update:sms:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:update:sms:subject' => "%2\$s a mis à jour '%1\$s'", 
'notification_messages:file:update:sms:message' => "%6\$s

Téléchargement direct : %8\$s (fonctionne si le fichier est public ou après connexion)

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:update:sms:subject' => "%2\$s a modifié la vidéo '%1\$s'", 
'notification_messages:izap_videos:update:sms:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:update:sms:subject' => "%2\$s a modifié '%1\$s'", 
'notification_messages:multipublisher:update:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:update:sms:subject' => "%2\$s a modifié sa contribution à '%1\$s'", 
'notification_messages:multipublisher_comment:update:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:update:sms:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page_top:update:sms:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:update:sms:subject' => "%2\$s a mis à jour la page '%1\$s'", 
'notification_messages:page:update:sms:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:update:sms:subject' => "%2\$s a mis à jour son statut: %1\$s", 
'notification_messages:thewire:update:sms:message' => "%6\$s

Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Forum
'notification_messages:groupforumtopic:update:sms:subject' => "%2\$s a modifié '%1\$s'", 
'notification_messages:groupforumtopic:update:sms:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:update:sms:subject' => "%1\$s",  
'notification_messages:messages:update:sms:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'exépditeur - inutile dans le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:update:sms:subject' => "%2\$s a modifié '%1\$s'", 
'notification_messages:default:update:sms:message' => "%6\$s

Pour accéder au contenu complet, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 




/* ******** */
/* ANNOTATE */

// Blogs
'notification_messages:blog:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:blog:annotate:sms:message' => "%6\$s

Pour accéder à l'article complet et avoir accès aux commentaires, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Bookmarks
'notification_messages:bookmarks:annotate:sms:subject' => "%2\$s a commenté le marque-page '%1\$s'", 
'notification_messages:bookmarks:annotate:sms:message' => "%6\$s

URL du lien : %8\$s

Pour accéder à la resource et la commenter, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Event calendar
'notification_messages:event_calendar:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:event_calendar:annotate:sms:message' => "%6\$s

Pour voir les détails de cet événement et l'ajouter à votre agenda personnel, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// File
'notification_messages:file:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:file:annotate:sms:message' => "%6\$s

Téléchargement direct : %8\$s (fonctionne si le fichier est public ou après connexion)

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Izap_videos
'notification_messages:izap_videos:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:izap_videos:annotate:sms:message' => "%6\$s

Pour visionner cette vidéo et accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion (multipublisher)
'notification_messages:multipublisher:annotate:sms:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher:annotate:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Discussion, commentaires (multipublisher_comment)
'notification_messages:multipublisher_comment:annotate:sms:subject' => "%2\$s a contribué à la discussion '%1\$s'", 
'notification_messages:multipublisher_comment:annotate:sms:message' => "%6\$s

Pour lire toutes les contributions et y réagir, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page_top)
'notification_messages:page_top:annotate:sms:subject' => "%2\$s a modifié la page '%1\$s'", 
'notification_messages:page_top:annotate:sms:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Pages (page)
'notification_messages:page:annotate:sms:subject' => "%2\$s a modifié la page '%1\$s'", 
'notification_messages:page:annotate:sms:message' => "%6\$s

Pour modifier cette page (sous réserve que vous en ayez l'autorisation de l'auteur), veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Statuts (thewire)
'notification_messages:thewire:annotate:sms:subject' => "%2\$s a mis à jour son statut : %1\$s", 
'notification_messages:thewire:annotate:sms:message' => "%6\$s

Pour accéder à la liste de ses statuts, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Forum
'notification_messages:groupforumtopic:annotate:sms:subject' => "%2\$s a répondu à '%1\$s'", 
'notification_messages:groupforumtopic:annotate:sms:message' => "%6\$s

Pour accéder à l'ensemble de la discussion, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 

// Messages
'notification_messages:messages:annotate:sms:subject' => "%1\$s",  
'notification_messages:messages:annotate:sms:message' => "%6\$s", 
// NOTE : le link créé ne convient pas pour les messages : c'est celui de l'expéditeur - inutile dans le mail (page blanche)

// Default (no defined subtype - should not happen)
'notification_messages:default:annotate:sms:subject' => "%2\$s a commenté '%1\$s'", 
'notification_messages:default:annotate:sms:message' => "%6\$s

Pour y accéder, veuillez cliquer sur <a href=\"%1\$s\">%1\$s</a>", 



);
    
add_translation("fr",$french);

?>