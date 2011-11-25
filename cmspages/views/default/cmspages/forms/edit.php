<?php
/**
 * Elgg cmspages edit
 *
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010
 * @link http://id.facyla.net/
 *
*/

$pagetype = friendly_title($vars['pagetype']); //get the page type - used as a user-friendly guid

// empty pagetype or very short pagetypes are not allowed - we don't need the form in these cases
if (empty($pagetype)) {} 
else if (strlen($pagetype)<3) { register_error(elgg_echo('cmspages:unsettooshort')); } 
else {
  $cmspages = get_entities_from_metadata('pagetype', $pagetype, "object", "cmspage", 0, 1, 0, "", 0, false);

  if ($cmspages) {
    $cmspage = $cmspages[0];
    $title = $cmspage->pagetitle;
    $description = $cmspage->description;
    $tags = $cmspage->tags;
    $cmspage_guid = $cmspage->guid;
    $access = $cmspage->access_id;
    // These are for future developments
    $container_guid = $cmspage->container_guid;
    $parent_guid = $cmspage->parent_guid;
    $sibling_guid = $cmspage->sibling_guid;
  } else { $access = (defined("ACCESS_DEFAULT")) ? ACCESS_DEFAULT : ACCESS_PUBLIC; }

  // Set the required form variables
  $pagetype_input = '<label>' . elgg_echo('cmspages:pagetype') . ' <input type="text" value="'.$pagetype.'" disabled="disabled" style="width:300px;"</label>' . elgg_view('input/hidden', array('internalname' => 'pagetype', 'value' => $pagetype, 'disabled' => "disabled", 'js' => ' style="width:300px;"'));
  if ($cmspage instanceof ElggObject) $cmspage_url = '<br />' . elgg_echo('cmspages:cmspage_url') . ' <a href="' . $vars['url'] . 'pg/cmspages/read/' . $pagetype . '" target="_new" >' . $vars['url'] . 'pg/cmspages/read/' . $pagetype . '</a>';
  $title_input = elgg_echo('title') . " " . elgg_view('input/text', array('internalname' => 'cmspage_title', 'value' => $title, 'js' => ' style="width:500px;"'));
  $description_input = elgg_echo('description') . "<br/>" . elgg_view('input/longtext', array('internalname' => 'cmspage_content', 'value' => $description));
  $tag_input = elgg_echo('tags') . " " . elgg_view('input/tags', array('internalname' => 'cmspage_tags', 'value' => $tags, 'js' => ' style="width:500px;"'));
  //$cmspage_input = elgg_view('input/hidden', array('internalname' => 'cmspage_guid', 'value' => $cmspage_guid)); // We don't really care (not used)
  $access_input = elgg_echo('access') . ' ' . elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access, 'options' => array(
        ACCESS_PUBLIC => elgg_echo('PUBLIC'), 
        ACCESS_LOGGED_IN => elgg_echo('LOGGED_IN'), 
        ACCESS_PRIVATE => elgg_echo('PRIVATE'))
    ));
  // ACCESS_DEFAULT => elgg_echo('default_access:label') //("accès par défaut")

  // These are for future developments
  $container_input = elgg_view('input/hidden', array('internalname' => 'container_guid', 'value' => $container_guid));
  $parent_input = elgg_view('input/hidden', array('internalname' => 'parent_guid', 'value' => $parent_guid));
  $sibling_input = elgg_view('input/hidden', array('internalname' => 'sibling_guid', 'value' => $sibling_guid));

  if ($cmspage instanceof ElggObject) $submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('cmspages:save')));
  else $submit_input = elgg_view('input/submit', array('internalname' => 'submit', 'value' => elgg_echo('cmspages:create')));


  // Build the form
  $form_body = <<<EOT
    <label>$pagetype_input</label>$cmspage_url<br /><br />
    <label>$title_input</label><br /><br />
    <label>$description_input</label><div class="clearfloat"></div>
    <br />
    <label>$tag_input</label><br /><br />
    <label>$access_input</label><br />
    $container_input
    $parent_input
    $sibling_input
    $cmspage_input
    <br />
    $submit_input
EOT;

  // Display the form
  echo elgg_view('input/form', array('action' => $vars['url'] . "action/cmspages/edit", 'body' => $form_body));

}

