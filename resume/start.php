<?php
/**
 * Resume
 *
 * @package Resume
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
function resume_init() {

  global $CONFIG;

  // Add menu item to logged users
  if (isloggedin ()) {
    add_menu(elgg_echo('resume:menu:item'), $CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
  }
  
  // Extend profile - activated by default
  //extend_view('profile/userdetails', 'resume/extend_userdetails');
  
  // Resume widget - activated by default
  //if (get_plugin_setting('resumewidget') != "no") add_widget_type('resume',elgg_echo('resume:widget:title'),elgg_echo('resume:widget:description'), 'all', true);
  
  // Resume widget or extend profile - widget by default (both don't mix very well /togglers)
  if (get_plugin_setting('resumewidget') != "no") {
    add_widget_type('resume',elgg_echo('resume:widget:title'),elgg_echo('resume:widget:description'), 'all', false);
  } else {
    extend_view('profile/userdetails', 'resume/extend_userdetails');
  }
  
  // Extend profile menu to include resume item
  extend_view('profile/menu/links', 'resume/menu');

  // Extend CSS with plugin's CSS
  extend_view('css', 'resume/css');
  
  // Extend search - disabled by default
  if (get_plugin_setting('experience') == 'yes') register_entity_type('object', 'experience');
  if (get_plugin_setting('language') == 'yes') register_entity_type('object', 'language');
  if (get_plugin_setting('workexperience') == 'yes') register_entity_type('object', 'workexperience');
  if (get_plugin_setting('education') == 'yes') register_entity_type('object', 'education');
  if (get_plugin_setting('skill') == 'yes') register_entity_type('object', 'skill');
  if (get_plugin_setting('skill_ciiee') == 'yes') register_entity_type('object', 'skill_ciiee');
  
}


function resume_pagesetup() {
  global $CONFIG;
  $page_owner = page_owner_entity();
  $loggedin_username = get_loggedin_user()->username;

  //Add submenu items to the page
  if (get_context() == "resumes") {
    // Add page owner's exclusive items to menu
    if ($page_owner->guid == get_loggedin_user()->guid) {
      if (get_plugin_setting('education') == 'yes') add_submenu_item(elgg_echo('resume:add:education'), $CONFIG->wwwroot . "mod/resume/education.php");
      if (get_plugin_setting('workexperience') == 'yes') add_submenu_item(elgg_echo('resume:add:workexperience'), $CONFIG->wwwroot . "mod/resume/workexperience.php");
      if (get_plugin_setting('experience') == 'yes') add_submenu_item(elgg_echo('resume:add:experience'), $CONFIG->wwwroot . "mod/resume/experience.php");
      if (get_plugin_setting('skill') == 'yes') add_submenu_item(elgg_echo('resume:add:skill'), $CONFIG->wwwroot . "mod/resume/skill.php");
      if (get_plugin_setting('skill_ciiee') == 'yes') add_submenu_item(elgg_echo('resume:add:skill_ciiee'), $CONFIG->wwwroot . "mod/resume/skill_ciiee.php");
      if (get_plugin_setting('language') == 'yes') add_submenu_item(elgg_echo('resume:add:language'), $CONFIG->wwwroot . "mod/resume/language.php");
      if (is_plugin_enabled('protovis')) {
        add_submenu_item(elgg_echo('resume:chronogram'), $CONFIG->wwwroot . "mod/resume/chronogramme.php?id=" . $page_owner->guid, "main_resume");
        //add_submenu_item(elgg_echo('resume:skillgraph'), $CONFIG->wwwroot . "mod/resume/skillgraph.php"); // @todo
      }
      
    } else if (isloggedin ()) {
      // Not "Page owner's" exclusive items
      add_submenu_item(elgg_echo('resume:menu:goto'), $CONFIG->wwwroot . "pg/resumes/" . $loggedin_username);
      if (is_plugin_enabled('protovis')) {
        add_submenu_item(elgg_echo('resume:chronogram'), $CONFIG->wwwroot . "mod/resume/chronogramme.php?id=" . $page_owner->guid, "main_resume");
      }
    }
  }
  
  // Add "cancel" option if the user is in a create/edit form
  if (get_context() == "resumes_form") {
    add_submenu_item(elgg_echo('resume:menu:cancel'), $CONFIG->wwwroot . "pg/resumes/" . $loggedin_username);
  }
  
}


function resume_page_handler($page) {
  global $CONFIG;
  // determine wich user resume are we showing
  if (isset($page[0]) && !empty($page[0])) {
      set_input('username', $page[0]);
      if (@include_once(dirname(__FILE__) . '/index.php')) return true;
  } else if (isloggedin ()) {
    //set_input('username', get_loggedin_user()->username);
    //if (@include_once(dirname(__FILE__) . '/index.php')) return true;
    // Forward to user's resume if not user is provided
    forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
  } else {
    // Forward to main page if not logged in
    forward($_SERVER['HTTP_REFERER']);
  }

  if (isset($page[1])) {
    switch ($page[1]) {}
  }
}

/* Printed profile page */
function printed_page_handler($page) {
  echo elgg_view("page_elements/header"); ?>
  <div class="resume_body_printer">
    <?php
    global $CONFIG;
    set_context("profileprint");
    // determine wich user resume are we showing
    if (isset($page[0]) && !empty($page[0])) {
      $username = $page[0];
      // forward away if invalid user.
      if (!$user = get_user_by_username($username)) {
        register_error('blog:error:unknown_username');
        forward($_SERVER['HTTP_REFERER']);
      }
      // set the page owner to show the right content
      set_page_owner($user->getGUID());
      $page_owner = page_owner_entity();
      if ($page_owner === false || is_null($page_owner)) {
        $page_owner = get_loggedin_user();
        set_page_owner(get_loggedin_user());
      }
      echo elgg_view('resume/printed', array('owner' => $page_owner));
    }
  echo '</div><!-- /#resume_body_printer -->';
}


/* Décode les entités HTML ; nécessaire pour le flux XML qui n'apprécie pas vraiment les entités HTML, et évite de répéter les 2 fonctions à chaque fois..
Note : il faut parfois aussi également encoder en UTF-8 avec utf8_encode($txt)
*/
if (!function_exists('unhtmlentities')) {
  function unhtmlentities($chaineHtml) {
    $tmp = get_html_translation_table(HTML_ENTITIES);
    $tmp = array_flip ($tmp);
    $chaineTmp = strtr ($chaineHtml, $tmp);
    return $chaineTmp;
  }
}



// ******************** REGISTER ACTIONS ******************
register_action("resume/delete", false, $CONFIG->pluginspath . "resume/actions/delete.php");
register_action("resume/edit", false, $CONFIG->pluginspath . "resume/actions/edit.php");

if (get_plugin_setting('experience') == 'yes') { register_action("resume/experience_add", false, $CONFIG->pluginspath . "resume/actions/experience_add.php"); }
if (get_plugin_setting('language') == 'yes') { register_action("resume/language_add", false, $CONFIG->pluginspath . "resume/actions/language_add.php"); }
if (get_plugin_setting('workexperience') == 'yes') { register_action("resume/workexperience_add", false, $CONFIG->pluginspath . "resume/actions/workexperience_add.php"); }
if (get_plugin_setting('education') == 'yes') { register_action("resume/education_add", false, $CONFIG->pluginspath . "resume/actions/education_add.php"); }
if (get_plugin_setting('skill') == 'yes') { register_action("resume/skill_add", false, $CONFIG->pluginspath . "resume/actions/skill_add.php"); }
if (get_plugin_setting('skill_ciiee') == 'yes') { register_action("resume/skill_ciiee_add", false, $CONFIG->pluginspath . "resume/actions/skill_ciiee_add.php"); }


// ******************** REGISTER PAGE HANDLER ******************
register_page_handler('resumes', 'resume_page_handler');
register_page_handler('resumesprintversion', 'printed_page_handler');


// ******************** REGISTER EVENT HANDLERS ******************
register_elgg_event_handler('pagesetup', 'system', 'resume_pagesetup');
register_elgg_event_handler('init', 'system', 'resume_init');
