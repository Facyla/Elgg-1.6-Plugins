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
  $ownguid = $_SESSION['user']->guid;
  $body = '';
  
  // Use to get back to same page
  $_SESSION['last_forward_from'] = current_page_url();
  
  // @todo : ajaxify actions
  
  // Check plugin settings
  $usehighlight = get_plugin_setting('highlight', 'pin');
  $extendfullonly  = get_plugin_setting('extendfullonly ', 'pin');
  if ($extendfullonly  != 'no') $extendfullonly = true; else $extendfullonly  = false; 
  
  if ($usehighlight == 'yes') {
    if ($vars['full'] || !$extendfullonly) {
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
      
      // Pas mis en avant : seul certains users peuvent le faire
      if (empty($ent->highlight)) {
        if ($highlightaccess) {
          $body .= '<a href="javascript:void(0);" id="highlight_'.$ent->guid.'" onclick="javascript:pin_entity(\'highlight\', '.$ent->guid.');"  class="tooltips-s icon-highlight" alt="highlight" title="'.elgg_echo('pin:highlight:true').'" style="display:none;">&nbsp;</a>';
          $body .= '<noscript><a href="'.$acturl.'highlight.php?guid='.$ent->guid.$tokens.'" class="tooltips-s icon-highlight" alt="highlight" title="'.elgg_echo('pin:highlight:true').'">&nbsp;</a></noscript>';
        }
        
      // Mis en avant : affichage simple ou action si user autorisé
      } else {
        if ($highlightaccess) {
          switch ($ent->highlight) {
            case 'admin':
            default:
              $body .= '<a href="javascript:void(0);" id="highlight_'.$ent->guid.'" onclick="javascript:pin_entity(\'highlight\', '.$ent->guid.');"  class="tooltips-s icon-highlighted icon-unhighlight" alt="un-highlight" title="'.elgg_echo('pin:highlight:false').'" style="display:none;">&nbsp;</a>';
              $body .= '<noscript><a href="'.$acturl.'highlight.php?guid='.$ent->guid.$tokens.'" class="tooltips-s icon-highlighted icon-unhighlight" alt="un-highlight" title="'.elgg_echo('pin:highlighted').' - '.elgg_echo('pin:highlight:false').'">&nbsp;</a></noscript>';
            
              
          }
          //$body .= elgg_echo('pin:highlighted');
        } else {
          //$body .= ' <img src="'.$imgurl.'pin.gif" class="tooltips-s icon-highlighted" alt="highlighted" title="'.elgg_echo('pin:highlighted').'" />&nbsp; ';
          $body .= ' <span class="tooltips-s icon-highlighted" alt="highlighted" title="'.elgg_echo('pin:highlighted').'">&nbsp;</span>';
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
  $("#" + "highlight_" + "<?php echo $ent->guid; ?>").toggle(); // make toggle accessible
  </script>
  <?php
}
