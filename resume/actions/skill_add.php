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
// only logged in users can add and object
gatekeeper();

// get the form input
$skilltype = get_input('skilltype', 'other');
$skillcontent = get_input('skill');
$driving = get_input('driving');
$importance = get_input('importance');
$access_id = get_input('access_id');


// Note : skill = code du permis si driving, contenu de la compétence sinon ; on distingue les skills des structured skills via le type seulement
// create a new object
$skill = new ElggObject();
switch($skilltype) {
  case "driving":
    $skill->skilltype = $skilltype;
    $skill->skill = $driving;
    $skill->title = elgg_echo('resumes:skill:driving:' . $driving);
    break;
  default:
    $skill->skilltype = $skilltype;
    $skill->skill = $skillcontent;
    $skill->title = $skillcontent;
}
$skill->importance = $importance;
// Titre déduit des autres infos = (typology :) jobtitle @ organisation
$skill->subtype = 'skill';


// allow access rights for the resume
$skill->access_id = $access_id;

// owner is logged in user
$skill->owner_guid = get_loggedin_userid();

// save to database
$skill->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $skill->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
