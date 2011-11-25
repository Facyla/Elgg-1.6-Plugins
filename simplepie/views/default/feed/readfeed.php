<?php 
 global $CONFIG;
  if (!class_exists('SimplePie')) { require_once $CONFIG->pluginspath . '/simplepie/simplepie.inc'; }
  
   if (isset($vars)) {
        $feed_url = $vars['feedurl']; 
        $excerpt = $vars['excerpt']; 
        $num_items = $vars['num_items']; 
        $post_date = $vars['post_date']; 
        $title = $vars['title'];
        $description = $vars['description'];
        
   }
  
  $blog_tags = '<a><p><br><b><i><em><del><pre><ul><ol><li><img><embed><video><iframe>';
  
  if(is_array($feed_url)) $feeds_url = $feed_url;
  else $feeds_url = array($feed_url);
  
 // $feeds_url = array('http://feeds.delicious.com/v2/rss/tag/fablabsquared', ); // #config - on peut en mettre plusieurs si besoin
  $switch = true;
  foreach ($feeds_url as $feed_url) {
    if($feed_url) {
//      $excerpt   = true; // #config
//      $num_items = 5; // #config
//      $post_date = true; // #config
       
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
          $area1 .= '<div class="simplepie_excerpt">' . strip_tags(html_entity_decode($item->get_description(true)),$blog_tags) . '</div>';
          $area1 .= '<div class="simplepie_excerpt">' . strip_tags(html_entity_decode($item->get_content(true)),$blog_tags) . '</div>';
        }

        if ($post_date) {
          $area1 .= '<div class="simplepie_date">' . elgg_echo('simplepie:postedon') . ' ' . $item->get_date('j/m Y g:i a') . '</div>';
        }
        $area1 .= '</div>
        <div class="clearfloat"></div>';
      }
    }
  }
  
  echo $description . '<br />' . $area1;
  