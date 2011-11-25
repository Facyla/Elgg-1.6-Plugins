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

$feed_url = get_plugin_setting('feed_url');
$excerpt = get_plugin_setting('excerpt');
$num_items = get_plugin_setting('num_items');
$post_date = get_plugin_setting('post_date');
$title = get_plugin_setting('feedtitle');

$area2 .= elgg_view('', array('feedurl' => $feedurl, 'excerpt' => $excerpt, 'num_items' => $num_items, 'post_date' => $post_date, 'title' => $title, ));

set_context('simplepie');
// Format page
$body = elgg_view_layout('one_column', $area2);

// Draw it
echo page_draw(elgg_view_title($title),$body);
