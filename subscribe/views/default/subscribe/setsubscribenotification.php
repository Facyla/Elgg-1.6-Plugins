<?php
/**
* Subscriber
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Fabrice Collette
* this plugin has been founded by Fondation Maison des Sciences de l'Homme - Paris	 
* @copyright Fabrice Collette 2010
* @link http://www.meleze-conseil.com
*/

global $NOTIFICATION_HANDLERS;

// Include styles (multiste caching issue)
echo '<style>';
include('css.php');
echo '</style>';

if (isset($vars['group']) && !empty($vars['group'])) {
  $group = $vars['group'];
  echo elgg_view('notifications/subscriptions/jsfuncs',$vars);
  ?>
  <p>
    <?php
    if ($group instanceof ElggUser) {
      echo sprintf(elgg_echo('subscribe:notifications:single:subscriptions:description'), $group->name);
    } else if ($group instanceof ElggSite) {
      echo sprintf(elgg_echo('subscribe:notifications:single:subscriptions:description:site'), $group->name);
    } else {
      echo sprintf(elgg_echo('subscribe:notifications:single:subscriptions:description:group'), $group->name);
    }
    ?>
  </p>

  <table id="notificationstable" cellspacing="0" cellpadding="4" border="1" width="100%">
    <tr>
      <td>&nbsp;</td>
      <?php
      $i = 0; 
      foreach($NOTIFICATION_HANDLERS as $method => $foo) {
        if ($i > 0) echo "<td class=\"spacercolumn\">&nbsp;</td>";
        echo '<td class="' . $method . 'togglefield">' . elgg_echo('notification:method:'.$method) . '</td>';
        $i++;
      }
      ?>
      <td>&nbsp;</td>
    </tr>
    <?php	
    $fields = '';
    foreach($NOTIFICATION_HANDLERS as $method => $foo) {
      //if (in_array($group->guid,$subsbig[$method])) {
      $checked[$method] = (check_entity_relationship($vars['user']->guid,'notify'.$method, $group->guid)) ? 'checked="checked"' : '';
      $fields .= "<td class=\"spacercolumn\">&nbsp;</td>";
      $fields .= '<td class="' . $method . 'togglefield">
        <a border="0" id="' . $method . '' . $group->guid . '" class="' . $method . 'toggleOff" onclick="adjust' . $method . '_alt(\'' . $method . '' . $group->guid . '\');">
        <input type="checkbox" name="' . $method . 'subscriptions[]" id="' . $method . 'checkbox" onclick="adjust' . $method . '(\'' . $method . '' . $$group->guid . '\');" value="' . $group->guid . '" ' . $checked[$method] . ' /></a></td>';
    }
    ?>
    <tr>
      <td class="namefield"><?php echo $group->name; ?></td>
      <?php echo $fields; ?>
      <td>&nbsp;</td>
    </tr>

  </table>
<?php }

echo elgg_view('input/securitytoken'); ?>

<input type="submit" value="<?php echo elgg_echo('save'); ?>" />
