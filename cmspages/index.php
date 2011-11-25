<?php
/**
* Elgg CMS pages
* 
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2010
* @link http://id.facyla.fr/
*/

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

// Facyla : this tool is rather for local admins and webmasters than main admins, so use custom access rights : OK if custom rights match, or use default behaviour
if (in_array($_SESSION['guid'], explode(',', get_plugin_setting('editors', 'cmspages')))) {
} else {
  if (is_plugin_enabled('multisite')) { multisite_admin_gatekeeper(); set_context('localmultisite'); } else { admin_gatekeeper(); set_context('admin'); }
}


$pagetype = friendly_title(get_input('pagetype')); // the pagetype e.g about, terms, etc. - default to "mainpage"

// Build the page content
$title = elgg_echo('cmspages');
set_page_owner($_SESSION['guid']); // Set admin user for owner block
$menu = elgg_view('cmspages/menu', array('pagetype' => $pagetype));
$edit = elgg_view('cmspages/forms/edit', array('pagetype' => $pagetype));
$body = elgg_view('page_elements/contentwrapper', array('body' => $menu . $edit));

page_draw($title, elgg_view_layout("two_column_left_sidebar", '', elgg_view_title($title) . $body) );
