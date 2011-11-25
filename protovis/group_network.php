<?php
  // Get the Elgg engine
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
  
  gatekeeper();
  
  // Get the plugin settings
  $title = elgg_echo('protovis:network');

  global $CONFIG, $protovis_library;
  // Load protovis once, only if needed
  if (!$protovis_library) {
    $area1 = '<script type="text/javascript" src="' . $CONFIG->url . 'mod/protovis/assets/protovis-r3.2.js"></script>';
    $protovis_library = true;
  }

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
  
  $members = get_entities('user', '', '', '', 99999);
  $members2 = $members;
  $groups = get_entities('group', '', '', '', 99999);

/* Note : ça serait intéressant de visualiser les liens entre groupes (1 couleur), membres (1 autre) et objects (3e) par rapport à une thématique (tags ou sujet de recherche, 4e couleur)
*/  
  // Listing des users
  $area1 .= '<script type="text/javascript">var membresreseau = { nodes:[';
  foreach($members as $member) {
    $nb_friends = count($member->getFriendsOf('user', 9999));
    $group_id = $nb_friends + 2; // 1 = couleur pour les groupes
    $nb_groups = get_entities_from_relationship('member', $member->guid, false, "group", "", 0, "", 9999, 0, true, 0);
    $area1 .= '{nodeName:"' . $member->name . '", group:' . $group_id . ', nodeInfo :"' . $nb_groups . ' groupes et ' . $nb_friends . ' contacts"},';
  }
  // et des groupes
  foreach($groups as $group) { $area1 .= '{nodeName:"' . $group->name . '", group:1, nodeInfo :"Groupe ' . $group->name . '"},'; }
  
  // Puis les liens
  $area1 .= '], links:[';
  // Pour chaque user, listing de ses contacts (doivent être dans le même ordre : on se base sur l'index de members[]
  $i = 0;
  foreach($members as $source) {
    // Membres
    $j = 0;
    foreach($members2 as $target) {
    // Une piste : donner comme index dans le tableau les guid de smembres, ça faciliterait le travail pour les relations..
      // S'ils sont en contact, on relie
      if($source->isFriendOf($target->guid)) { $area1 .= '{source:' . $i . ', target:' . $j . ', value:' . $value . '},'; }
      $j++;
    }
    $i++;
    // Groupes
    $k = 0 + count($members);
    foreach($groups as $group) {
      if($group->isMember($source->guid)) {
        $area1 .= '{source:' . $i . ', target:' . $k . ', value:1},';
      }
      $k++;
    }
  }
  $area1 .= '], };</script>';

  $area1 .= <<<EOT

<script type="text/javascript+protovis">

var w = document.body.clientWidth,
  h = document.body.clientHeight,
  colors = pv.Colors.category19();

var vis = new pv.Panel()
//  .width(w)
  .width(1000)
//  .height(h)
  .height(800)
  .fillStyle("white")
  .event("mousedown", pv.Behavior.pan())
  .event("mousewheel", pv.Behavior.zoom());

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

  // Setup page
	$body = elgg_view_layout('one_column', elgg_view_title($title) . '<div class="contentWrapper" style="padding:5px 10px; min-height:600px;">' . $area1 . '</div>');
		
	// Display page
	echo page_draw(elgg_echo($title),$body);
