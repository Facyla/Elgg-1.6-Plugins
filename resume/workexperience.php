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
gatekeeper();
// set context to add a "cancel" option
set_context('resumes_form');

//set_page_owner(get_loggedin_user()->getGUID());
set_page_owner($_SESSION['user']->guid);

// set the title
$title = elgg_echo('resume:add:workexperience');

// start building the main column of the page
$area2 = elgg_view_title($title);

// Add the form to this section
if (get_input('id')) {
  $gid = (int) get_input('id');
  $workexperience = get_entity($gid);
  $area2 .= elgg_view("resume/workexperience_form", array('entity' => $workexperience));
} else {
  $area2 .= elgg_view("resume/workexperience_form");
}
// layout the page
$body = elgg_view_layout('two_column_left_sidebar', '', $area2);

// draw the page
page_draw($title, $body);
