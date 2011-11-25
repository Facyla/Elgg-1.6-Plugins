<style>
.iframe_item { margin-bottom: 12px; }
.iframe_title { text-align: center; margin-bottom: 4px; }
.iframe_item iframe:hover {z-index:100000; position:fixed; top:80px; left:0; border:10px solid black; height:100%; width:99% !important;}
</style>

<div class="contentWrapper">
<?php
  global $CONFIG;
  $iframe_url = $vars['entity']->iframe_url;
  $iframe_title = $vars['entity']->iframe_title;
//  $iframe_height = $vars['entity']->iframe_height;  // ajouter dans params possibilité de modifier la taille de l'iframe (en hauteur seulement), avec valeur par défaut - ou reprendre cette idée de fullscreen-on-hover -via case à cocher)
  if($iframe_url) {
    // doubles timeout if going through a proxy
    //$page->set_timeout(20);
?>
  <div class="iframe_item">
    <div class="iframe_title"><h4><a href="<?php echo $iframe_url; ?>"><?php echo $iframe_title; ?></a></h4></div>
    <iframe src="<?php echo $iframe_url; ?>" style="width:100%; height:600px;"></iframe>
  </div>
<?php 
  } else {
    if (get_loggedin_userid() == page_owner())        
      echo '<p>' . elgg_echo('iframe:notset') . '</p>';      
  }
?>
</div>