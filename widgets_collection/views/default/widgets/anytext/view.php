<?php
/**
 * Anytext plugin.
 * Allows users to enter any text or html into a widget
 * 
 * @package AnyText
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Brett Profitt <brett.profitt@eschoolconsultants.com>
 * @copyright Brett Profitt 2008
 * @link http://www.eschoolconsultants.com
 */

$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
  set_page_owner($page_owner->getGUID());
}

if (isset($vars['entity'])) {
// if (!$title = $vars['entity']->widgettitle) { $title = elgg_echo('anytext:no_title'); }

	if (!$body = $vars['entity']->description) { $body = elgg_echo('anytext:no_body'); }
	
	echo '<div class="anytext_container contentWrapper">';
//    echo '<div class="anytext_title">' . $title . '</div>';
    echo '<div class="anytext_body">' . $body . '</div>';
	echo '</div>';
}
