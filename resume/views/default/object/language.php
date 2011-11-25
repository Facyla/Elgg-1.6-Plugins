<?php
/**
 * Resume
 *
 * @package Resume
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
/* Object's default view. "Edit" and "Delete" links are added
  based on object's ownership */
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
  $page_owner = get_loggedin_user();
  set_page_owner($page_owner->guid);
}

// => à impacter dans la vue resume pour l'emballage du tableau
$full = (get_context() == "index" || (get_context () != "view" && get_context() != "profile" && get_context() != "profileprint" && get_context() != "resumes")) ? false : true;
$url = $CONFIG->url;

if ($full) {
  echo elgg_view('resume/single_menu');
  ?>
  <tr>
    <td><?php echo elgg_echo($vars['entity']->language) . ' (' . elgg_echo('resume:languages:type:' . $vars['entity']->langtype) . ')'; ?></td>
    <td><?php echo elgg_echo('resume:languages:level:' . $vars['entity']->listening); ?></td>
    <td><?php echo elgg_echo('resume:languages:level:' . $vars['entity']->reading); ?></td>
    <td><?php echo elgg_echo('resume:languages:level:' . $vars['entity']->spokeninteraction); ?></td>
    <td><?php echo elgg_echo('resume:languages:level:' . $vars['entity']->spokenproduction); ?></td>
    <td><?php echo elgg_echo('resume:languages:level:' . $vars['entity']->writing); ?></td>
    
    <?php if ($page_owner->guid == get_loggedin_user()->guid && (get_context() != "profile" && get_context() != "profileprint")) { ?>
      <td><a href="<?php echo $vars['url']; ?>mod/resume/language.php?id=<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo('resume:edit'); ?></a> &nbsp; <?php
      echo elgg_view("output/confirmlink", array(
          'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(),
          'text' => elgg_echo('resume:delete'),
          'confirm' => elgg_echo('resume:delete:element'),
        ));

      // Allow the menu to be extended
      echo elgg_view("editmenu", array('entity' => $vars['entity']));
      ?></td>

    <?php } ?>
  </tr>
  <?php
  
} else {
  // Compact view
  if ($page_owner->guid == get_loggedin_user()->guid) {
    echo '<a href="' . $vars['url'] . 'mod/resume/language.php?id=' . $vars['entity']->getGUID() . '" title="' . elgg_echo('edit') . '">' . elgg_echo($vars['entity']->language) . ' (' . elgg_echo('resume:languages:type:' . $vars['entity']->langtype) . ')</a> &nbsp; ';
    echo '<b>' . elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(),
        'text' => 'x', 'confirm' => elgg_echo('resume:delete:element'), 'title' => elgg_echo('delete'))) . '</b><br />';
  } else {
    echo elgg_echo($vars['entity']->language) . ' (' . elgg_echo('resume:languages:type:' . $vars['entity']->langtype) . ')<br />';
  }
  
}
