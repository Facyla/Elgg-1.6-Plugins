<?php
// Get the Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();
global $CONFIG, $protovis_library;
// Load protovis once, only if needed
if (!$protovis_library) {
  $area1 = '<script type="text/javascript" src="' . $CONFIG->url . 'mod/protovis/assets/protovis-r3.2.js"></script>';
  $protovis_library = true;
}


set_page_owner($_SESSION['user']->guid);

// Get the plugin settings
$title = elgg_echo('protovis:experience');

/* Visualization parameters */
$width = 800; // Global width of figure
$height = 400; // Global height of figure
$padding = 20; // Inner margin (content display in it)
$transp = 0.4; // Initial transparency
$txttransp = 0.7; // Initial text transparency
$linkhover = "Cliquez pour en savoir plus sur";

$user_guid = get_input('id', $_SESSION['user']->guid);
$user = get_entity($user_guid);

/* NOTES
L'axe des ordonnées prend des valeurs de 0 à 100, l'axe des abscisses des valeurs variables selon le $timeframe défini par les dates fournies
*/

if (get_plugin_setting('education', 'resume') == 'yes') {
  $educations = get_user_objects($user_guid, 'education', 0, 0);
  foreach ($educations as $ent) {
    $dat1 .= '{name:"' . addslashes($ent->heading) . '", start:' . $ent->startdate . ', end:' . $ent->enddate . ', link:"' . addslashes($ent->getURL()) . '", details:"' . addslashes($ent->title) . '", level:' . $ent->importance . ', color:"rgba(200, 200, 0, ' . $transp . ')" }, ';
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}
if (get_plugin_setting('workexperience', 'resume') == 'yes') {
  $workexperiences = get_user_objects($user_guid, 'workexperience', 0, 0);
  foreach ($workexperiences as $ent) {
    $dat2 .= ' {name:"' . addslashes($ent->structure) . '", start:' . $ent->startdate . ', end:' . $ent->enddate . ', link:"' . addslashes($ent->getURL()) . '", details:"' . addslashes($ent->title) . '", level:' . $ent->importance . ', color:"rgba(0, 200, 200, ' . $transp . ')" }, ';
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}
if (get_plugin_setting('experience', 'resume') == 'yes') {
  $experiences = get_user_objects($user_guid, 'experience', 0, 0);
  foreach ($experiences as $ent) {
    $dat3 .= ' {name:"' . addslashes($ent->heading) . '", start:' . $ent->startdate . ', end:' . $ent->enddate . ', link:"' . addslashes($ent->getURL()) . '", details:"' . addslashes($ent->title) . '", level:' . $ent->importance . ', color:"rgba(200, 0, 200, ' . $transp . ')" }, ';
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}
/*
if (get_plugin_setting('skill', 'resume') == 'yes') {
  $skills = get_user_objects($user_guid, 'skill', 0, 0);
  foreach ($skills as $ent) {
    $dat4 .= ' {name:"' . addslashes($ent->title) . '", start:' . $ent->startdate . ', end:' . $ent->enddate . ', link:"' . addslashes($ent->getURL()) . '", details:"' . addslashes($ent->title) . '", level:' . $ent->importance . ', color:"rgba(200, 0, 0, ' . $transp . ')" }, ';
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}
if (get_plugin_setting('skill_ciiee', 'resume') == 'yes') {
  $skill_ciiees = get_user_objects($user_guid, 'skill_ciiee', 0, 0);
  foreach ($skill_ciiees as $ent) {
    $dat5 .= ' {name:"' . addslashes($ent->title) . '", start:' . $ent->startdate . ', end:' . $ent->enddate . ', link:"' . addslashes($ent->getURL()) . '", details:"' . addslashes($ent->title) . '", level:' . $ent->importance . ', color:"rgba(0, 200, 0, ' . $transp . ')" }, ';
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}
*/

/*
$upperdata = '[' . $dat1 . $dat2 . ']';
$lowerdata = '[' . $dat3 . ']';
*/
$upperdata = '[' . $dat2 . ']';
$lowerdata = '[' . $dat1 . ']';

/*
$firstdate = date('Y', $firstdate); // début abscisses en années
$lastdate = date('Y', $lastdate); // fin abscisses en années
$timeframe = $lastdate - $firstdate; // en années
*/

$startaxis = date('Y', $firstdate); // début abscisses en années
$endaxis = date('Y', $lastdate)+1; // fin abscisses en années
$firstdate = mktime(0, 0, 0, 1, 1, $startaxis); // Extension en début d'année
$lastdate = mktime(0, 0, 0, 1, 1, $endaxis); // Extension en début d'année suivante
$timeframe = $lastdate - $firstdate; // en secondes
$hrange = 60*60*24*365;
$xratio = ($width - 2*$padding) / $timeframe;
$yratio = ($height/2 - 10) / 100;

/* Styles */
$area1 .= '<style type="text/css">
.figure { width:' . $width . 'px; height:' . $height . 'px; border:1px solid black; float:left; margin:0 0 2px 5px; }
.large { font-size: medium; }
.protovis_experience_legend { float:left; width:30px; height:16px; margin:0px 10px 10px 10px; border:1px solid black; opacity:' . $transp . '; filter:alpha(opacity=' . $transp*100 . '); }
.protovis_experience_legend:hover { opacity:0.9; filter:alpha(opacity=90); }
</style>';

$area1 .= elgg_echo('protovis:experience:description') . '<br />';

/* Légende */
$area1 .= <<<EOT
<div style="float:right; margin:0 6px 2px 0; padding:6px; width:220px;">
  <h4>Légende</h4>
  <br />
  <div class="protovis_experience_legend" style="background:rgb(200,200,0);"></div>Etudes et formations
  <div class="clearfloat"></div>
  <div class="protovis_experience_legend" style="background:rgb(0,200,200);"></div>Expériences professionnelles<br />
  <div class="clearfloat"></div>
  <div class="protovis_experience_legend" style="background:rgb(200,0,200);"></div>Autres expériences<br />
  <div class="clearfloat"></div>
  <b>Notes :</b>
  <ul>
    <li><em>L'ensemble des éléments d\'une catégorie sont mis en valeur au survol.</em></li>
    <li><em>Chacun des "blocs" est cliquable et vous renvoie sur la page détaillée de l'élément.</em></li>
  </ul>
</div>
EOT;


/* Construction du chronogramme */
$area1 .= <<<EOT
<!--
Création du graphique en cours, veuillez patienter quelques instants...
//-->

<div class="figure">
<script type="text/javascript+protovis">
var xratio = $xratio; // max usable width / max end
var yratio = $yratio; // max usable height / max level
var correction = $firstdate; // correction so that values start at 0

var vis = new pv.Panel()
  .width($width)
  .height($height);

/* Règles horizontales */
vis.add(pv.Rule)
  .data(pv.range(0, 200 +1, 20))
  .top(function(d) 10 + d*yratio)
  .left($padding)
  .width($width - 2*$padding)
  .strokeStyle(pv.color('rgba(0, 0, 0, $transp)'));

/* Règles verticales */
vis.add(pv.Rule)
  .data(pv.range($firstdate, $lastdate +1, $hrange))
  .left(function(d) $padding + (d - correction) * xratio)
  .top(10)
  .height($height - 20)
  .strokeStyle(pv.color('rgba(0, 0, 0, $transp)'));

/* Valeurs partie supérieure */
vis.add(pv.Bar)
  .data($upperdata)
  .bottom($height/2)
  .width(function(d) (d['end'] - d['start']) *xratio +1)
  .height(function(d) (d.level) *yratio)
  .left(function(d) $padding + ((d['start'] - correction) *xratio))
  .fillStyle(function(d) pv.color(d['color']))
  .strokeStyle(function(d) pv.color(d['color']).darker())
  .cursor("pointer")
  .title(function(d) "$linkhover " + d['details'])
  .event("mouseover", function(d) {
      this.strokeStyle(function() pv.color(d['color']).darker().alpha(1));
      this.fillStyle(function() pv.color(d['color']).alpha(0.9));
      return vis;
    })
  .event("mouseout", function(d) {
      this.strokeStyle(function() pv.color(d['color']).darker());
      this.fillStyle(function() pv.color(d['color']).alpha($transp));
      return vis;
    })
  .event("click", function(d) self.location = d['link'])
  .anchor("left top").add(pv.Label)
    .textStyle(pv.color('rgba(0, 0, 0, $txttransp)'))
    .textBaseline("bottom")
    .textAlign('left')
    .textAngle(-Math.PI / 2)
    .text(function(d) d['name']);

/* Valeurs partie inférieure  */
vis.add(pv.Bar)
  .data($lowerdata)
  .top($height/2)
  .width(function(d) (d['end'] - d['start']) *xratio +1)
  .height(function(d) (d.level) *yratio)
  .left(function(d) $padding + ((d['start'] - correction) *xratio))
  .fillStyle(function(d) pv.color(d['color']))
  .strokeStyle(function(d) pv.color(d['color']).darker())
  .cursor("pointer")
  .title(function(d) "$linkhover " + d['details'])
  .event("mouseover", function(d) {
      this.strokeStyle(function() pv.color(d['color']).darker().alpha(1));
      this.fillStyle(function() pv.color(d['color']).alpha(0.9));
      return vis;
    })
  .event("mouseout", function(d) {
      this.strokeStyle(function() pv.color(d['color']).darker());
      this.fillStyle(function() pv.color(d['color']).alpha($transp));
      return vis;
    })
  .event("click", function(d) self.location = d['link'])
  .anchor("bottom").add(pv.Label)
    .textStyle(pv.color('rgba(0, 0, 0, $txttransp)'))
    .textBaseline("bottom")
    .textAlign('top')
    .textAngle(-Math.PI / 2)
    .text(function(d) d['name']);

/* Axe horizontal */
vis.add(pv.Bar)
  .top(function(d) $height/2 -1)
  .height(2)
  .width($width)
  .fillStyle('black')
  .anchor("left").add(pv.Label)
    .top($height/2 + 10)
    .left($padding + ($firstdate - correction) *xratio)
    .textStyle('black')
    .textAlign('center')
    .text('$startaxis')
  .anchor("right").add(pv.Label)
    .top($height/2 + 10)
    .left($padding + ($lastdate - correction) *xratio)
    .textStyle('black')
    .textAlign('center')
    .text('$endaxis');

vis.render();

</script>
</div>

EOT;


// Setup page
$body = elgg_view_layout('one_column', elgg_view_title($title) . '<div class="contentWrapper" style="padding:5px 10px; min-height:600px;">' . $area1 . '</div>');
  
// Display page
echo page_draw(elgg_echo($title),$body);
