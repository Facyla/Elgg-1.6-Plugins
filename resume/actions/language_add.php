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
// Language code (fr => french, etc.)
$lang_id = get_input('langcode');
$langtype = get_input('langtype');
$listening = get_input('listening');
$reading = get_input('reading');
$spokeninteraction = get_input('spokeninteraction');
$spokenproduction = get_input('spokenproduction');
$writing = get_input('writing');
$access_id = get_input('access_id');

// create a new object
$language = new ElggObject();
$language->language = $lang_id;
$language->langtype = $langtype;
$language->listening = $listening;
$language->reading = $reading;
$language->spokeninteraction = $spokeninteraction;
$language->spokenproduction = $spokenproduction;
$language->writing = $writing;
$language->subtype = "language";


// allow access rights for the resume
$experience->access_id = $access_id;

// owner is logged in user
$language->owner_guid = get_loggedin_userid();

// save to database
$language->save();
system_message(elgg_echo('resume:OK'));

// add to river
add_to_river('river/object/resume/create', 'create', get_loggedin_userid(), $language->guid);

// forward user to a main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
