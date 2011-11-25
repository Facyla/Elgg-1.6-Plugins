<?php
  // Get the Elgg engine
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
  
  gatekeeper();
  
  // Get the plugin settings
  $title = elgg_echo('protovis:experience');
  
  global $CONFIG, $protovis_library;
  // Load protovis once, only if needed
  if (!$protovis_library) {
    $area1 = '<script type="text/javascript" src="' . $CONFIG->url . 'mod/protovis/assets/protovis-r3.2.js"></script>';
    $protovis_library = true;
  }

  $area1 .= <<<EOT
<style type="text/css">
.figure { width:600px; height:400px; border:1px solid black; float:left; margin:2px 5px; }
.large { font-size: medium; }
</style>

<div class="figure">
  <script type="text/javascript+protovis">
  var vis = new pv.Panel()
    .width(600)
    .height(400);

  var xratio = 580 / 32; // max usable width / max end
  var yratio = (380/2) / 6; // max usable height / max level
  
  var bar = vis.add(pv.Bar)
/*
Level : de 0 à 6, valeurs négatives représentées sur [0,6], positives sur [6,12]
Start : en années
*/
    .data([
        {name:"Expérience 1", start:0, end:18, level:3, color:"rgba(0, 200, 200, 0.5)" }, 
        {name:"Expérience 2", start:20, end:26, level:5, color:"rgba(200, 0, 200, 0.5)" }, 
        {name:"Expérience 3", start:16, end:26, level:2, color:"rgba(200, 200, 0, 0.5)" }, 
        {name:"Expérience 4", start:6, end:12, level:4, color:"rgba(200, 0, 0, 0.5)" }, 
        {name:"Expérience 5", start:13, end:15, level:6, color:"rgba(0, 200, 0, 0.5)" }, 
        {name:"Expérience 6", start:23, end:28, level:4, color:"rgba(0, 0, 200, 0.5)" }, 
        {name:"Expérience 6", start:21, end:32, level:4, color:"rgba(0, 0, 200, 0.5)" }, 
      ])
    .bottom(function(d) 200)
    .width(function(d) (d['end'] - d['start']) *xratio +1)
    .height(function(d) (d.level) *yratio)
    .left(function(d) 10 + d.start *xratio)
    .fillStyle(function(d) pv.color(d['color']) )
//    .fillStyle(pv.Colors.category20().by(pv.index))
//    .fillStyle(pv.color('rgba(100, 100, 100, 0.5)'))
/*
    .strokeStyle( "black" )
    .event("mouseover", function() this.strokeStyle("red"))
    .event("mouseout", function() this.strokeStyle("black"))
*/
    .anchor("top").add(pv.Label)
      .textStyle(pv.color('rgba(0, 0, 0, 0.5)'))
      .textAlign('center')
      .text(function(d) d['name'] );
  
  var bar2 = vis.add(pv.Bar)
/* Level : de 0 à 10, valeurs négatives représentées sur [0,10], positives sur [10,20] */
    .data([
        {name:"Expérience 7", start:0, end:20, level:3, color:"rgba(0, 200, 200, 0.5)" }, 
        {name:"Expérience 8", start:14, end:16, level:5, color:"rgba(200, 0, 200, 0.5)" }, 
        {name:"Expérience 9", start:12, end:25, level:1, color:"rgba(200, 200, 0, 0.5)" }, 
        {name:"Expérience 10", start:3, end:6, level:6, color:"rgba(200, 0, 0, 0.5)" }, 
        {name:"Expérience 11", start:7, end:11, level:4, color:"rgba(0, 200, 0, 0.5)" }, 
        {name:"Expérience 12", start:23, end:27, level:1, color:"rgba(0, 0, 200, 0.5)" }, 
      ])
    .top(function(d) 200)
    .width(function(d) (d['end'] - d['start']) *xratio +1)
    .height(function(d) (d.level) *yratio)
    .left(function(d) 10 + d.start *xratio)
//    .fillStyle(pv.Colors.category20().by(pv.index))
//    .fillStyle(pv.color('rgba(100, 100, 100, 0.5)'))
    .fillStyle(function(d) pv.color(d['color']) )
    .anchor("bottom").add(pv.Label)
      .textStyle(pv.color('rgba(0, 0, 0, 0.5)'))
      .textAlign('center')
      .text(function(d) d['name'] );

  var bar3 = vis.add(pv.Bar)
    .top(function(d) 200)
    .height(1)
    .width(600)
    .fillStyle('black')
    .anchor("left").add(pv.Label)
      .textStyle('black')
      .textAlign('left')
      .text('0');
  
  vis.render();

  </script>
</div>

EOT;

  // Setup page
	$body = elgg_view_layout('one_column', elgg_view_title($title) . '<div class="contentWrapper" style="padding:5px 10px; min-height:600px;">' . $area1 . '</div>');
		
	// Display page
	echo page_draw(elgg_echo($title),$body);
