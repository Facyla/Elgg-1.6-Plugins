<?php

/**
 * Elgg feed plugin form
 * 
 * @package Elggfeed
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider <info@elgg.com>
 * @copyright Curverider Ltd 2008-2009
 * @link http://elgg.org/
 */

  set_context('simplepie');

// Have we been supplied with an entity?
  if (isset($vars['entity'])) {
    
    $guid = $vars['entity']->getGUID();
    $title = $vars['entity']->title;
    $description = $vars['entity']->description;
    $feedurl = $vars['entity']->feedurl;
    $excerpt = $vars['entity']->excerpt;
    $num_items = $vars['entity']->num_items;
    $post_date = $vars['entity']->post_date;
    $tags = $vars['entity']->tags;
    $access_id = $vars['entity']->access_id;
//			$shares = $vars['entity']->shares;
    $owner = $vars['entity']->getOwnerEntity();
    $highlight = 'default';
    $container_guid = $vars['container_guid'];
    
  } else {
    
    $guid = 0;
    $container_guid = get_input('container_guid',"");
    $title = get_input('title',"");
    $description = "";
    $feedurl = get_input('feedurl',"");
    $num_items = get_input('num_items', 7);
    $post_date = get_input('post_date', elgg_echo('feed:post_date'));
    $excerpt = get_input('excerpt', elgg_echo('feed:excerpt'));
    $highlight = 'all';
    
//			if ($address == "previous")
//				$address = $_SERVER['HTTP_REFERER'];
    $tags = array();
    
    if (defined('ACCESS_DEFAULT'))
      $access_id = ACCESS_DEFAULT;
    else
      $access_id = 0;
//			$shares = array();
    $owner = $vars['user'];
    
  }

?>
<div class="contentWrapper">
	<form action="<?php echo $vars['url']; ?>action/feed/edit" method="post">
		
		<p><label><?php 	echo elgg_echo('title') . elgg_view('input/text',array( 'internalname' => 'title', 'value' => $title, )); ?></label></p>
		
		<p><label><?php echo elgg_echo('feed:feedurl') . elgg_view('input/url',array( 'internalname' => 'feedurl', 'value' => $feedurl, )); ?></label></p>
		
		<p style="float:left; margin-right: 20px;"><label><?php echo elgg_echo('feed:num_items');
		  echo elgg_view('input/pulldown',array(
		      'internalname' => 'num_items',
		      'options_values' => array("1" => 1,"2" => 2,"3" => 3, "5" => 5, "7" => 7, "20" => 20, "50" => 50, "100" => 100, ),
		      'value' => $num_items, ));
        ?></label></p>
		<p style="float:left; margin-right: 20px;"><label><?php echo elgg_view('input/checkboxes',array( 'internalname' => 'excerpt', 'options' => array(elgg_echo('feed:excerpt')), 'value' => $excerpt, )); ?></label></p>
		<p style="float:left; margin-right: 20px;"><label><?php echo elgg_view('input/checkboxes',array( 'internalname' => 'post_date', 'options' => array(elgg_echo('feed:post_date')), 'value' => $post_date, )); ?></label></p>
    <div class="clearfloat"></div>
		
		<p class="longtext_editarea">
			<label>
				<?php 	echo elgg_echo('description'); ?><br />
				<?php echo elgg_view('input/longtext',array( 'internalname' => 'description', 'value' => $description, )); ?>
			</label>
		</p>
		
		<p><label><?php 	echo elgg_echo('tags') . elgg_view('input/tags',array( 'internalname' => 'tags', 'value' => $tags, )); ?></label></p>
		
<?php /* ?>
		<p><label><?php echo elgg_echo("feed:with"); ?></label><br /><?php
				//echo elgg_view('feed/sharing',array('shares' => $shares, 'owner' => $owner));
				if ($friends = get_entities_from_relationship('friend',$owner->getGUID(),false,'user','', 0, "", 9999)) {
					echo elgg_view('friends/picker',array('entities' => $friends, 'internalname' => 'shares', 'highlight' => $highlight));
				} ?></p>
<?php */ ?>
		
		<p><label><?php 	echo elgg_echo('access') . elgg_view('input/access',array( 'internalname' => 'access', 'value' => $access_id, )); ?></label></p>
		
		<p>
			<input type="hidden" name="container_guid" value="<?php echo $container_guid; ?>" />
			<input type="hidden" name="feed_guid" value="<?php echo $guid; ?>" />
      <?php echo elgg_view('input/securitytoken'); ?>
			<input type="submit" value="<?php echo elgg_echo('save'); ?>" />
		</p>
	
	</form>
</div>