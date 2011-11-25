<?php
/**
 * Elgg read blog post page
 * 
 * @package ElggBlog
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd <info@elgg.com>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.com/
 */

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Get the specified blog post
$post = (int) get_input('blogpost');
if ($layout = get_plugin_setting('layout', 'externalblog')) {} else { $layout = 'right_column'; }

// If we can get out the blog post ...
if ($blogpost = get_entity($post)) {

  // Set the page owner
  set_page_owner($blogpost->container_guid);
  $page_owner = get_entity($blogpost->container_guid);

  // Display it
  $area2 = elgg_view_entity($blogpost, true);
  // Set the title appropriately
  $title = sprintf(elgg_echo("blog:posttitle"),$page_owner->name,$blogpost->title);


} else {
  // If we're not allowed to see the blog post
  // Display the 'post not found' page instead
  $body = elgg_view("blog/notfound");
  $title = elgg_echo("blog:notfound");
}

// Setup page
if (is_plugin_enabled('externalblog')) {
  $area2 = '<div style="padding:5px 20px; margin:0; border:0;">' . $area2 . '</div>';
  $body = externalblog_layout_switch($area2, array('title' => $title));
} else {
  $body = elgg_view_layout('one_column', elgg_view_title($title) . '<div style="padding:5px 20px; margin:0; border:0;">' . $area2 . '</div>');
}

// Display page
page_draw($title,$body);

?>