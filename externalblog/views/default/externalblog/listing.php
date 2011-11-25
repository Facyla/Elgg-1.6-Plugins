<?php
global $CONFIG;
$blogs_ent = $vars['entities'];
//$tag = $vars['tag'];
$limit = $vars['limit'];
$offset = $vars['offset'];
$cuttag = $vars['cuttag'];
$separator = $vars['separator'];

$viewtype = get_input('view');
$blogs = "";
$i = 0;

// Pagination : si offset > 0, on ajoute le lien vers les articles précédents
$previous_offset = $offset - $limit;
if ($previous_offset < 0) $previous_offset = 0;
if ($offset > 0) $pagination = '<a href="' . $CONFIG->url . '?offset=' . $previous_offset . '&limit=' . $limit . '" class="pagination previous">Articles précédents</a>';
// Affichage des contenus
foreach($blogs_ent as $blog) {

/*
  // Filtrage a posteriori : si tag fourni, on exclue les contenus qui ne correspondent pas (filtrage par catégorie)
  // On se contente de passer au suivant si ça ne correspond pas
  echo implode(',', $blog->tags);
  if ($tag) { if (in_array($tag, $blog->tags)) {} else { continue; } }
*/

  // Découpe du contenu de l'article au niveau de la balise $cuttag
  $description = $blog->description;
  $pos = strrpos($blog->description, $cuttag);
  if ($pos) $description = substr($blog->description, 0, $pos) . '<a href="' . $blog->getURL() . '" class="readmore_link">...lire la suite</a><br /><br />';
  $cat = (empty($blog->tags)) ? '' : '<br />' . elgg_view('output/tags', array('tags' => $blog->tags));
  $blogs .= "<h3><a href=\"{$blog->getURL()}\">{$blog->title}</a></h3>" 
    . 'publié le ' . date("d/m/Y", $blog->time_created) 
    . ' par ' . get_entity($blog->owner_guid)->name 
    . ', ' . elgg_count_comments($blog) . ' ' . elgg_echo("comments") 
    . $cat 
    . "<br /><br />$description"
    . '<div class="clearfloat"></div>';
  // Affichage des commentaires seulement si commentaires publics activés
  if (is_plugin_enabled('anonymous_comments')) {
    $opencomments = find_plugin_settings('anonymous_comments');
    if ($opencomments->comments_formedit_disabled != 'yes') {
      $blogs .= '<p><a href="javascript:void(0);" class="comments_toggler" onclick="$(\'#externalblog_comment' . $i . '\').toggle();">' 
        . elgg_echo('externalblog:showhidecomments') . '</a></p><div id="externalblog_comment' . $i . '" style="display:none;">' 
        . elgg_view_comments($blog) . '</div>';
    }
  }
  $blogs .= $separator;
  $i++;
  
  // Pagination : s'il reste des trucs à afficher, on ajoute le lien vers les articles suivants
// Facyla 20110415 : controls the RSS output (avoid injecting un-held content that doesn't fit into XML)
  if ($viewtype != "rss") {
    if ($i >= $limit) {
      if (count($blogs_ent) > $limit) {
        $next_offset = $offset + $limit;
        if (!empty($pagination)) $pagination .= ' . . . . . ';
        $pagination .= '<a href="' . $CONFIG->url . '?offset=' . $next_offset . '&limit=' . $limit . '" class="pagination next">Articles suivants</a>';
      }
      break;
    }
  } else {
    if ($i >= 30) { break; }
  }
}
echo $blogs . $pagination;

