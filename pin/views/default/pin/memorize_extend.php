<?php
global $CONFIG;
$ent = $vars['entity'];

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
  $usememorize = get_plugin_setting('memorize', 'pin');
  $extendfullonly  = get_plugin_setting('extendfullonly ', 'pin');
  if ($extendfullonly  != 'no') $extendfullonly = true; else $extendfullonly  = false; 
  
  // Exceptions : manually disable some types that are not handled in a normalized way
  //if ($ent->getSubtype() == 'thewire') { $usememorize = false; }
  
  if ($usememorize == 'yes') {
    if ($vars['full'] || !$extendfullonly) {
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
            //if (!$vars['icononly']) { $body .= elgg_echo('pin:memorized'); }
            $body .= '<a href="javascript:void(0);" id="memorize_'.$ent->guid.'" onclick="javascript:pin_entity(\'memorize\', '.$ent->guid.');"  class="tooltips-s icon-memorized icon-unmemorize" alt="un-memorize" title="'.elgg_echo('pin:memorize:false').'" style="display:none;">&nbsp;</a>';
            $body .= '<noscript><a href="'.$acturl.'memorize.php?action=unmemorize&guid='.$ent->guid.$tokens.'" class="tooltips-s icon-memorized icon-unmemorize" alt="un-memorize" title="'.elgg_echo('pin:memorize:false').'">&nbsp;</a></noscript>';
          // Sinon on signale qu'elle n'est pas mémorisée pour avoir le bon lien
          } else {
            $memorized = false;
          }
        }
        if (!$memorized) {
          // Si page non mémorisée
          $body .= '<a href="javascript:void(0);" id="memorize_'.$ent->guid.'" onclick="javascript:pin_entity(\'memorize\', '.$ent->guid.');"  class="tooltips-s icon-memorize" alt="memorize" title="'.elgg_echo('pin:memorize:true').'" style="display:none;">&nbsp;</a>';
          $body .= '<noscript><a href="'.$acturl.'memorize.php?action=memorize&guid='.$ent->guid.$tokens.'" class="tooltips-s icon-memorize" alt="memorize" title="'.elgg_echo('pin:memorize:true').'">&nbsp;</a></noscript>';
        }
      }
    }
  }
  
  // Render the view only if not empty
  if ($body) echo '<span class="pin_container">' . $body . '</span>';
}

if (isloggedin()) {
  ?>
  <script type="text/javascript">
  $("#" + "memorize_" + "<?php echo $ent->guid; ?>").toggle(); // make toggle accessible
  </script>
  <?php
}
