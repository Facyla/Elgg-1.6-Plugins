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
  set_page_owner(get_loggedin_userid());
}

$full = (get_context () != "view") ? false : true;
$compact = (get_context () != "index") ? false : true;
$url = $CONFIG->url;


// Full and listing views
if (!$compact) {
  echo elgg_view('resume/single_menu');
  ?>
  <div>
    <p>
      <?php echo elgg_view('resume/importancebar', array('importance' => $vars['entity']->importance)); ?>
      <strong><a href="<?php echo $vars['entity']->getURL(); ?>"><?php echo $vars['entity']->heading; ?></a></strong> chez <strong><?php echo '<a href="' . $url . 'search/?tag=' . $vars['entity']->structure . '">' . $vars['entity']->structure; ?></a></strong>
      <?php
      echo " (" . date('d/m/Y', $vars['entity']->startdate) . " &rarr; ";
      if ($vars['entity']->ongoing == 'ongoing') echo elgg_echo('resume:date:now'); else echo date('d/m/Y', $vars['entity']->enddate);
      echo ")";
      ?>
    </p>
    
    <?php
    if ($full) {
      // Full view
      echo '<br /><br />';
      if ($vars['entity']->heading) { echo '<p><strong>' . elgg_echo('resume:workexperience:heading') . ' :</strong> ' . $vars['entity']->heading . '</p>'; }
      
      if ($vars['entity']->structure) { echo '<p><strong>' . elgg_echo('resume:workexperience:structure') . ' :</strong> <a href="' . $url . 'search/?tag=' . $vars['entity']->structure . '">' . $vars['entity']->structure . '</a></p>'; }
      
      if ($vars['entity']->sector) { echo '<p><strong>' . elgg_echo('resume:workexperience:sector') . ' :</strong> ' . elgg_echo('resume:sector:' . $vars['entity']->sector) . '</p>'; }
      
      if ($vars['entity']->contact) { echo '<p><strong>' . elgg_echo('resume:workexperience:contact') . ' :</strong> ' . $vars['entity']->contact . '</p>'; }
      
      if ($vars['entity']->description) { echo '<p><strong>' . elgg_echo('resume:workexperience:description') . ':</strong> ' . $vars['entity']->description . '</p>'; }
      
    } else {
      // Compact view
      echo '<a href="' . $vars['entity']->getURL() . '">en savoir plus..</a>';
      
    }
    

    echo '<p>';
      // Edit & delete links
      if (($page_owner->guid == get_loggedin_user()->guid) && (get_context() != "profileprint")) {
        echo '<a href="' . $vars['url'] . 'mod/resume/workexperience.php?id=' . $vars['entity']->getGUID() . '">' . elgg_echo('resume:edit') . '</a>&nbsp; ';
        echo elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(),
            'text' => elgg_echo('resume:delete'), 'confirm' => elgg_echo('resume:delete:element'), )) . '&nbsp; ';
        echo elgg_view("editmenu", array('entity' => $vars['entity'])); // Allow the menu to be extended
      }
      if (!$full && (get_context () != "profileprint")) {
        $num_comments = elgg_count_comments($vars['entity']);
        echo '<a href="' . $vars['entity']->getURL() . '">' . sprintf(elgg_echo("comments")) . ' (' . $num_comments . ')</a><br />';
      }
    echo '</p>';
    ?>
    
    <!-- Comments features -->
    <?php if ($full) { echo elgg_view_comments($vars['entity']); } ?>
    <!-- End of Comments features -->

  </div>
  <?php
} else {
  // Compact view : edit & delete links
  if ($page_owner->guid == get_loggedin_user()->guid) {
    echo '<a href="' . $vars['url'] . 'mod/resume/workexperience.php?id=' . $vars['entity']->getGUID() . '" title="' . elgg_echo('edit') . '">' . date('m/Y', $vars['entity']->startdate) . "&rarr;";
    if ($vars['entity']->ongoing == 'ongoing') echo elgg_echo('resume:date:now'); else echo date('d/m/Y', $vars['entity']->enddate);
    echo '&nbsp;: ' . $vars['entity']->heading . ' (' . $vars['entity']->structure . ')</a> &nbsp; ' 
      . '<b>' . elgg_view("output/confirmlink", array( 'href' => $vars['url'] . "action/resume/delete?id=" . $vars['entity']->getGUID(), 'text' => 'x', 'confirm' => elgg_echo('resume:delete:element'), 'title' => elgg_echo('delete'))) . '</b><br />';
  } else {
    echo '<a href="' . $vars['entity']->getURL() . '">' . $vars['entity']->heading . '</a><br />';
  }
}
