<?php 
global $CONFIG;
if (!class_exists('SimplePie')) { require_once $CONFIG->pluginspath . '/simplepie/simplepie.inc'; }
$owner = $vars['entity']->getOwnerEntity();
$friendlytime = friendly_time($vars['entity']->time_created);

if (isset($vars['entity'])) {
  $feed_url = $vars['entity']->feedurl; 
  $excerpt = $vars['entity']->excerpt; 
  $num_items = $vars['entity']->num_items; 
  $post_date = $vars['entity']->post_date; 
  $title = $vars['entity']->title;
}
$blog_tags = '<a><p><br><b><i><em><del><pre><ul><ol><li><img><embed><video><iframe>';
if (is_array($feed_url)) $feeds_url = $feed_url;
else $feeds_url = array($feed_url);


if (get_context() == "search") {
      
//		if (get_input('search_viewtype') == "gallery") {
      $parsed_url = parse_url($vars['entity']->feedurl);
      $faviconurl = $parsed_url['scheme'] . "://" . $parsed_url['host'] . "/favicon.ico";
      if (@file_exists($faviconurl)) { $icon = "<img src=\"{$faviconurl}\" />"; } else { $icon = elgg_view("profile/icon", array('entity' => $owner, 'size' => 'small', ) ); }
      
      $info = "<p class=\"shares_gallery_title\">". elgg_echo("feed:feed") .": <a href=\"{$vars['entity']->getURL()}\">{$vars['entity']->title}</a> (<a href=\"{$vars['entity']->feedurl}\">{$vars['entity']->feedurl}</a>)</p>";
      $info .= "<p class=\"owner_timestamp\"><a href=\"{$vars['url']}pg/feed/{$owner->username}\">{$owner->name}</a> {$friendlytime}";
      $info .= "</p>";
      echo elgg_view_listing($icon, $info);
//		}

} else  {

  set_context('simplepie');
  $switch = true;
  $area1 .= "<h2><a href=\"{$vars['entity']->getURL()}\">{$vars['entity']->title}</a>" . '<span style="font-size:12px; font-weight:normal;"> &nbsp; &nbsp; (<a href="' . $vars['entity']->feedurl . '">' . $vars['entity']->feedurl . '</a>)</span></h2><br /><br />';
  foreach ($feeds_url as $feed_url) {
    if($feed_url) {
      $cache_loc = $CONFIG->pluginspath . '/simplepie/cache';
      $feed = new SimplePie($feed_url, $cache_loc);
      // doubles timeout if going through a proxy
      $feed->set_timeout(20);
      $num_posts_in_feed = $feed->get_item_quantity();
      
      $area1 .= '<div class="simplepie_blog_title">';
      $area1 .= '<h2><a href="' . $feed->get_permalink() . '">' . $feed->get_title() . '</a></h2>';
      $area1 .= '</div>';
  
      if ($num_items > $num_posts_in_feed) { $num_items = $num_posts_in_feed; }
      foreach ($feed->get_items(0,$num_items) as $item) {
        $area1 .= '<div class="simplepie_item">
            <div class="simplepie_title">
            <h4><a href="' . $item->get_permalink() . '">' . $item->get_title() . '</a></h4>
            </div>';
        
        if ($excerpt) {
            $area1 .= '<div class="simplepie_excerpt"><small>' . strip_tags(html_entity_decode($item->get_description(true)),$blog_tags) . '</small></div>';
            $area1 .= '<div class="simplepie_excerpt">' . strip_tags(html_entity_decode($item->get_content(true)),$blog_tags) . '</div>';
        }
    
        if ($post_date) {
            $area1 .= '<div class="simplepie_date" style="clear:left;">' . elgg_echo('simplepie:postedon') . ' ' . friendly_time($item->get_date('U')) . '</div>';
        }
        $area1 .= '</div><br />';
      }
    }
  }
  ?>
<div class="contentWrapper">
  <div style="float:right;"><p>
    <a href="<?php echo $vars['url']; ?>mod/simplepie/edit.php?feed_guid=<?php echo $vars['entity']->getGUID(); ?>"><?php echo elgg_echo('edit'); ?></a> &nbsp;
    <?php echo elgg_view('output/confirmlink',array(						
        'href' => $vars['url'] . "action/feed/delete?feed_guid=" . $vars['entity']->getGUID(),
        'text' => elgg_echo("delete"), 'confirm' => elgg_echo("feed:delete:confirm"), ));  ?>
    </p>
  </div>
  <?php echo $area1; ?>
  <div class="clearfloat"></div>
</div>
 <?php    
}
