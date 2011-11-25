<?php
// Affichage des contenus
foreach($vars['entities'] as $ent) {
  $body .= elgg_view('object/default', array('entity' => $ent));
  $i++;
  // Pagination : on limite à 30, et non à la limite d'articles par page (trop faible)
  if ($i >= 30) { break; }
}

echo $body;

