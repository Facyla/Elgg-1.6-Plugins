<?php
global $CONFIG;
$ent = $vars['entity'];

$icononly = $vars['icononly'];

//if ($ent instanceof ElggObject) {
if ($ent instanceof ElggEntity) {
  
  $imgurl = $CONFIG->url . 'mod/pin/graphics/';
  $body = '';
  $ownguid = $_SESSION['user']->guid;
  
  // Use to get back to same page
  $_SESSION['last_forward_from'] = current_page_url();
  
  // @todo : delay database writes
  
  // Check plugin settings
  $usefootprint = get_plugin_setting('footprint', 'pin');
  // Exceptions : manually disable some types that are not handled in a normalized way
  if ($ent->getSubtype() == 'groupforumtopic') $usefootprint = false; // partly handled via forum/viewposts - but appears only if answers..
  if ($ent->getSubtype() == 'thewire') { $usefootprint = false; } // Full view is also a listing view
  
  if ($usefootprint == 'yes') {
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
      
      if ($icononly) {
        //$body .= '<span style="background:url('.$imgurl.'footprint.png) no-repeat top left; width:22px; height:20px; float:left;" class="tooltips-s" alt="footprint" title="'.$legend.'">&nbsp;</span>';
        $body .= '<span class="tooltips-s icon-footprint" alt="footprint" title="'.$legend.'">&nbsp;</span>';
      } else {
        $body .= '<span style="min-width:22px; width:auto; padding-left:18px;" class="tooltips-s icon-footprint" alt="footprint" title="'.elgg_echo('pin:footprint:title').'">' . $legend . '</span>';
      }
      
    }
/* Pas de vue réduite en production - trop bruyant
    // Mode vue réduite, aucune action mais qqs infos
    } else {
      if (empty($ent->footprint)) {
          $body .= elgg_echo('pin:footprint:neverread') . ' ';
      } else {
        // Lecture du contenu
        $footprint = unserialize($ent->footprint);
        $numreaders = sizeof($footprint);
        if (isset($footprint['0'])) {
          $pubreaders = $footprint['0'];
          $numreaders--; // Retire 1 lecteur (= compteur hits publics)
        }
        $body .= sprintf(elgg_echo('pin:footprint:readers'), $numreaders);
        if ($pubreaders) $body .= sprintf(elgg_echo('pin:footprint:pubreaders'), $pubreaders);
        if (isloggedin()) {
          // Ssi GUID pas encore listé
          $body .= ' - ';
          if (!isset($footprint[''.$ownguid])) {
            $body .= elgg_echo('pin:footprint:unread') . ' ';
          // sinon rien sauf le signaler
          } else {
            $body .= sprintf(elgg_echo('pin:footprint:viewed'), friendly_time($footprint[''.$ownguid])) . ' ';
          }
        }
      }
*/
  }
  
  // Render the view only if not empty
  if ($body) echo '<span class="pin_container">' . $body . '</span>';
  
}
