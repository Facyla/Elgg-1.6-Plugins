<?php
$t1 = microtime(true);

require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

// Basic operations : gatekeeper, pageowner, GET, etc.
gatekeeper();
$user_guid = get_input('id', $_SESSION['user']->guid);
$user = get_entity($user_guid);
set_page_owner($user_guid);
$title = elgg_echo('protovis:experience');

global $CONFIG, $protovis_library;
// Load protovis once, only if needed
if (!$protovis_library) {
  $area1 = '<script type="text/javascript" src="' . $CONFIG->url . 'mod/protovis/assets/protovis-r3.2.js"></script>';
  $protovis_library = true;
}

/* Main visualization parameters */
$width = 800; // Global width of figure
$height = 400; // Global height of figure
$padding = 20; // Inner margin (content display in it)
$transp = 0.4; // Initial transparency
$txttransp = 0.7; // Initial text transparency
$linkhover = "Cliquez pour en savoir plus sur";


// FONCTIONS UTILISEES POUR LA GENERATION DU JAVASCRIPT
/* Génère le code JS utilisé pour l'affichage des éléments supérieurs du chronogramme */
function protovis_experience_addupperbar($entity, $config, $color) {
  // note : $config ne doit jamais provenir d'une saisie utilisateur
  extract($config);
  $correction = $firstdate;
  // récupération des données utilisées
  $name = addslashes($entity->heading);
  $start = $entity->startdate;
  $end = $entity->enddate;
  $link = addslashes($entity->getURL());
  $details = "$linkhover " . addslashes($entity->title);
  $level = $entity->importance;
  // Construction de l'élément graphique
  $return = <<<EOT
vis.add(pv.Bar)
  .bottom($height/2)
  .width(($end - $start) *$xratio +1)
  .height($level *$yratio)
  .left($padding + (($start - $correction) *$xratio))
  .fillStyle(pv.color('$color'))
  .strokeStyle(pv.color('$color').darker())
  .cursor("pointer")
  .title("$details")
  .event("mouseover", function() {
      this.strokeStyle(function() pv.color('$color').darker().alpha(1));
      this.fillStyle(function() pv.color('$color').alpha(0.9));
      return vis;
    })
  .event("mouseout", function() {
      this.strokeStyle(function() pv.color('$color').darker());
      this.fillStyle(function() pv.color('$color').alpha($transp));
      return vis;
    })
  .event("click", function() self.location = '$link')
  .anchor("left top").add(pv.Label)
    .textStyle(pv.color('rgba(0, 0, 0, $txttransp)'))
    .textBaseline("bottom")
    .textAlign('left')
    .textAngle(-Math.PI / 2)
    .text("$name");

EOT;
  return $return;
}
/* Génère le code JS utilisé pour l'affichage des éléments inférieurs du chronogramme */
function protovis_experience_addlowerbar($entity, $config, $color) {
  // note : $config ne doit jamais provenir d'une saisie utilisateur
  extract($config);
  $correction = $firstdate;
  // récupération des données utilisées
  $name = addslashes($entity->heading);
  $start = $entity->startdate;
  $end = $entity->enddate;
  $link = addslashes($entity->getURL());
  $details = "$linkhover " . addslashes($entity->title);
  $level = $entity->importance;
  // Construction de l'élément graphique
  $return = <<<EOT
vis.add(pv.Bar)
  .top($height/2)
  .width(($end - $start) *$xratio +1)
  .height($level *$yratio)
  .left($padding + (($start - $correction) *$xratio))
  .fillStyle(pv.color('$color'))
  .strokeStyle(pv.color('$color').darker())
  .cursor("pointer")
  .title("$details")
  .event("mouseover", function() {
      this.strokeStyle(function() pv.color('$color').darker().alpha(1));
      this.fillStyle(function() pv.color('$color').alpha(0.9));
      return vis;
    })
  .event("mouseout", function() {
      this.strokeStyle(function() pv.color('$color').darker());
      this.fillStyle(function() pv.color('$color').alpha($transp));
      return vis;
    })
  .event("click", function() self.location = '$link')
  .anchor("left top").add(pv.Label)
    .textStyle(pv.color('rgba(0, 0, 0, $txttransp)'))
    .textBaseline("bottom")
    .textAlign('left')
    .textAngle(-Math.PI / 2)
    .text("$name");

EOT;
  return $return;
}
// FIN FONCTIONS UTILISEES POUR LA GENERATION DU JAVASCRIPT


$t2 = microtime(true);
/* NOTE : l'axe des ordonnées prend des valeurs de 0 à 100, l'axe des abscisses des valeurs variables selon le $timeframe défini par les dates fournies
*/

if (get_plugin_setting('education', 'resume') == 'yes') {
  //$educations = get_user_objects($user_guid, 'education', 0, 0);
  $educations = get_entities_from_metadata ("startdate", "", "object", "education", $user_guid, 999, 0, "", -1, false);
  foreach ($educations as $ent) {
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}
if (get_plugin_setting('workexperience', 'resume') == 'yes') {
  //$workexperiences = get_user_objects($user_guid, 'workexperience', 0, 0);
  $workexperiences = get_entities_from_metadata ("startdate", "", "object", "workexperience", $user_guid, 999, 0, "", -1, false);
  foreach ($workexperiences as $ent) {
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}
if (get_plugin_setting('experience', 'resume') == 'yes') {
  $experiences = get_user_objects($user_guid, 'experience', 0, 0);
  foreach ($experiences as $ent) {
    if (($ent->startdate < $firstdate) || !isset($firstdate)) $firstdate = $ent->startdate;
    if (($ent->enddate > $lastdate) || !isset($lastdate)) $lastdate = $ent->enddate;
  }
}

$t3 = microtime(true);

// Computed visualization parameters
$startaxis = date('Y', $firstdate); // début abscisses en années
$endaxis = date('Y', $lastdate)+1; // fin abscisses en années
$firstdate = mktime(0, 0, 0, 1, 1, $startaxis); // Extension en début d'année
$lastdate = mktime(0, 0, 0, 1, 1, $endaxis); // Extension en début d'année suivante
$timeframe = $lastdate - $firstdate; // en secondes
$hrange = 60*60*24*365;
$xratio = ($width - 2*$padding) / $timeframe;
$yratio = ($height/2 - 10) / 100;

// Set a useful array passed to functions
$PROTOVIS_EXPERIENCE = array(
    'width' => $width,
    'height' => $height,
    'padding' => $padding,
    'transp' => $transp,
    'txttransp' => $txttransp,
    'linkhover' => $linkhover,
    'startaxis' => $startaxis,
    'endaxis' => $endaxis,
    'firstdate' => $firstdate,
    'lastdate' => $lastdate,
    'timeframe' => $timeframe,
    'hrange' => $hrange,
    'xratio' => $xratio,
    'yratio' => $yratio,
  );
  

foreach ($educations as $ent) {
  $js_upper .= protovis_experience_addupperbar($ent, $PROTOVIS_EXPERIENCE, "rgba(200,200,0,$transp)");
  // Pour un listing chronologique
  $dat1 .= date('m/Y',$ent->startdate) . ' - ' . date('m/Y',$ent->enddate) . ' : <a href="' . $ent->getURL() . '">' . $ent->heading . '</a> (' . $ent->importance . '%) - ' . $ent->title . '<br />';
}
foreach ($workexperiences as $ent) {
  $js_lower .= protovis_experience_addlowerbar($ent, $PROTOVIS_EXPERIENCE, "rgba(0,200,200,$transp)");
  // Pour un listing chronologique
  $dat2 .= date('m/Y',$ent->startdate) . ' - ' . date('m/Y',$ent->enddate) . ' : <a href="' . $ent->getURL() . '">' . $ent->heading . '</a> (' . $ent->importance . '%) - ' . $ent->title . '<br />';
}
foreach ($experiences as $ent) {
  $js_lower .= protovis_experience_addlowerbar($ent, $PROTOVIS_EXPERIENCE, "rgba(200,0,200,$transp)");
  // Pour un listing chronologique
  $dat3 .= date('m/Y',$ent->startdate) . ' - ' . date('m/Y',$ent->enddate) . ' : <a href="' . $ent->getURL() . '">' . $ent->heading . '</a> (' . $ent->importance . '%) - ' . $ent->title . '<br />';
}

$t4 = microtime(true);


/* Construction de la page et du chronogramme */

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
    <li><em>Des informations complémentaires s'affichent au survol d'un élément.</em></li>
    <li><em>Chacun des "blocs" est cliquable et vous renvoie sur la page détaillée de l'élément.</em></li>
  </ul>
</div>
EOT;

/* Chronogramme : panel puis règles puis données puis l'axe horizontal */
// @todo : ajouter fond blanc au Panel et une image de chargement... => Création du graphique en cours, veuillez patienter quelques instants...
$area1 .= <<<EOT
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
$js_upper

/* Valeurs partie inférieure  */
$js_lower

/* Axe horizontal et dates début + fin */
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

$area1 .= '<div class="clearfloat"></div>
  Temps de calcul de la page : ' . (microtime(true) - $t1) . '<ul>
  <li>Engine, fonctions et initialisation = ' . ($t2 - $t1) . '</li>
  <li>Récupération des données = ' . ($t3 - $t2) . '</li>
  <li>Traitements et génération JS = ' . ($t4 - $t3) . '</li>
  </ul>';
$area1 .= $dat1 . '<br />' . $dat2;

// Setup page
$body = elgg_view_layout('one_column', elgg_view_title($title) . '<div class="contentWrapper" style="padding:5px 10px; min-height:500px;">' . $area1 . '</div>');
  
  
// Display page
echo page_draw($title,$body);
