<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

$username = get_input('username');

// forward away if invalid user.
if (!$user = get_user_by_username($username)) {
  register_error('blog:error:unknown_username');
  forward($_SERVER['HTTP_REFERER']);
}

// set the page owner to show the right content
set_page_owner($user->getGUID());
$page_owner = page_owner_entity();

if ($page_owner === false || is_null($page_owner)) {
  $page_owner = get_loggedin_user();
  set_page_owner(get_loggedin_user());
}

if ($page_owner->guid == get_loggedin_user()->guid) { $area2 = elgg_view_title(elgg_echo('resume:my')); }
else { $area1 = elgg_view_title(sprintf(elgg_echo('resume:user'), $page_owner->name)); }

$area2 .= elgg_view('resume/resume', array('owner' => $page_owner));
$area2 .= '<br />';
set_input('id', $page_owner->guid);
$area2 .= elgg_view('resume/chronogram');
set_context('resumes');

// Add sidebar search
//      $area0 = elgg_view("resume/search");

$body = elgg_view_layout("two_column_left_sidebar", $area0, $area1 . $area2);

// Use following to integrate into FormaVia's personal space - we don't want this by now
//if (is_plugin_enabled('formavia')) $body = elgg_view_layout("myhome", $body);

page_draw(sprintf(elgg_echo('resume:user'), $page_owner->name), $body);
