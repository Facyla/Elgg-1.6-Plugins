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
//if ($page_owner === false || is_null($page_owner)) { $page_owner = get_user_by_username($vars['entity']->username); }
if ($page_owner === false || is_null($page_owner)) { $page_owner = $vars['entity']; }

if ($page_owner->guid == get_loggedin_user()->guid) {
  $title = "<h3><a href=\"" . $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username . "\">" . elgg_echo('resume:my') . "</a></h3>" 
    . "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username . "\">" . elgg_echo("resume:editportfolio") . "</a></p>" 
    . "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . get_loggedin_user()->username . "\" target=\"_blank\">" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
} else {
  $title = "<h3><a href=\"" . $CONFIG->wwwroot . "pg/resumes/" . $page_owner->username . "\">" . sprintf(elgg_echo('resume:user'), $page_owner->name) . "</a></h3>" 
//    . "<p class=\"profile_info_edit_buttons\"><a href=\"#\"onclick=javascript:window.open(\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . $page_owner->username . "\")>" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
    . "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . $page_owner->username . "\" target=\"_blank\">" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
}
$title .= "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/profile/" . $page_owner->username . "?view=xml-europass\" target=\"_blank\" \">" . elgg_echo("resume:profile:xml-europass") . "</a></p>";

if ($vars['full'] == true) { $iconsize = "large"; } else { $iconsize = "medium"; }
?>
<br />
<div class="resume">
  
  <?php echo $title ?>
  
  <div class="clearfloat"></div>
  <br/>
  
  <?php echo elgg_view('resume/resume', array('owner' => $page_owner)); ?>

</div>
