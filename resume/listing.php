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
// Load Elgg engine
include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// make sure only logged in users can see this page
//gatekeeper();
// set context to add a "cancel" option
set_context('resumes_form');

//set_page_owner(get_loggedin_user()->getGUID());
set_page_owner($_SESSION['user']->guid);

// set the title
$title = elgg_echo('resume:resume');

// start building the main column of the page
$area2 = elgg_view_title($title);



// TODO : lister les membres ayant renseigné leur CV : récupérer les entités activées, lister les guid des owners de ces contenus, array_unique et afficher la liste des membres avec CV + lien vers le CV




//$experiences = get_entities_from_metadata('startdate', '', 'experience', '', $_SESSION['user']->guid, 999);
//$experiences = get_entities_from_annotations("", "experience", "typology", null, $_SESSION['user']->guid, 0, 99, 0, "asc", false, 0, 0);
//$experiences = get_user_objects($_SESSION['user']->guid, "experience", 99, 0);
/*
$experiences = get_user_objects_by_metadata($_SESSION['user']->guid, "experience", array('typology'=>"work"), 99, 0);
foreach ($experiences as $experience) {
  $area2 .= elgg_view_entity($experience, false);
}
*/


// layout the page
$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

// draw the page
page_draw($title, $body);
