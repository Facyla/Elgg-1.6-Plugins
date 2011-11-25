<?php
/**
 * Elgg external pages: add/edit
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010
 * @link http://id.facyla.net/
 */

// Facyla : this tool is rather for local admins and webmasters than main admins
//if (is_plugin_enabled('multisite')) { multisite_admin_gatekeeper(); set_context('localmultisite'); } else { admin_gatekeeper(); set_context('admin'); }
// Facyla : this tool is rather for local admins and webmasters than main admins, so use custom access rights : OK if custom rights match, or use default behaviour
if (in_array($_SESSION['guid'], explode(',', get_plugin_setting('editors', 'cmspages')))) {
  set_context('cmspages_admin');
} else {
  if (is_plugin_enabled('multisite')) { multisite_admin_gatekeeper(); set_context('localmultisite'); } else { admin_gatekeeper(); set_context('admin'); }
}

action_gatekeeper(); // Make sure action is secure

/* Get input data */
$contents = get_input('cmspage_content', '', false);
$cmspage_title = get_input('cmspage_title');
$pagetype = friendly_title(get_input('pagetype')); // Needs to be URL-friendly

// Empty or very short pagetypes are not allowed
if (empty($pagetype) || strlen($pagetype) < 3 ) {
  register_error(elgg_echo('cmspages:unsettooshort'));
  forward("mod/cmspages/index.php");
}

$tags = get_input('cmspage_tags');
//$cmspage_guid = (int)get_input('cmspage_guid'); // not really used (pagetype are unique, as URL rely on them rather than GUID)
$access = get_input('access_id', ACCESS_DEFAULT);
// These are for future developments
$container_guid = get_input('container_guid');
$parent_guid = get_input('parent_guid');
$sibling_guid = get_input('sibling_guid');

// Cache to the session
$_SESSION['cmspage_title'] = $cmspage_title;
$_SESSION['cmspage_content'] = $contents;
$_SESSION['pagetype'] = $pagetype;
$_SESSION['cmspage_tags'] = $tags;

// Facyla 20110214 : following bypass is necessary when using Private access level, which causes objects not to be saved correctly (+doubles)
global $isadmin;
$isadmin = true;

// Get existing object, or create it
$cmspage = NULL;
if (strlen($pagetype)>0) {
  $cmspages = get_entities_from_metadata('pagetype', $pagetype, "object", "cmspage", 0, 1, 0, "", 0, false);
  $cmspage = $cmspages[0];
}
if ($cmspage instanceof ElggObject) { $cmspage_guid = $cmspage->getGUID(); } else { $cmspage = new ElggObject(); }


/* Edition de l'objet existant ou nouvellement créé */
//$cmspage->owner_guid = $_SESSION['user']->getGUID(); // Set owner to the current user
$cmspage->id = $cmspage_guid;
$cmspage->subtype = 'cmspage';
$cmspage->owner_guid = $CONFIG->site->guid; // Set owner to the current site (nothing personal, hey !)
$cmspage->access_id = $access;
$cmspage->pagetitle = $cmspage_title;
$cmspage->pagetype = $pagetype;
$cmspage->description = $contents;
$cmspage->container_guid = $CONFIG->site->guid;  // Set container to the current site (nothing personal, hey !)
$cmspage->parent_guid = $parent_guid;
$cmspage->sibling_guid = $sibling_guid;

// Save new/updated content
if (!$cmspage->save()) {
  register_error(elgg_echo("cmspages:error") . $_SESSION['guid'] . '=> ' . get_plugin_setting('editors', 'cmspages'));
  $isadmin = false;
  forward("mod/cmspages/index.php?pagetype=$pagetype");
}

// Now let's add tags. We can pass an array directly to the object property! Easy.
$tagarray = string_to_tag_array($tags); // Convert string of tags into a preformatted array
if (is_array($tagarray)) { $cmspage->tags = $tagarray; }


// Success message
system_message(elgg_echo("cmspages:posted"));
//add_to_river('river/cmspages/create','create',$_SESSION['user']->guid, $cmspages->guid); // add to river

// Remove the cache
unset($_SESSION['cmspage_content']); unset($_SESSION['cmspage_title']); unset($_SESSION['pagetype']); unset($_SESSION['cmspage_tags']);
      
$isadmin = false;

// Forward back to the page
forward("pg/cmspages/index.php?pagetype=$pagetype");
  
