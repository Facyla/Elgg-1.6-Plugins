<?php
/**
 * Elgg feed plugin index
 * 
 * @package Elggfeed
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider <info@elgg.com>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */

// Start engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

$area1 = "";
$area2 = "";
$title = elgg_echo('simplepie:all');

// Page principale - listing des flux existants (auxquels on a accès)
set_context('search');
$feeds = get_entities('object', 'feed', 0, 'time_updated desc', $limit, $offset, false, -1);
$totalcount = count($feeds);
$feedlist = elgg_view_entity_list($feeds, $totalcount, $offset, $limit, false, false, true);
if (strlen($feedlist) > 0) $area2 .= $feedlist;

set_context('simplepie');

// Display the contents in chosen layout
$body = elgg_view_layout("one_column", elgg_view_title($title) . '<div class="contentWrapper">' . $area2 . '</div>');
//$body = elgg_view_layout("two_column_left_sidebar", $area1, elgg_view_title($title) . $area2);


// Draw it
echo page_draw($title, $body);
