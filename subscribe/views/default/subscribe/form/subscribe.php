<?php
global $NOTIFICATION_HANDLERS;
foreach($NOTIFICATION_HANDLERS as $method => $foo) {
  $subsbig[$method] = get_entities_from_relationship('notify' . $method,$vars['user']->guid,false,'group','',0,'',99999);
  $tmparray = array();
  foreach($subsbig[$method] as $tmpent) { $tmparray[] = $tmpent->guid; }
  $subsbig[$method] = $tmparray;
}


echo elgg_view_title(elgg_echo('notifications:subscriptions:changesettings:groups')); ?>
<div class="contentWrapper">
  <div class="notification_methods">
    <?php echo elgg_view('notifications/subscriptions/jsfuncs',$vars); ?>
    <p><?php echo elgg_echo('notifications:subscriptions:groups:description'); ?></p>
    <?php if (isset($vars['groups']) && !empty($vars['groups'])) { ?>
      <table id="notificationstable" cellspacing="0" cellpadding="4" border="1" width="100%">
        <tr>
          <td>&nbsp;</td>
          <?php
          global $NOTIFICATION_HANDLERS;
          $i = 0; 
          foreach($NOTIFICATION_HANDLERS as $method => $foo) {
            if ($i > 0) echo "<td class=\"spacercolumn\">&nbsp;</td>";
            echo '<td class="' . $method . 'togglefield">' . elgg_echo('notification:method:'.$method) . '</td>';
            $i++;
          }
          ?>
          <td>&nbsp;</td>
        </tr>
        
        <?php	 // Builds the table fields
        foreach($vars['groups'] as $group) {
          $i = 0; $fields = '';
          foreach($NOTIFICATION_HANDLERS as $method => $foo) {
            $checked[$method] = (in_array($group->guid,$subsbig[$method])) ? 'checked="checked"' : '';
            if ($i > 0) $fields .= "<td class=\"spacercolumn\">&nbsp;</td>";
            $fields .= '<td class="' . $method . 'togglefield">
              <a border="0" id="' . $method . $group->guid . '" class="' . $method . 'toggleOff" onclick="adjust' . $method . '_alt(\'' . $method . $group->guid . '\');">
              <input type="checkbox" name="' . $method . 'subscriptions[]" id="' . $method . 'checkbox" onclick="adjust' . $method . '(\'' . $method . '' . $group->guid . '\');" value="' . $group->guid . '" ' . $checked[$method] . ' /></a>
              </td>';
            $i++;
          } ?>
          <tr>
            <td class="namefield"><?php echo $group->name; ?></td>
            <?php echo $fields; ?>
            <td>&nbsp;</td>
          </tr>
          
        <?php } ?>
        
      </table>

    <?php } ?>
    
    <input type="submit" value="<?php echo elgg_echo('save'); ?>" />
    
  </div>
</div>
