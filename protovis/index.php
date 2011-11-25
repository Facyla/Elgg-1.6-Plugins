<?php
// Get the Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

gatekeeper();

// Get the plugin settings
$title = elgg_echo('protovis:');

global $CONFIG;
$url = $CONFIG->url;


$area1 = '<h3>Tests "réseaux"</h3>
  <ul>
    <li><a href="' . $url . 'mod/protovis/network.php">Réseau global (long à charger, et a fortement tendance à "diverger")</a></li>
    <li><a href="' . $url . 'mod/protovis/user_network.php">Son propre réseau (ses contacts)</a></li>
    <li><a href="' . $url . 'mod/protovis/user2_network.php">Test réseau</a></li>
    <li><a href="' . $url . 'mod/protovis/group_network.php">Test réseau de groupes</a></li>
  </ul>
  <h3>Tests chronogrammes</h3>
  <ul>
    <li><a href="' . $url . 'mod/protovis/experience.php">Test visualisation chronogramme</a></li>
    <li><a href="' . $url . 'mod/protovis/user_experience.php">Première version du chronogramme appuyé sur les données du CV</a></li>
    <li><a href="' . $url . 'mod/protovis/user2_experience.php">Version de développement du chronogramme appuyé sur les données du CV</a></li>
  </ul>
  <h3>Chronogramme en fonctionnement</h3>
  <ul>
    <li><a href="' . $url . 'mod/resume/chronogramme.php">Intégré dans la fonctionnalité "CV" (plugin "resume")</a></li>
  </ul>
  ';


// Setup page
$body = elgg_view_layout('one_column', elgg_view_title($title) . '<div class="contentWrapper" style="padding:5px 10px; min-height:600px;">' . $area1 . '</div>');
  
// Display page
echo page_draw(elgg_echo($title),$body);
