<?php
  // Get the Elgg engine
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
  
  gatekeeper();
  
  // Get the plugin settings
  $title = sprintf(elgg_echo('protovis:user:network'), get_entity($_SESSION['guid'])->name);
  
  global $CONFIG, $protovis_library;
  // Load protovis once, only if needed
  if (!$protovis_library) {
    $area1 = '<script type="text/javascript" src="' . $CONFIG->url . 'mod/protovis/assets/protovis-r3.2.js"></script>';
    $protovis_library = true;
  }


  // URL settings
  $self_display = get_input('self_display', "yes");

/*
 {nodeName:" $nodename ", group: $groupnum },
   string $nodename : nom du noeud
   int $groupnum : n° du groupe (séquentiel [1,infini])
 {source: $source , target: $target , value: $value },
   int $source : noeud source (en commençant à 0)
   int $target : noeud cible
   int $value : fréquence (intensité de la relation)
*/
// Default values
  $nodename = ""; $groupnum = 1; $source = null; $target = null; $value = 3;
  
//  $members = get_entities('user', '', '', '', 99999);
  $user = get_entity($_SESSION['guid']);
  $members = $user->getFriends("user", 99999, 0); // Les contacts
  $members2 = $members;
  $groups = get_entities_from_relationship('member', $user->guid, false, "group", "", 0, "", 9999, 0, false, 0); // Les groupes de l'utilisateur seulement
  if($self_display != "no") { $members[] = $user; } // et l'user en cours par défaut

/* Note : ça serait intéressant de visualiser les liens entre groupes (1 couleur), membres (1 autre) et objects (3e) par rapport à une thématique (tags ou sujet de recherche, 4e couleur)
*/

  // Réseau d'un utilisateur
  $area1 .= '<script type="text/javascript">var membresreseau = { nodes:[';
  foreach($members as $member) {
    $nb_friends = count($member->getFriendsOf('user', 9999));
    $nb_groups = count($groups);
    $group_id = $nb_groups + $nb_friends + 2; // Couleur dépend des groupes + contacts. Valeur 1 réservée = couleur pour les groupes
    $info = $member->name . ': ' . $nb_friends . ' contacts';
    $area1 .= '{nodeName:"' . $member->name . '" , group:' . $group_id . ', nodeInfo :"' . $info . '"},';
  }
  // et des groupes
  foreach($groups as $group) { $area1 .= '{nodeName:"' . $group->name . '", group:1000, nodeInfo :"Groupe ' . $group->name . '"},'; }
  
  $area1 .= '], links:[';
  
  // Pour chaque user considéré, listing de ses contacts (doivent être dans le même ordre : on se base sur l'index de members[]
  $i = 0;
  foreach($members as $source) {
    $j = 0;
    foreach($members2 as $target) {
      if($source instanceOf ElggUser && $target instanceOf ElggUser) {
        // S'ils sont en contact, on relie
        if($source->isFriendOf($target->guid)) { $area1 .= '{source:' . $i . ', target:' . $j . ', value:' . $value . '},'; }
      }
      $j++;
    }
    // et de ses Groupes (parmi ceux de l'user connecté)
// C'est marrant mais ça rend le graphe illisible sous la forme actuelle...
if( $source->guid == $user->guid) {
    $k = 0 + count($members); // Les groupes sont à la suite des membres..
    foreach($groups as $group) {
      if($group->isMember($source->guid)) { $area1 .= '{source:' . $k . ', target:' . $i . ', value:1},'; }
      $k++;
    }
}
    $i++;
  }
  $area1 .= '], };</script>';

  $area1 .= <<<EOT
<style>
#protovis_container { padding:5px 10px; min-height:300px; width:auto; height:500px; }
</style>
<script type="text/javascript+protovis">

//var colors = pv.Colors.category20(),
var colors = pv.Scale.linear(0, 100, 500, 1000).range('blue', 'red', 'red', 'green'),
  w = $('#protovis_container').css('width'),
  h = $('#protovis_container').css('height');
  var w = parseInt(w, 10), h = parseInt(h, 10);

var vis = new pv.Panel()
  .width(w)
  .height(h)
  .fillStyle("white")
  .event("mousedown", pv.Behavior.pan())
  .event("mousewheel", pv.Behavior.zoom(.3));

var force = vis.add(pv.Layout.Force)
  .nodes(membresreseau.nodes)
  .links(membresreseau.links);

force.link.add(pv.Line);

force.node.add(pv.Dot)
  .size(function(d) (d.linkDegree + 4) * Math.pow(this.scale, -1.5))
  .fillStyle(function(d) d.fix ? "brown" : colors(d.group))
  .strokeStyle(function() this.fillStyle().darker())
  .lineWidth(1)
  .title(function(d) d.nodeInfo)
  .event("mousedown", pv.Behavior.drag())
  .event("drag", force)
  .anchor("top").add(pv.Label)
    .textStyle('black')
    .textAlign('center')
    .text(function(d) d.nodeName);

vis.render();

</script>

EOT;

  $legend = "<h4>Présentation et légende $self_display</h4>
    Cette page représente graphiquement votre réseau relationnel tel qu'il est constitué sur ce site, à partir de vos contacts et des relations entre ces contacts :
    <ul>
      <li>Les liens représentent les relations entre les personnes et les groupes.</li>
      <li>La couleur des points est liée au nombre de contacts de chacune des personnes</li>
      <li>la taille des points est proportionnelle au nombre de contacts (parmi vos contatcs) de la personne, c'est à dire que les points les plus gros représentent les personnes qui ont le plus de contacts communs avec vous</li>
      <li>Il est possible de vous inclure ou non dans ce réseau : ";
      $legend .= ($self_display != "no") ? "<a href=\"" . $_SERVER['$SCRIPT_FILENAME'] . "?self_display=no\">Ne pas m'inclure</a>" : "<a href=\"" . $_SERVER['$SCRIPT_FILENAME'] . "?self_display=yes\">M'inclure</a>";
      $legend .= "</li>
      <li>Utilisez la roulette de la souris pour zoomer ou dézoomer</li>
      <li>Cliquez et déplacez le fond de carte pour vous déplacer dedans</li>
      <li>Cliquez et déplacez un point, ou laissez la souris dessus pour afficher des informations supplémentaires</li>
    </ul>
    Faites part de vos remarques afin d'améliorer cette représentation !<br /><br />";
  $area1 = elgg_view_title($title) . '<div class="contentWrapper">' . $legend . '<div id="protovis_container">' . $area1 . '</div><div class="clearfloat"></div></div>';
  // Setup page
	$body = elgg_view_layout('one_column', $area1);
		
	// Display page
	echo page_draw(elgg_echo($title),$body);
