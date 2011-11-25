<?php
/**
 * Elgg notification messages plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright (cc) Facyla 2010
 * @link http://id.facyla.net/
 * Description :
 ** Mode Elgg par défaut : tous nouveaux contenus notifiés sauf les page_top (corrigé par ce plugin: page_top aussi notifiés). Par contre les sous-pages sont notifiées sans tenir compte des droits (=> pages à corriger)
 ** Seuls les contenus d'accès "Public" et "Membres du site" sont notifiés (corrigé par ce plugin: tous types d'accès sont notifiés)
 ** Pas de notification sur les commentaires sauf dans les forums (corrigé par ce plugin: prise en charge des autres types d'objets)
 ** Messages maintenant différenciés selon le type d'événement, la méthode utilisée et le contexte (groupe ou non)
 */

function notificationmessages_init() {
  global $CONFIG;
  
  $eventhandler_priority = 1; // 0 first, 1000 last
  /* GESTION DES MESSAGES PAR DEFAUT (HOOKS DE NOTIFICATION) */
  // Use following code to suppress existing default subject hooks (useless with this plugin - only for information)
  // Pour retirer les hooks de notification et redéfinir les intitulés proprement (inutile avec ce plugin qui les redéfinit sans utiliser ces titres par défaut)
  /*
  if (isset($CONFIG->hooks['notify:entity:message']['object']))
    // Messages par défaut des notifications
    foreach($CONFIG->hooks['notify:entity:message']['object'] as $key => $function) {
      if ($function == 'blog_notify_message') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
      if ($function == 'bookmarks_notify_message') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
      if ($function == 'file_notify_message') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
      if ($function == 'groupforumtopic_notify_message') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
      if ($function == 'messages_notification_msg') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
      if ($function == 'page_notify_message') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
      if ($function == 'thewire_notify_message') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
      if ($function == 'tidypics_notify_message') unset($CONFIG->hooks['notify:entity:message']['object'][$key]);
    }
  */

  /* GESTION DES HOOKS DE NOTIFICATION */
  // Suppression des hooks existants : seuls les groupes l'utilisent (et ce plugin)
  /*
    if (isset($CONFIG->hooks['object:notifications']['object']))
      foreach($CONFIG->hooks['object:notifications']['object'] as $key => $function) {
        if ($function == 'group_object_notifications_intercept') unset($CONFIG->hooks['object:notifications']['object'][$key]);
      }
  */
  // Intercepts and rewrites object_notifications fonction
  register_plugin_hook('object:notifications','object','notificationmessages_object_notifications', $eventhandler_priority);
  
  
  /* GESTION DES OBJETS A NOTIFIER OU PAS */
  // Register subtypes that weren't handled yet / Ajoute les types d'objets non enregistrés
  register_notification_object('object', 'page_top', elgg_echo('pages:new')); // Top-level pages weren't registered yet
  // Pour désactiver les notifications sur certains objets, utiliser // if (isset($CONFIG->register_objects['object']['page'])) unset($CONFIG->register_objects['object']['page']);

  
  /* GESTION DES HANDLERS DE PRISE EN CHARGE DES EVENEMENTS */
  // Interception des événements - seul object_notifications le fait (on pourrait carrément l'invalider et remplacer, mais pas très utile, le hook suffit)
  // On pourrait supprimer carrément le système par défaut (qui intercepte create,object) pour le remplacer par celui de ce plugin, MAIS on l'utilise quand même
  if (isset($CONFIG->events['create']['object'])) {
    foreach($CONFIG->events['create']['object'] as $key => $function) {
      if ($function == 'object_notifications') unset($CONFIG->events['create']['object'][$key]);
    }
  }
	
	// Variables à récupérer (sinon on a le contenu de l'article d'origine au lieu de celui de l'annotation). Entretemps, on ne met pas le contenu, point.
	// @todo: find how to get the current annotation content, instead of previous comment. No content should be send before it's done.
	// Note : Owner is notified correctly (directly, when adding the comment, no hook provided) => invalidate that notification once it's done properly (use annotate hook as priority 0, return proper value to skip other hooks.
	
	register_elgg_event_handler('create','object','notificationmessages_create_handler', $eventhandler_priority); // Suite à une création
	// Note importante : pour un forum, le contenu est dans une annotation !
	
	register_elgg_event_handler('update','object','notificationmessages_update_handler', $eventhandler_priority); // Suite à une modification
	
//	register_elgg_event_handler('annotate','object','notificationmessages_annotate_handler', $eventhandler_priority); // Suite à un commentaire (trigger *avant de sauver le contenu) - on devrait pouvoir intercepter les notifications sur ses propres contenus avec ça
	// Le bon trigger pour notifier suite à une annotation (commentaire, modif page wiki ou réponse forum - activé une fois le contenu sauvé)
	register_elgg_event_handler('create','annotation','notificationmessages_annotate_handler', $eventhandler_priority);
//	register_elgg_event_handler('update','annotation','notificationmessages_update_handler', $eventhandler_priority); // Suite à une modification d'une annotation (attention: il y en a de beaucoup de types différents) - @todo mais pas essentiel dans un premier temps
	
}



/* Filter which elements are notified on "create" event type */
function notificationmessages_create_handler($event, $object_type, $object) {
  if (is_callable('object_notifications')) {
    if ($object instanceof ElggObject) {
      $object_subtype = $object->getSubtype();
      // Some valid subtypes (if activated) : blog,bookmarks,event_calendar,file,groupforumtopic,izap_videos,page,page_top,thewire
      $createsubtypes = trim(get_plugin_setting('createsubtypes'));
      if (strlen($createsubtypes) > 1) { $a_subtypes = explode(',', $createsubtypes); } else { $a_subtypes = ""; }
      // Admin settings allowed subtypes - default is empty (no filter)
      if (empty($createsubtypes) || in_array($object_subtype, $a_subtypes)) {
        // Correction : we don't ovveride regular 'messages' - otherwise might lead to multiple sendings
        if ($object_subtype != 'messages') {
          // On passe les données d'origine : create, objecttype, object
          object_notifications($event, $object_type, $object);
        }
      }
    }
  }
}

/* Filter which elements are notified on "update" event type */
function notificationmessages_update_handler($event, $object_type, $object) {
  // This checks that the event is called from the proper place ; returns true to avoid sending duplicate notifications
  // by skipping first event call and rely only on event triggered after action
  // This method avoids patching core file engine/lib/entities.php
  // See for more details : trac http://trac.elgg.org/ticket/2364 and http://trac.elgg.org/ticket/3710
  $traces = debug_backtrace();
  foreach ($traces as $trace) { if ($trace['function'] == 'update_entity') return true; }
  if (is_callable('object_notifications')) {
    if ($object instanceof ElggObject) {
      $object_subtype = $object->getSubtype();
      // Some valid subtypes (if activated) : blog,bookmarks,event_calendar,file,groupforumtopic,izap_videos,page,page_top,thewire
      $updatesubtypes = trim(get_plugin_setting('updatesubtypes'));
      if (strlen($updatesubtypes) > 1) { $a_subtypes = explode(',', $updatesubtypes); } else { $a_subtypes = ""; }
      // Admin settings allowed subtypes - default is empty (no filter)
      if (empty($updatesubtypes) || in_array($object_subtype, $a_subtypes)) {
        // Correction : we don't ovveride regular 'messages' - otherwise might lead to multiple sendings
        if ($object_subtype != 'messages') {
          // On passe les données d'origine : create, objecttype, object
          object_notifications($event, $object_type, $object);
        }
      }
    }
  }
}

/* Filter which elements are notified on "annotate" event type */
function notificationmessages_annotate_handler($event, $entity_type, $annotation) {
  if (is_callable('object_notifications')) {
    // Note : création d'une annotation $annotation - l'événement doit être correctement interprété par la suite
    $event = 'annotate';
    // Filtrage des types d'annotations à notifier : OK pour generic_comment, pas le reste (modifs des pages wiki, réponses dans les forums, etc.)
    if (($annotation instanceof ElggAnnotation) && ($annotation->name == 'generic_comment')) {
      $object = $annotation->getEntity();
      $object_type = $object->getType();
      $object_subtype = $object->getSubtype();
      // Some valid subtypes (if activated) : blog,bookmarks,event_calendar,file,groupforumtopic,izap_videos,page,page_top,thewire
      $annotatesubtypes = trim(get_plugin_setting('annotatesubtypes'));
      if (strlen($annotatesubtypes) > 1) { $a_subtypes = explode(',', $annotatesubtypes); } else { $a_subtypes = ""; }
      // Admin settings allowed subtypes - default is empty (no filter)
      if (empty($annotatesubtypes) || in_array($object_subtype, $a_subtypes)) {
        // Correction : we don't ovveride regular 'messages' - otherwise might lead to multiple sendings
        if ($object_subtype != 'messages') {
          // On passe les données d'origine : create, objecttype, object
          object_notifications($event, $object_type, $object);
        }
      }
    }
  }
}



/* Defines subject and message body for any event, object subtype, notification method and publication context (ie. group)
 * Replaces the object_notifications default content
 * Doesn't consider the existing default messages hooks (as it intercepts them before they're used)
 * As it is a hook, we already know that $object is a valid ElggEntity
*/
function notificationmessages_object_notifications($hook, $entity_type, $returnvalue, $params) {
  
  $t1 = microtime(true);
  // Get config data
  global $CONFIG, $SESSION, $NOTIFICATION_HANDLERS;
  
  // Quelle que soit la manière de notifier et l'événement, on a tout ramené à un contenu normalisé : event, type, object
  if (isset($params)) {
    $event = $params['event'];
    $object_type = $params['object_type'];
    $object = $params['object'];
  }
  
  // Checking required data and context - only notified handled content and block or skip others (depending on admin settings)
  if ($object_type == 'object') {
    $object_subtype = $object->getSubtype();
    if (empty($object_subtype)) { $object_subtype = 'default'; }
    
    // Configurable hook return value - lets define how we handle unknown subtypes : skip or use elgg's standard system
    $hookreturnvalue = trim(get_plugin_setting('hookbehaviour'));
    
    // Get behaviour for unhandled content types
    switch ($hookreturnvalue) {
      case 'null': $hookreturnvalue = null; break;
      case 'true': $hookreturnvalue = true; break;
      // False, Default or undefined is 'false' = use standard system if subtype not handled
      case 'false':
      default: $hookreturnvalue = false;
    }
    
    $debugmode = trim(get_plugin_setting('debugmode'));
    if ($debugmode == "true") { $debugmode = true; } else { $debugmode = false; }
    
    // This a second-level filter (as it's already defined before, per-action type), but it may not be defined, 
    // or we might want a global filter instead of several ones..
    // We don't want to intercept subtypes that are not handled
    // On vérifie ici qu'on est dans la bonne gamme de subtypes, sinon on renvoie false pour passer sur le comportement standard, null pour le comportement par défaut, ou true pour ne rien faire du tout
    // Some valid subtypes (if activated) : blog,bookmarks,event_calendar,file,groupforumtopic,izap_videos,page,page_top,thewire
    // Messages : à ajouter une fois le message standard invalidé
    $globalsubtypes = trim(get_plugin_setting('globalsubtypes'));
    if (strlen($globalsubtypes) > 0) { $a_subtypes = explode(',', $globalsubtypes); } else { $a_subtypes = ""; }
    // Admin filter settings : allowed subtypes - default is empty and means accept all
    if (empty($globalsubtypes) || in_array($object_subtype, $a_subtypes)) {
    
      // Is this content registered for notifications ? / Vérifie s'il y a des notifications pour ce type d'objet
      if (isset($CONFIG->register_objects[$object_type][$object_subtype])) {
        
        // Filtres utilisés pour 'strip_tags'
        $shortfilter = elgg_echo('notification_messages:settings:shortfilter'); // Pour les résumés des contenus
        $extractfilter = elgg_echo('notification_messages:settings:extractfilter'); // Pour les extraits courts (plus compact et en italique)
        // Needle for shortened description ("where do we cut it ?")
        //$needle = "\n"; // This is good but..
        $needle = " "; // This is better when there are long lines
        
        // ON DÉFINIT ICI LES VARIABLES À UTILISER DANS LES MESSAGES ET POUR LEUR ENVOI
        /*
          * $event : type d'événement concerné : create, update, annotate
          * $object : l'objet concerné (soit créé/modifié, soit commenté)
          * $object_subtype : subtype d'objet concerné
          * $translate_method : utilisé pour déterminer le type de contenu du message ( (vide) = default = email, sms, site)
          * $translate_owner : user ou group, pour différencier les messages
          * $title : titre de la notification
          * $name : nom du destinataire
          * $editor : nom de l'auteur de l'objet, du commentaire ou de la modification
          * $owner : auteur du contenu initial (soit idem $editor, soit auteur de l'objet modifié/commenté)
          * $owner_name : nom de l'auteur du contenu initial
          * $container_guid : GUID du 'container' de l'objet notifié (site, group, user)
          * $container : 'container' de l'objet notifié (site, group, user)
          * $container_name : nom en clair du 'container'
          * $description : contenu ajouté ou modifié (contenu de l'annotation dans certains cas : groupforumtopic, page)
          * $lastcomment : contenu du dernier commentaire, réponse en forum ou contenu de la page wiki
          * $content_link : lien vers le contenu (vers l'object concerné)
          * $object_guid : GUID de l'objet
          * $bookmark_link : lien vers le marque-page (address)
          * $download_link : lien de téléchargement du fichier
        */
        
        // $editor : nom de l'auteur de l'objet, du commentaire ou de la modification
        $editor = $SESSION['user']->name; // éditeur de l'objet : auteur du commentaire ou de la modification
        // $object_guid : GUID de l'objet
        $object_guid = $object->guid;
        // $content_link : lien vers le contenu (vers l'object concerné)
        $content_link = $object->getURL();  // seulement l'URL du lien vers l'objet (string)
        // $owner : auteur du contenu initial (soit idem $editor, soit auteur de l'objet modifié/commenté)
        $owner = $object->getOwnerEntity();
        // $owner_name : nom de l'auteur du contenu initial
        if ($owner->name) { $owner_name = $owner->name; } else { $owner_name =""; } // Owner du sujet (owner de l'objet notifié - pas des commentaires)
        if ($object->getOwner()) { $owner_guid = $object->getOwner(); } else { $owner_guid = NULL; }
        // $container_guid : GUID du 'container' de l'objet notifié (site, group, user)
        $container_guid = $object->container_guid;  // @TODO : filtrer si pas groupe ni user pour éviter de l'afficher
        // $container : 'container' de l'objet notifié (site, group, user)
        $container = get_entity($container_guid);
        // $container_name : nom en clair du 'container'
        if ($object->container_guid) { $container_name = $container->name; } else { $container_name = ""; }
        // Distinction entre contexte de groupe ou en dehors (perso)
        $translate_owner = "";
        if ($container->getType() == 'group' && ($event == 'create') ) {
          if ($container->name) { $owner_name = "le groupe " . $container->name; } else { $owner_name =""; } // Owner différencié ssi groupe (user aussi ?)
          $translate_owner = ":group";
        }
        
        // @TODO Cas particuliers : thewire (jamais groupe), groupforumtopic (toujours groupe), messages (@todo envoyé par groupe ou pas ?)
        
        // $description : contenu ajouté ou modifié (contenu de l'annotation dans certains cas : event annotate, tous types d'event groupforumtopic et page)
        //$descr = $CONFIG->register_objects[$object_type][$object_subtype];  // UNUSED - The default string for notification title (static string, one per object)
        $description = "";
        if ($object->description) { $description = $object->description; }  // description : on teste les valeurs tant qu'on n'a pas obtenu un contenu pertinent
        if (empty($description)) $description = $object->content;
        if (empty($description)) $description = $object->value;
        if (empty($description)) $description = $object->briefdescription;
        if (empty($description)) $description = $object->msg;
        if (empty($description)) $description = get_input('topicmessage');
        if (empty($description)) $description = get_input('topic_post');
        
        // CAS PARTICULIERS : event 'annotate', et tous types d'event sur 'groupforumtopic' et 'page' => contenu de l'annotation au lieu de la description
        
        // On prend plutôt commentaire, réponse à un sujet de forum, ou modification d'une page wiki
        //  Comment exception / Cas particulier des commentaires
        if ($event == "annotate") {
          $latestcomment = $object->getAnnotations('generic_comment', 1, 0, 'desc'); // dernier commentaire
          // S'il existe une annotation, la dernière est le dernier commentaire, sinon on conserve la description
          if ($latestcomment) {
            $lastcomment = $latestcomment[0]->value;
            // Description abrégée et "nettoyée" plutôt que le contenu complet (logique de teaser)
            $short = cut_string(strip_tags($lastcomment, $shortfilter), 1500, $needle);
            if ($short[1]) $lastcomment = closetags($short[0]) . sprintf(elgg_echo('notification_messages:readmore'), $content_link);
            else $lastcomment = closetags($short[0]);
            // On intègre aussi un (plus petit) bout du contenu commenté
            $short = cut_string(strip_tags($description, $extractfilter), 500, $needle);
            if ($short[1]) $description = closetags($short[0]) . ' [...]'; else $description = closetags($short[0]);
            $description = $lastcomment . sprintf(elgg_echo('notification_messages:wrapper:originalpost'), $description);
          }
        }
        
        // Groupforumtopic exception / Cas particulier : sujets de forums et réponses
        if ($object_subtype == 'groupforumtopic') {
          // @TODO : les updates ne s'appliquent pas au groupforumtopic : voir avec l'update de l'annotation qui peut être utilisé pour notifier à la place
          // Description abrégée et "nettoyée" plutôt que le contenu complet (logique de teaser)
          // Note : La dernière réponse est dans la description
          $short = cut_string(strip_tags($description, $shortfilter), 1500, $needle);
          if ($short[1]) $lastforum = closetags($short[0]) . sprintf(elgg_echo('notification_messages:readmore'), $content_link);
          else $lastforum = closetags($short[0]);
          // On récupère le sujet initial + un autre pour distinguer le sujet d'une réponse
          $initialforum = $object->getAnnotations('group_topic_post', 2, 0, 'asc'); // première réponse (= contenu du sujet)
          // S'il n'y a qu'une seule annotation, on ne notifie pas en plus en tant que réponse (doublon car création déjà notifiée)
          if ((count($initialforum) == 1) && ($event == 'annotate')) return true;
          // Mise en forme du sujet initial
          if ($initialforum) {
            $firstforum = $initialforum[0]->value;
            // Extrait du contenu initial plutôt que le contenu complet (logique de teaser)
            $short = cut_string(strip_tags($firstforum, $extractfilter), 500, $needle);
            if ($short[1]) $firstforum = closetags($short[0]) . ' [...]'; else $firstforum = closetags($short[0]);
            $firstforum = sprintf(elgg_echo('notification_messages:wrapper:firstforum'), $firstforum);
          }
          // On récupère la réponse précédente
          $precedingforum = $object->getAnnotations('group_topic_post', 1, 0, 'desc'); // dernière réponse au sujet, ou contenu du sujet
          // Mise en forme de la réponse précédente
          if ($precedingforum && ($initialforum[0]->id != $precedingforum[0]->id)) {
            $previousforum = $precedingforum[0]->value;
            // Extrait plutôt que le contenu complet (logique de teaser)
            $short = cut_string(strip_tags($previousforum, $extractfilter), 500, $needle);
            if ($short[1]) $previousforum = closetags($short[0]) . ' [...]'; else $previousforum = closetags($short[0]);
            $previousforum = sprintf(elgg_echo('notification_messages:wrapper:firstforum'), $previousforum);
          }
          // On intègre le tout selon ce qu'on a
          $description = $previousforum . $firstforum;
          if (!empty($description)) {
            $description = $lastforum . '<br />' . $description;
          } else $description = $lastforum;
        }
        
        // Pages exception / Cas particulier des modfications des pages wiki
        if ((($object_subtype == 'page') || ($object_subtype == 'page_top')) && ($event != "annotate")) {
          // Note : La dernière réponse est dans la description
          // Description abrégée et "nettoyée" plutôt que le contenu complet (logique de teaser)
          $short = cut_string(strip_tags($description, $shortfilter), 1500, $needle);
          if ($short[1]) $lastpage = closetags($short[0]) . sprintf(elgg_echo('notification_messages:readmore'), $content_link);
          else $lastpage = closetags($short[0]);
          $precedingpage = $object->getAnnotations('page', 1, 0, 'desc'); // nouvelle version d'une page wiki
          // S'il existe une annotation, la dernière est la description actuelle, sinon on conserve la description (précédent contenu)
          if ($precedingpage) {
            $previouspage = $precedingpage[0]->value;
            // Description abrégée et "nettoyée" plutôt que le contenu complet (logique de teaser)
            $short = cut_string(strip_tags($previouspage, $extractfilter), 500, $needle);
            if ($short[1]) $previouspage = closetags($short[0]) . sprintf(elgg_echo('notification_messages:readmore'), $content_link);
            else $previouspage = closetags($short[0]);
            $description .= sprintf(elgg_echo('notification_messages:wrapper:firstforum'), $previousforum);
          }
          /*
          // Comparaison des deux versions et affichage des différences, à la manière de 'diff'
          // Rendu plus user-friendly mais encore trop peu lisible pour un bon rendu par mail
          /*
          require_once('includes/version_changes.php');
          $description .= '<br />' . PHPDiff($previouspage,$lastpage,"html"); // Render as : diff (default), clean (text), html (HTML)
          */
        }
        
        // Bookmarks exception / Cas particulier des liens des marque-pages
        if ($object_subtype == 'bookmarks') {
          // $bookmark_link : lien vers le marque-page (address)
          $bookmark_link = $object->address;
        }
        
        // File exception / Cas particulier des liens de téléchargement direct des fichiers
        if ($object_subtype == 'file') {
          // $download_link : lien de téléchargement direct du fichier
          $download_link = $CONFIG->url . 'action/file/download?file_guid=' . $object_guid;
        }
        
        // Pages update exception / Cas particulier des annoatations des pages wiki (commentaires vs modifications)
        // * gérées via le filtrage des notifications sur les annotations, car on peut s'y appuyer sur annotation->name et différencier les types d'annoations
        
        
        // Description abrégée et "nettoyée" plutôt que le contenu complet (logique de teaser)
        // On différencie selon ce qu'on a comme $description : cas particuliers ou contenu brut
        if ( ($event == "annotate")
          || ($object_subtype == 'groupforumtopic')
          || ((($object_subtype == 'page') || ($object_subtype == 'page_top')) && ($event != "annotate"))
          ) {
          // On n'abrège pas le contenu géré via les cas particuliers (car sinon on taille dans le HTML final)
          // Transformation des URL relatives en URL absolues
          $description = str_replace('href="/', 'href="' . $CONFIG->url . '/', $description);
          // Emballage du message
          $description = sprintf(elgg_echo('notification_messages:wrapper:content'), $description);
        } else {
          // On conserve un peu de contenu et de mise en forme
          $short = cut_string(strip_tags($description, $shortfilter), 1500, $needle);
          if ($short[1]) $description = closetags($short[0]) . sprintf(elgg_echo('notification_messages:readmore'), $content_link);
          else $description = closetags($short[0]);
          // Transformation des URL relatives en URL absolues
          $description = str_replace('href="/', 'href="' . $CONFIG->url . '/', $description);
          // Emballage du message
          $description = sprintf(elgg_echo('notification_messages:wrapper:content'), $description);
        }
        
        // Messages exception / Cas particulier : messages
        // Expéditeur du message
        if ($object->fromId) { $sender = $object->fromId; } else { $sender = ""; }  // Auteur du message
        // Titre du contenu (objet notifié, ou objet parent si commentaire, forum, page)
        if ($object->title) { $title = $object->title; } else { $title = ""; }  // Titre du message
        
        // Autres infos utiles pour la notification
        if ($CONFIG->sitename) { $sitename = $CONFIG->sitename; } else { $sitename = ""; }  // Nom du site
        if ($CONFIG->url) { $site_url = $CONFIG->url; } else { $site_url = ""; }  // URL du site (racine)
        
        
        // Some vars used to avoid duplicates (@todo : check if it's really needed - should be removed if code is OK)
        $usedmethods = array();
        $notifiedusers = array();
        $valid_emails = null;
        $debug = null;
        
        
        // Get interested users for this content (group or user interest relationship) and notify them
        // (Subscribed "person" is defined by container_guid so we can also subscribe to groups if we want)
        // Methods 'foreach' : email, site, sms
        foreach($NOTIFICATION_HANDLERS as $method => $foo) {
          $interested_users = null;
          $valid_notifiedusers = null;
          set_time_limit(30); // Définit, mais surtout réinitialise la durée maximale d'éxécution du script (secondes)
          if (in_array($method, $usedmethods)) { continue; } $usedmethods[] = $method; /* Dédoublonnage des méthodes de notification */
          // compatible multisite
          // Do we have interested users ? if not, don't bother and skip
          $count_interested_users = get_entities_from_relationship('notify' . $method,$container_guid,true,'user','',0,'',9999, 0, true, -1);
          if ($count_interested_users > 0) {
            // Now we can get the actual interested users (entities)
            $interested_users = get_entities_from_relationship('notify' . $method,$container_guid,true,'user','',0,'',9999, 0, false, -1);
            
            
            // T1 : BUILD RECIPIENT ARRAY / on constitue l'array des destinataires valables pour cette méthode
            // Note : On ne différencie plus les messages, ce qui permet de notifier via un array de GUID ou d'adresses mail plutôt qu'un après l'autre
            foreach($interested_users as $user) {
              /* Dédoublonnage des destinataires (pour chaque méthode) */
              $usermethod = $method . $user->guid;
              if (in_array($usermethod, $notifiedusers)) {
                $debug .= "Doublon : $usermethod\n";
                continue;
              }
              $notifiedusers[] = $usermethod;
              
              // Constitution de la liste utilisable des users à notifier pour cette méthode
              // Vérification des accès au contenu : on ne notifie pas les users bannis (peu importe les non validés car pas encore abonnés aux notifications)
              if ( ($user instanceof ElggUser) && (!$user->isBanned()) ) {
              /* IMPORTANT : has_access_to_entity defaults to loggedin user, which may result in serious information leaks if access rights are not carefully checked */
              // @todo Settings : Self notify ? / S'envoyer un message à soi-même ?
              // $notify_self = true;
                if (($user->guid != $SESSION['user']->guid) && has_access_to_entity($object,$user) && ($object->access_id != ACCESS_PRIVATE)) {
                  if ($method != 'email') {
                    $valid_notifiedusers[] = $user->guid;
                  } else {
                    if(!empty($user->email)) $valid_emails[] = $user->email;
                  }
                }
              }
            }
            
            
            // T2 : BUILD MESSAGE / on construit le message : pas de personnalisation dans le titre
            // Clear the message strings to avoid duplicates or unwanted leaks
            $subject = null; $method_message = null; $msg_url = null; $reply_url = null;
            // Anonymisation des messages (pas de personnalisation avec le nom de destinataire)
            $username = ""; $name = "";
            
            // Multisite : Build messages URL depending on multisite messages use or not (used only for messages)
            $msg_url = ""; $reply_url = "";
            if ($object_subtype == 'messages') {
              if (is_plugin_enabled('multimsg')) { $msg_plugin = 'multimsg'; } else {  $msg_plugin = 'messages'; }
              $msg_url = $site_url . "pg/$msg_plugin/";
              $reply_url = $site_url . "mod/$msg_plugin/send.php?send_to=$sender";
            }
            
            // Select translation string depending on notification method
            switch($method) {
               case 'sms': $translate_method = "sms:"; break;
               case 'site': $translate_method = "site:"; break;
              // Default notification and email are the same
               case 'email':
               default:
                $translate_method = "";
                break;
            }

            /* Differentiate messages depending on : event, subtype, method, and whether it's in a group or not
              Syntaxe : notification_messages: SUBTYPE : EVENT : (METHOD:) OTHER (:GROUP)
              Principe d'ordre des variables dans les sprintf à normaliser : du primordial et générique à l'accessoire
              Pour passer le nom "officiel" de l'objet dans les traductions du système => elgg_echo("item:object:$object_subtype")
            * @ Guidelines for differentiated messages
            * Default values : use the object_subtypes switches ONLY to handle special types (modify default values, eg. messages, or disallow notification..).
            * Default values can be used safely, as they default to smthg meaningful if supplied types are not handled
            * object_subtypes defaults to "default"
            * event doesn't defaults, but there are only 3 types : create, update, annotate
            * translate_method defaults to (empty)
            * translate_owner defaults to (empty)
            */
            
            /* CREATE EVENT / CREATION D'UN CONTENU */
            if ($event == "create") {
              $subject_key = 'notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'subject' . $translate_owner;
              $subject = sprintf(elgg_echo($subject_key), $title, $editor, $container_name, $owner_name);
              $method_key = 'notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'message' . $translate_owner;
              $method_message = sprintf(elgg_echo($method_key), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
              
              switch($object_subtype) {
                case 'blog': break;
                case 'bookmarks':
                  $method_message = sprintf(elgg_echo($method_key), $content_link, $title, $name, $container_name, $editor, $description, $owner_name, $bookmark_link);
                  break;
                case 'event_calendar': break;
                case 'file':
                  $method_message = sprintf(elgg_echo($method_key), $content_link, $title, $name, $container_name, $editor, $description, $owner_name, $download_link);
                  break;
                case "izap_videos": break;
                case 'multipublisher': break;
                case 'multipublisher_comment': break;
                // Page et page_top : mêmes paramétrages - contenu dans une annotation
                case 'page_top':
                case 'page':
                  break;
                // The Wire : Jamais dans un groupe
                case 'thewire':
                  $subject = sprintf(elgg_echo('notification_messages:thewire:create:' . $translate_method . 'subject'), $title, $editor);
                  $method_message = sprintf(elgg_echo('notification_messages:thewire:create:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
                  break;
                // Messages : Peuvent être envoyés par un groupe (mais groupe pas owner ?)
                case 'messages':
                  $subject = sprintf(elgg_echo('notification_messages:messages:create:' . $translate_method . 'subject'), $title, $editor);
                  $method_message = sprintf(elgg_echo('notification_messages:messages:create:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $sender, $sitename, $msg_url, $reply_url, $owner_name);
                  break;
                // Groupforumtopic : Forcément dans un groupe - contenu dans annotation de type group_topic_post
                case "groupforumtopic":
                  $subject = sprintf(elgg_echo('notification_messages:groupforumtopic:create:' . $translate_method . 'subject'), $title, $editor, $container_name, $owner_name);
                  $method_message = sprintf(elgg_echo('notification_messages:groupforumtopic:create:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
                  break;
                // Default is already handled before, and overrided for some specific subtypes
                default: break;
              }
            }

            /* UPDATE EVENT / MISE A JOUR D'UN CONTENU - PAS OK A CE STADE : envoi de la valeur précédente */
            if ($event == "update") {
              //return false; // Méthode radicale pour utiliser les notifications standard (aucun intérêt..)
              //$description = ""; // We want to check that every notification has the right content before enabling this by default - @todo : find how to get the current content and not the former !
              $subject = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'subject' . $translate_owner), $title, $editor, $container_name, $owner_name);
              $method_message = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'message' . $translate_owner), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
              
              switch($object_subtype) {
                case 'blog': break;
                case 'bookmarks':
                  $method_message = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'message' . $translate_owner), $content_link, $title, $name, $container_name, $editor, $description, $owner_name, $bookmark_link);
                  break;
                case 'event_calendar': break;
                case 'file':
                  $method_message = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'message' . $translate_owner), $content_link, $title, $name, $container_name, $editor, $description, $owner_name, $download_link);
                  break;
                case "izap_videos": break;
                case 'multipublisher': break;
                case 'multipublisher_comment': break;
                // Page et page_top : mêmes paramétrages - contenu dans une annotation
                case 'page_top':
                case 'page':
                  break;
                // The Wire : Jamais dans un groupe
                case 'thewire':
                  $subject = sprintf(elgg_echo('notification_messages:thewire:update:' . $translate_method . 'subject'), $title, $editor);
                  $method_message = sprintf(elgg_echo('notification_messages:thewire:update:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
                  break;
                // Messages : Peuvent être envoyés par un groupe (mais groupe pas owner ?)
                case 'messages':
                  $subject = sprintf(elgg_echo('notification_messages:messages:update:' . $translate_method . 'subject'), $title, $editor);
                  $method_message = sprintf(elgg_echo('notification_messages:messages:update:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $sender, $sitename, $msg_url, $reply_url, $owner_name);
                  break;
                // Groupforumtopic : Forcément dans un groupe - contenu dans annotation de type group_topic_post
                case "groupforumtopic":
                  $subject = sprintf(elgg_echo('notification_messages:groupforumtopic:update:' . $translate_method . 'subject'), $title, $editor, $container_name, $owner_name);
                  $method_message = sprintf(elgg_echo('notification_messages:groupforumtopic:update:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
                  break;
                // Default is already handled before, and overrided for some specific subtypes
                default: break;
              }
            }

            /* ANNOTATE EVENT / COMMENTAIRE SUR UN CONTENU - OK sur tous types y compris pages et forums */
            if ($event == "annotate") {
              $subject = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'subject' . $translate_owner), $title, $editor, $container_name, $owner_name);
              $method_message = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'message' . $translate_owner), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
              
              switch($object_subtype) {
                case 'blog': break;
                case 'bookmarks':
                  $method_message = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'message' . $translate_owner), $content_link, $title, $name, $container_name, $editor, $description, $owner_name, $bookmark_link);
                  break;
                case 'event_calendar': break;
                case 'file':
                  $method_message = sprintf(elgg_echo('notification_messages:' . $object_subtype . ':' . $event . ':' . $translate_method . 'message' . $translate_owner), $content_link, $title, $name, $container_name, $editor, $description, $owner_name, $download_link);
                  break;
                case "izap_videos": break;
                case 'multipublisher': break;
                case 'multipublisher_comment': break;
                // Page et page_top : mêmes paramétrages - contenu dans une annotation
                case 'page_top':
                case 'page':
                  break;
                // The Wire : Jamais dans un groupe
                case 'thewire':
                  $subject = sprintf(elgg_echo('notification_messages:thewire:annotate:' . $translate_method . 'subject'), $title, $editor);
                  $method_message = sprintf(elgg_echo('notification_messages:thewire:annotate:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
                  break;
                // Messages : Peuvent être envoyés par un groupe (mais groupe pas owner ?)
                case 'messages':
                  $subject = sprintf(elgg_echo('notification_messages:messages:annotate:' . $translate_method . 'subject'), $title, $editor);
                  $method_message = sprintf(elgg_echo('notification_messages:messages:annotate:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $sender, $sitename, $msg_url, $reply_url, $owner_name);
                  break;
                // Groupforumtopic : Forcément dans un groupe - contenu dans annotation de type group_topic_post
                case "groupforumtopic":
                  $subject = sprintf(elgg_echo('notification_messages:groupforumtopic:annotate:' . $translate_method . 'subject'), $title, $editor, $container_name, $owner_name);
                  $method_message = sprintf(elgg_echo('notification_messages:groupforumtopic:annotate:' . $translate_method . 'message'), $content_link, $title, $name, $container_name, $editor, $description, $owner_name);
                  break;
                // Default is already handled before, and overrided for some specific subtypes
                default: break;
              }
            }
            
            
            // T3 : NOTIFY USERS / on envoie via notify_user avec un array
            /* DEBUG MODE : uncomment to load data in $debug - this will be notified to admin (GUID 2), depending on admin settings */
            /*
            $debug .= "\nFonctions appelantes :\n";
            $traces = debug_backtrace();
            $i = 0;
            foreach ($traces as $trace) {
              $debug .= "\n" . $trace['function'] . " [$i]";
              $i++;
            }
            $debug .= "\n";
            \nobject_subtype : $object_subtype
            \n event : $event
            \n content_link $content_link 
            \n editor $editor 
            \n name : $name 
            \n method : $method
            \n translate_method : $translate_method 
            \n translate_owner : $translate_owner 
            \n sender : $sender
            \n sitename : $sitename
            \n msg_url : $msg_url
            \n reply_url : $reply_url
            \n object->msg : ".$object->msg."
            \n topicmessage : ".get_input('topicmessage')."
            \n topic_post : ".get_input('topic_post')." 
            \n object_subtype : $object_subtype
            \n title : $title 
            \n container_name : $container_name 
            \n owner_name : $owner_name 
            \n lastcomment : $lastcomment 
            \n description : ".$object->description."
            \n\n";
            */

            // @debug : Following $eventype may be used to explicitly tell which action was performed in the subject
            // $eventtype = sprintf(elgg_echo('notification_messages:events:update'), $object_subtype);
            $eventtype = "";
            $subject = sprintf(elgg_echo('notification_messages:subject:' . $translate_method  . 'wrapper'), $subject);
            
            // @todo : n'envoyer qu'un résumé, et sans tout le HTML qui ne peut pas être correctement traité (cf. images dans les mails, url à remplacer, etc.)
            //$method_message = str_replace(array("\r\n", "\n", "\r"), "<br />", closetags($short[0]));
            //$method_message = str_replace(array("<br /><br /><br /><br />", "<br /><br /><br />"), "<br />", $method_message);
            $method_message = sprintf(elgg_echo('notification_messages:message:' . $translate_method . 'wrapper'), $method_message, $name, $sitename, $CONFIG->site->url);
            
            // SEND NOTIFICATION / Envoi effectif du message
            // Envoi par toute autre méthode qu'email (y compris default : contenu du message identique au mail mais envoyé via le système standard d'Elgg)
            if ($method != 'email') {
              //notify_user($valid_notifiedusers, $container_guid, $subject, $method_message, NULL, array($method));
              // Note : on utilise au final le handler géré par "messages", donc autant l'utiliser en direct. @todo : ça reste très long !
              $methods = array($method);
              $count_valid_notifiedusers = count($valid_notifiedusers);
              if ($count_valid_notifiedusers > 0) {
                foreach ($valid_notifiedusers as $guid) {
                  set_time_limit(5); // Définit, mais surtout réinitialise la durée maximale d'éxécution du script (secondes)
                  // @DOC : messages_send ($subject, $body, $send_to, $from=0, $reply=0, $notify=true, $add_to_sent=true)
                  // Note : don't notify twice, don't add to sent messages (no meaning here)
                  messages_send($subject,$method_message,$guid,$container_guid,0,false,false);
                }
              }
            // Email notification / Envoi par email exclusivement
            } else {
              $count_valid_emails = count($valid_emails);
              // Don't notify nor display system message if there is no mail address to be notified
              if ($count_valid_emails > 0) {
                //-----------------------------------------------
                // CONFIG DU MAIL
                //-----------------------------------------------
                $recipient = implode(',', $valid_emails);
                $email_reply = $CONFIG->site->email;
                // Si mail du site non renseigné, l'envoi est fait par le premier admin du site (GUID 2)
                if (empty($email_reply)) $email_reply = get_entity(2)->email;
                $sender = "Notifications " . $CONFIG->site->name . " <$email_reply>";
                //$replyto = "Contact " . $CONFIG->site->name . " <$email_reply>";
                $replyto = "NE PAS REPONDRE PAR MAIL <$email_reply>";
                //-----------------------------------------------
                // HEADERS DU MAIL
                //-----------------------------------------------
                $headers = "From: $sender\r\n";
                $headers .= "Reply-To: $replyto\r\n";
                // $headers .= "CC:: \r\n";
                // $headers .= "X-Priority:: \r\n"; // De 1(max) à 5(min)
                $headers .= "BCC: $recipient\r\n";
                $headers .= "Return-Path: <$email_reply>\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                //$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
                $headers .= "Content-Type: text/html; charset=\"utf-8\"\r\n";
                $headers .= "Content-Transfer-Encoding: 8bit\r\n";
                //-----------------------------------------------
                // MESSAGE HTML
                //-----------------------------------------------
                $method_message .= "\r\n";
                // Remplacement des destinataires réels par une adresse $replyto de type no-reply (tous mis plus haut en copie cachée BCC)
                //$recipient = $email_reply;
                // Facyla 20110731 : attention car on n'a pas à notifier à une adresse collective, d'où :
                // Remplacement des destinataires réels par une adresse vide (destinataires réels en copie cachée BCC), ssi plus d'un seul (OK en direct)
                // Note : doit être soit une adresse valide soit une chaine vide :
                // "<>" ou "test <>" ne marchent pas, et "undisclosed" devient undisclosed@server_real_address (mail inexistant)
                if ($count_valid_emails > 1) { $recipient = ""; }
                //-----------------------------------------------
                // ENVOI DU MESSAGE
                //-----------------------------------------------
                /* METHODE D'ENVOI AVEC html_mails - deprecated as we format the mail content directly in here
                foreach ($interested_users as $to) { html_mails_notify_handler($container, $to, $subject, $method_message); }
                */
                // Facyla : Permet d'avoir des retours à la ligne corrects
                $subject = preg_replace("/(\r\n|\r|\n)/", "", $subject); // Strip line endings
                if (mail($recipient, $subject, $method_message, $headers)) {
                  $status = sprintf(elgg_echo('notification_messages:send:success'), $count_valid_emails, $count_valid_notifiedusers);
                } else {
                  $status = elgg_echo('notification_messages:send:error');
                }
                // Tells the user if notifications were effectively sent
                system_message($status);
              }
            } // Regular or email notification
          } // No subscription : skip / Si personne intéressé, on passe
        } // END foreach method ($NOTIFICATION_HANDLERS as $method => $foo)
      }
      
      // Debug mode : Use admin settings to determine if we use this or not
      // More controls : don't bother when no one was to be notified
      if ($debugmode && (($count_valid_emails > 0) || ($valid_notifiedusers > 0)) ) {
        $time = microtime(true)-$t1;
        $mstime = substr(1000*$time,0,6);
        $debugsubject = sprintf(elgg_echo('notification_messages:wrapper:debugsubject'), $count_valid_emails, $mstime, $count_valid_notifiedusers);
        if ($debug) $debug .= "\n\n";
        $debugmessage = sprintf(elgg_echo('notification_messages:wrapper:debugmessage'), $debugsubject, implode(', ',$valid_emails), implode(', ',$valid_notifiedusers), $CONFIG->site->url, $debug, $event.' '.$object_subtype.' ('.$object_guid.') : '.$content_link);
        // Debug mail(s) / Mail de debug pour les destinataires choisis, ou l'admin principal (GUID 2) à défaut
        $debugmails = trim(get_plugin_setting('debugmails'));
        if (empty($debugmails)) $debugmails = get_entity(2)->email;
        $debugthreshold = trim(get_plugin_setting('debugthreshold'));
        if (empty($debugthreshold)) $debugthreshold = 0;
        // Only if more time than set threshold
        if ($time > $debugthreshold) { mail($debugmails, $debugsubject, $debugmessage, ''); }
      }
      
      // True signale que le hook a fonctionné correctement, sinon on envoie en doublon avec l'ancien système
      return true;
      
    } else {
      /* Selon le paramétrage $hookreturnvalue : 
       * true = ne notifie pas avec la fonction de notification d'elgg par défaut lorsque le type de contenu est intercepté 
       * mais pas pris en charge (par ex. les messages envoyés suite aux notifications) ;
       * false = on notifie avec la notification par défaut ;
       * null = on reçoit aussi des mails adressés à d'autres.
      */
      return $hookreturnvalue;
    }
  }
}



/*
 * Cuts any string at the given $needle string, within a $max length
 * @version 20110519
 * @author Facyla
 * @param string : the string to shorten
 * @param max : max return length
 * @param needle : optional string, where to cut
 * @param include : optional boolean, include needle in returned string ?
 * @return : (array) short string + cut string
*/
/*
if (!function_exists('cut_string')) {
  function cut_string($string, $max, $needle = ". ", $include = true) {
    if (strlen($string) >= $max) {
      $shortstring = substr($string, 0, $max);
      //$pos = strrpos($shortstring, $needle) + 1;
      $pos = ($include) ? strrpos($shortstring, $needle) +strlen($needle) : strrpos($shortstring, $needle);
      $shortstring = substr($shortstring, 0, $pos);
      $newstring = substr($string, $pos);
    } else { $shortstring = $string; }
    return array($shortstring, $newstring);
  }
}
*/
if (!function_exists('cut_string') && !is_plugin_enabled('formavia')) {
  /*
   * Cuts any string at the given $needle string, within a $max length
   * @version 20110519
   * @author Facyla
   * @param string : the string to shorten
   * @param max : max return length
   * @param needle : optional string, where to cut
   * @param include : optional boolean, should returned string include needle ?
   * @param include : optional boolean, should returned HTML string be properly closed ? - closed by default
   * @return : (array) short string + cut string
   *
   * Note : used also in formavia plugin
  */
  function cut_string($string, $max, $needle = ". ", $include = true, $autoclose = false) {
    if (strlen($string) >= $max) {
      $shortstring = substr($string, 0, $max) ;
      $pos = ($include) ? strrpos($shortstring, $needle) +strlen($needle) : strrpos($shortstring, $needle);
      $shortstring = substr($shortstring, 0, $pos);
      $newstring = substr($string, $pos);
    } else $shortstring = $string;
    if ($autoclose  && !empty($shortstring)) { $shortstring = autoclose($shortstring); }
    return array($shortstring, $newstring);
  }
}


/* Closes HTML tags using DOM parser */
// Pour fermer correctement les tags HTML
if (!function_exists('autoclose') && !is_plugin_enabled('formavia')) {
  function autoclose($string) {
    if (!empty($string)) {
      //$doc = new DOMDocument();
      $doc = new DOMDocument('1.0', 'UTF-8');
      //$doc->loadHTML($shortstring);
      $doc->loadHTML(utf8_decode($string)); // correction pbs d'accentuation
      $string = $doc->saveHTML();
      $string = substr($string, 122, -19); // Supprime les <DOCTYPE...<html><body> et </body></html> ajoutés lors du parsing..
    }
    return $string;
  }
}


/**
 * close all open xhtml tags at the end of the string
 * @param string $html
 * @return string
 * @author Milian Wolff <mail@milianw.de>
 * @patches by Facyla based on thread discussion http://milianw.de/code-snippets/close-html-tags
 */
function closetags($html) {
/*
  #put all opened tags into an array
  preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
  $openedtags = $result[1];
  
  #put all closed tags into an array
  preg_match_all('#</([a-z]+)>#iU', $html, $result);
  $closedtags = $result[1];
  $len_opened = count($openedtags);
  # all tags are closed
  if (count($closedtags) == $len_opened) { return $html; }
  
  $openedtags = array_reverse($openedtags);
  # close tags
  for ($i=0; $i < $len_opened; $i++) {
    $openedtags[$i] = strtolower($openedtags[$i]);
    if (!in_array($openedtags[$i], $closedtags)){
      $next_tag = (($i + 1) < count($openedtags) ? strtolower($openedtags[$i+1]) : null);
      if ($next_tag && !in_array($next_tag, $arr_single_tags)) {
        $html = preg_replace('#</'.$next_tag.'#iU','</'.$openedtags[$i].'></'.$next_tag,$html);
      } else {
        $html .= '</'.$openedtags[$i].'>';
      }
    } else {
      unset($closedtags[array_search($openedtags[$i], $closedtags)]);
    }
  }
  return $html;
*/
  $shortfilter = elgg_echo('notification_messages:settings:shortfilter'); // Générique : le plus large/inclusif
  return strip_tags($html, $shortfilter);
}



// Load at the end, as this plugin may override some behaviours, and we don't want to be overrided
register_elgg_event_handler('init','system','notificationmessages_init', 1000);
