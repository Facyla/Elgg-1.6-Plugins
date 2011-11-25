<?php
/**
 * CSS spécifique pour le fil d'Ariane (breadcrumb trail)
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @link http://id.facyla.net/
 * 
 */
global $CONFIG;

//$sep = " &raquo; "; // = " > "
$sep = ''; // = " > "
$wrap1 = '<span class="breadcrumbtrail">';
$wrap2 = '</span>';

$root_string = '<a href="' . $CONFIG->url . '">' . elgg_echo('breadcrumbtrail:root') . '</a>';
$site_string = '<a href="' . $CONFIG->url . '">' . sprintf(elgg_echo('breadcrumbtrail:site'), $CONFIG->sitename) . '</a>';

// Get useful data first
$page_owner = page_owner_entity();
$context = get_context();

//Container is a Group or User (page_owner)
if ($page_owner instanceof ElggGroup) {
  $container = '<a href="'.$page_owner->getURL().'" title="'.elgg_echo('group').' : '.$page_owner->name.'">'.sprintf(elgg_echo('breadcrumbtrail:container'), $page_owner->name).'</a>';
//Container is a User (page_owner)
} else if ($page_owner instanceof ElggUser) {
  $container = '<a href="' . $page_owner->getURL() . '" title="'.elgg_echo('user').' : '.$page_owner->name.'">' . sprintf(elgg_echo('breadcrumbtrail:container'), $page_owner->name) . '</a>';
}

// Object subtype index page (into container) - baser ça sur un test via le tableau dans les objects registered plutôt que ça
if (($context != "site") && ($context != "groups") && ($context != "multisite") && ($context != "search")) {
  $subtype = sprintf(elgg_echo('breadcrumbtrail:subtype'), elgg_echo($context));
  switch($context) {
    case 'pages':
      // Don't display wiki homepage link, as it is already in pages' breadcrumbs
      //$subtype = '<a href="' . $CONFIG->url . 'pg/pages/owned/' .$page_owner->username. '">' . $subtype . '</a>';
      $parent = get_entity(get_input("page_guid"));
      // Gestion du cas "édition" et "nouvelle page"
      if (get_input("container_guid")) {
        if (get_input("parent_guid", $page_owner->guid)) $parent = get_entity(get_input("parent_guid"));
        $subtype = elgg_view('breadcrumbtrail/pages_breadcrumbs', array('page_owner'=>$page_owner, 'parent'=>$parent, 'add'=>true, 'sep'=>$sep, 'wrap1'=>$wrap1, 'wrap2'=>$wrap2));
      } else {
        $subtype = elgg_view('breadcrumbtrail/pages_breadcrumbs', array('page_owner'=>$page_owner, 'parent'=>$parent, 'sep'=>$sep, 'wrap1'=>$wrap1, 'wrap2'=>$wrap2));
      }
      break;
    case 'forum':
      $subtype = '<a href="' . $CONFIG->mainsiteurl . 'pg/groups/forum/' .$page_owner->guid. '">' . $subtype . '</a>';
      if (get_input('topic')) {
        $forum = get_entity(get_input('topic'));
        $subtype .= $wrap2 . $sep . $wrap1 . $forum->title;
      }
      /* @todo same as for pages..
      */
      break;
    default:
  }
}
//  $subtype = '<a href="' . $subtype . '">' . sprintf(elgg_echo('breadcrumbtrail:subtype'), elgg_echo($context)) . '</a>';

// Content title ; with URL if edited (text otherwise)
//$content = '<a href="' . $content_string . '">' . elgg_echo('breadcrumbtrail:content') . '</a>';

// Action : edit or create only, text based on URL (but not an url)
//$action = '<a href="' . $action . '">' . elgg_echo('breadcrumbtrail:action') . '</a>';

/* Structure du Fil : Accueil (site) > Container (group/user) > Subtype > Content > action
- Accueil
- Accueil > Membre Xyaz > Blog
- Accueil > Données publiques > Blog > Mon article > édition
*/
?>

<div id="breadcrumbtrail">
  <?php
  echo $wrap1 . $site_string . $wrap2;
  if ($container) echo $wrap1 . $sep . $container . $wrap2;
  if ($subtype) echo $wrap1 . $sep . $subtype . $wrap2;
  if ($content) echo $wrap1 . $sep . $content . $wrap2;
  if ($action) echo $wrap1 . $sep . $action . $wrap2;
  if (!$container && !$subtype && !$content && !$action) echo $wrap1 . $sep . elgg_echo('breadcrumbtrail:root') . $wrap2;;
  ?>
</div>
<div class="clearfloat"></div>
