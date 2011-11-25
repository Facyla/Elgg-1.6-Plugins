<?php
/**
 * Elgg Europass XML output pageshell
 * 
 * @package Elgg
 * @subpackage Core
 * @author Facyla
 * @link http://www.formavia.fr/
 * 
 */
global $CONFIG;
$user = page_owner_entity();
if ($user === false || is_null($user)) {
  $user = get_loggedin_user();
  set_user(get_loggedin_userid());
}

header("Content-Type: text/xml");
header("Content-Length: " . strlen($vars['body']));

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<?xml-stylesheet href="' . $vars['url'] . 'mod/resume/cv_fr_FR_V2.0.xsl" type="text/xsl"?>' . "\n";
echo '<europass:learnerinfo xmlns:europass="http://europass.cedefop.europa.eu/Europass/V2.0"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://europass.cedefop.europa.eu/Europass/V2.0 http://europass.cedefop.europa.eu/xml/EuropassSchema_V2.0.xsd"
  locale="fr_FR">' . "\n";

echo elgg_view('resume/resume', array('entity' => $user));

echo '</europass:learnerinfo>' . "\n";
