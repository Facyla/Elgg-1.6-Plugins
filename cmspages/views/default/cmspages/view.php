<?php
/**
* Elgg read CMS page view
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2011
* @link http://id.facyla.fr/
* Note : this view is designed for inclusion into other views
*/

if ($vars['pagetype']) {
  
  $cmspages = get_entities_from_metadata('pagetype', $vars['pagetype'], "object", "cmspage", 0, 1, 0, "", 0, false);
  
  if ($cmspages) {
    
    $cmspage = $cmspages[0];
    $title = $cmspage->pagetitle;
    
    if($cmspage) {
      echo $cmspage->description;
      echo '<span style="display:none;">';
      echo elgg_view('output/tags', array('tags' => $cmspage->tags));
/*
      $content .= $cmspage->guid; // who cares ?
      $content .= $cmspage->access_id;
      // These are for future developments
      $content .= $cmspage->container_guid; // should be set as page_owner
      $content .= $cmspage->parent_guid; // can be used for vertical links
      $content .= $cmspage->sibling_guid; // can be used for horizontal links
*/
      echo '</span>';
    }
  }
  
  // Users who can edit this should get a direct edit link
  if ( isloggedin() && (in_array($_SESSION['guid'], explode(',', get_plugin_setting('editors', 'cmspages')))) || isadminloggedin() || (is_plugin_enabled('multisite') && (isadminloggedin() || is_community_creator())) ) {
    echo '<small><p style="text-align:right;"><a href="' . $vars['url'] . 'pg/cmspages/index.php?pagetype=' . $vars['pagetype'] . '"><kbd>[&nbsp;Modifier&nbsp;]</kbd></a></p></small>';
  }
  
}
