<?php
/**
* Elgg read CMS page view
* @package Elggcmspages
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla
* @copyright Facyla 2011
* @link http://id.facyla.fr/
* Note : This view may render more than the pure content (description), as it's used 
*/

if ($vars['pagetype']) {
  
  $cmspages = get_entities_from_metadata('pagetype', $vars['pagetype'], "object", "cmspage", 0, 1, 0, "", 0, false);
  
  if ($cmspages) {
    
    $cmspage = $cmspages[0];
    $title = $cmspage->pagetitle;
    
    if($cmspage) {
      $content = $cmspage->description 
        . elgg_view('output/tags', array('tags' => $cmspage->tags));
    /*
      $content .= $cmspage->guid; // who cares ?
      $content .= $cmspage->access_id;
      // These are for future developments
      $content .= $cmspage->container_guid; // should be set as page_owner
      $content .= $cmspage->parent_guid; // can be used for vertical links
      $content .= $cmspage->sibling_guid; // can be used for horizontal links
    */
    } else {
      register_error(elgg_echo('cmspages:notset'));
      forward();
    }
    
    set_context(elgg_echo('item:object:cmspages') . '&nbsp;: ' . $title);
    
    // Users who can edit this should get a direct edit link
    if ( isloggedin() && (in_array($_SESSION['guid'], explode(',', get_plugin_setting('editors', 'cmspages')))) || isadminloggedin() || (is_plugin_enabled('multisite') && (isadminloggedin() || is_community_creator())) ) {
      $content .= '<small><p style="text-align:right;"><a href="' . $vars['url'] . 'pg/cmspages/index.php?pagetype=' . $vars['pagetype'] . '"><kbd>[&nbsp;Modifier&nbsp;]</kbd></a></p></small>';
    }

    // Display through the correct canvas area
    $content = elgg_view('page_elements/contentwrapper', array('body' => $content));
    echo elgg_view_layout("one_column", elgg_view_title($title) . $content);
  }
}
