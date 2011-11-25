<?php
/**
* Resume
*
* @package Resume
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla <admin@facyla.fr>
* @copyright Facyla 2010
* @link http://id.facyla.net/
*/
$page_owner = get_user($vars['entity']->owner_guid);

// Edit link for page owner
if ($page_owner->guid == get_loggedin_user()->guid) {
  $title = '<p class="profile_info_edit_buttons"><a href="' . $CONFIG->wwwroot . 'pg/resumes/' . get_loggedin_user()->username . '">' . elgg_echo('resume:editportfolio') . '</a></p>';
}

// Version print
$title .= '<p class="profile_info_edit_buttons"><a href="' . $CONFIG->wwwroot . 'pg/resumesprintversion/' . $page_owner->username . '" target="_blank">' . elgg_echo('resume:profile:gotoprint') . '</a></p>';

// XML Europass
$title .= '<p class="profile_info_edit_buttons"><a href="' . $CONFIG->wwwroot . 'pg/profile/' . $page_owner->username . '?view=xml-europass" target="_blank" ">' . elgg_echo('resume:profile:xml-europass') . '</a></p>';
?>

<div class="resume">
  <?php echo $title; ?>
  <div class="clearfloat"></div>
  <br/>
  <?php echo elgg_view('resume/resume', array('owner' => $page_owner)); ?>
</div>
