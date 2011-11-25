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
$startdate = get_input('startdate');
$enddate = get_input('enddate');
$ongoing = get_input('ongoing');
$heading = get_input('heading');
$skills = get_input('skills');
$structure = get_input('structure');
$level = get_input('level');
$field = get_input('field');
$importance = get_input('importance');
$contact = get_input('contact');
$access_id = get_input('access_id');


// create a new object
$experience = new ElggObject();
$experience->startdate = $startdate;
$experience->enddate = $enddate;
$experience->ongoing = $ongoing;
$experience->heading = $heading;
$experience->skills = $skills;
$experience->structure = $structure;
$experience->level = $level;
$experience->field = $field;
$experience->importance = $importance;
$experience->contact = $contact;
// Titre déduit des autres infos = (typology :) jobtitle @ organisation
$experience->title = $heading . ' @ ' . $structure;
$experience->subtype = 'education';


// allow access rights for the resume
$experience->access_id = $access_id;

// owner is logged in user
$experience->owner_guid = get_loggedin_userid();

// save to database
$experience->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $experience->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
