<?php
global $CONFIG;
$ent = $vars['entity'];

//if ($ent instanceof ElggObject) {
if ($ent instanceof ElggEntity) {
  
  $acturl = $CONFIG->url . 'mod/pin/actions/';
  $imgurl = $CONFIG->url . 'mod/pin/graphics/';
  $ts = time();
  $token = generate_action_token(time());
  $tokens = '&__elgg_ts='.$ts.'&__elgg_token='.$token;
  $body = '';
  $ownguid = $_SESSION['user']->guid;
  
  // Use to get back to same page
  $_SESSION['last_forward_from'] = current_page_url();
  
  // Check plugin settings
  $extendfullonly  = get_plugin_setting('extendfullonly ', 'pin');
  if ($extendfullonly  != 'no') $extendfullonly = true; else $extendfullonly  = false; 
  $usehighlight = get_plugin_setting('highlight', 'pin');
  if ($usehighlight == 'yes') $usehighlight = true; else $usehighlight = false;
  $usememorize = get_plugin_setting('memorize', 'pin');
  if ($usememorize == 'yes') $usememorize = true; else $usememorize = false;
  $usefootprint = get_plugin_setting('footprint', 'pin');
  if ($usefootprint == 'yes') $usefootprint = true; else $usefootprint = false;
  
  // Exceptions : manually disable some types that are not handled in a normalized way
  if ($ent->getSubtype() == 'groupforumtopic') $usefootprint = false; // partly handled via forum/viewposts - but appears only if answers..
  if ($ent->getSubtype() == 'thewire') {
    $usememorize = false;
    $usefootprint = false;
  }
  
  // @todo : ajaxify actions
  
  
  if ($usehighlight) {
    // Highlight - admin or moderator selected content
    /* Mise en valeur d'un contenu :
     * (int) or (array) highlight : (true or value or array of values) / (false or null)
     * usage plutôt admin, collectif, 
     * valeur attachée au contenu
     * valeur peut être signifiante :
        - déterminer qui a mis en valeur (user, groupadmin, localadmin, admin) 
        - et dans quel contexte (groupe, site, multisite)
        - forme : array( usertype or GUID => highlightcontext) ?
     */
    // Qui a le droit de mettre des contenus en avant ?
    if ( isadminloggedin() 
  //    || // ou si le container du contenu est un groupe et que l'user en est l'owner
      ) { $highlightaccess = true; } else { $highlightaccess = false; }
    
    if (empty($ent->highlight)) {
      if ($highlightaccess) $body .= '<a href="'.$acturl.'highlight.php?guid='.$ent->guid.$tokens.'" class="tooltips-s" alt="highlight" title="'.elgg_echo('pin:highlight:true').'"><img src="'.$imgurl.'pin_add.png" /></a>';
    } else {
      $body .= elgg_echo('pin:highlighted');
      if ($highlightaccess) {
        switch ($ent->highlight) {
          case 'admin':
          default:
            $body .= ' <a href="'.$acturl.'highlight.php?guid='.$ent->guid.$tokens.'" class="tooltips-s" alt="un-highlight" title="'.elgg_echo('pin:highlight:false').'"><img src="'.$imgurl.'pin_remove.png" /></a>';
        }
      }
    }
    $body .= ' - ';
  }
  
  
  if ($usememorize) {
    // Memorize - personal content list
    /* Mémorisation d'un contenu : contenus volontairement conservés
     * usage personnel, voire du groupe
     * valeur attachée à .. ? contenu ? user ?
     */
    if (isloggedin()) {
      $memorized = false;
      // S'il existe des éléments déjà mémorisés
      if ($_SESSION['user']->memorized) {
        $memorized = explode(';', $_SESSION['user']->memorized);
        // Si cette page est déjà mémorisée
        if (in_array($ent->guid, $memorized)) {
          $body .= elgg_echo('pin:memorized');
          $body .= '<a href="'.$acturl.'memorize.php?action=unmemorize&guid='.$ent->guid.$tokens.'" class="tooltips-s" alt="un-memorize" title="'.elgg_echo('pin:memorize:false').'"><img src="'.$imgurl.'favorite_remove.png" /></a>&nbsp;';
        // Sinon on signale qu'elle n'est pas mémorisée pour avoir le bon lien
        } else {
          $memorized = false;
        }
      }
      if (!$memorized) {
        // Si page non mémorisée
        $body .= '<a href="'.$acturl.'memorize.php?action=memorize&guid='.$ent->guid.$tokens.'" class="tooltips-s" alt="memorize" title="'.elgg_echo('pin:memorize:true').'"><img src="'.$imgurl.'favorite_add.png" /></a>&nbsp;';
      }
    }
  }
  
  
  if ($usefootprint) {
    // Footprint - how many people did see this for the first time, and when
    /* Trace d'un contenu : (array) 'footprint'
     * (array) footprint : user GUID => first timestamp
     * trace conservée seulement si en mode "full"
     * valeur attachée au contenu
     * mémorisation implicite dès lors qu'on a accédé au contenu
     * Correspond également à la fonction "hit" : nb de vues uniques
     */
    if ($vars['full']) {
      if (empty($ent->footprint)) {
        $legend = elgg_echo('pin:footprint:first') . ' ';
        // On ajoute le guid courant à ->footprint si on connait l'user
        if (isloggedin()) $ent->footprint = serialize(array(''.$ownguid => time()));
        // Sinon on compte le nombre d'affichages publics
        else $ent->footprint = serialize(array('0' => 1));
      } else {
        // Lecture du contenu
        $footprint = unserialize($ent->footprint);
        $numreaders = sizeof($footprint);
        if (isset($footprint['0'])) {
          $pubreaders = $footprint['0'];
          $numreaders--; // Retire 1 lecteur (= compteur hits publics)
        }
        $legend = sprintf(elgg_echo('pin:footprint:readers'), $numreaders);
        if ($pubreaders) $legend .= sprintf(elgg_echo('pin:footprint:pubreaders'), $pubreaders);
        if (isloggedin()) {
          // Ssi GUID pas encore listé
          $legend .= ' - ';
          if (!isset($footprint[''.$ownguid])) {
            $legend .= elgg_echo('pin:footprint:new') . ' ';
            // On ajoute le guid courant à ->footprint
            $footprint[''.$ownguid] = time();
            $fp = serialize($footprint);
            $ent->footprint = $fp;
          // sinon rien sauf le signaler
          } else {
            $legend .= sprintf(elgg_echo('pin:footprint:viewed'), friendly_time($footprint[''.$ownguid])) . ' ';
          }
        // Sinon on modifie le nombre d'affichages publics
        } else {
          $footprint['0']++;
          $fp = serialize($footprint);
          $ent->footprint = $fp;
        }
      }
      $body .= '<img src="'.$imgurl.'footprint.png" class="tooltips-s" alt="footprint" title="'.elgg_echo('pin:footprint:title').'" />&nbsp;' . $legend;
    // En mode réduit, aucune action mais qqs infos
    } else {
      // Si pas de réglage particulier pour désactiver
      if (!$extendfullonly) {
        if (empty($ent->footprint)) {
            $legend = elgg_echo('pin:footprint:neverread') . ' ';
        } else {
          // Lecture du contenu
          $footprint = unserialize($ent->footprint);
          $numreaders = sizeof($footprint);
          if (isset($footprint['0'])) {
            $pubreaders = $footprint['0'];
            $numreaders--; // Retire 1 lecteur (= compteur hits publics)
          }
          $legend = sprintf(elgg_echo('pin:footprint:readers'), $numreaders);
          if ($pubreaders) $legend .= sprintf(elgg_echo('pin:footprint:pubreaders'), $pubreaders);
          if (isloggedin()) {
            // Ssi GUID pas encore listé
            $legend .= ' - ';
            if (!isset($footprint[''.$ownguid])) {
              $legend .= elgg_echo('pin:footprint:unread') . ' ';
            // sinon rien sauf le signaler
            } else {
              $legend .= sprintf(elgg_echo('pin:footprint:viewed'), friendly_time($footprint[''.$ownguid])) . ' ';
            }
          }
        }
      }
      $body .= '<img src="'.$imgurl.'footprint.png" class="tooltips-s" alt="footprint" title="'.elgg_echo('pin:footprint:title').' - ' . $legend . '" />';
    }
  }
  
  // Render the view only if not empty
  if ($body) echo '<div class="pin_container">' . $body . '</div>';
  
}

