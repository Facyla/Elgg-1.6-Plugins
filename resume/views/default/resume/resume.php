<?php
$page_owner = $vars['owner'];
$pageowner_guid = $page_owner->guid;

$body = '<style>
.resume_body_printer { padding:3ex; }
.tabla_idiomas th, .tabla_idiomas td { border:1px solid darkgrey !important; }
</style>';

$context = get_context();
// We use this to use smaller titles when using the most compact view (index)
if ($context != "index") $t_level = 'h3'; else $t_level = 'h4';
$crosstoggle = "if(this.innerHTML=='-'){this.innerHTML='+'}else{this.innerHTML='-'};";

// -------- BEGIN MAIN PAGE CONTENT ---------
// Use smaller view in certain contexts
if (($context != 'profile') && ($context != "index")) {
  $body .= '<div class="resume">';
  $body .=  "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/profile/" . $page_owner->username . "\")>" . elgg_echo("resume:profile:goto") . "</a></p>";
  $body .=  "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/resumesprintversion/" . $page_owner->username . "\" target=\"_blank\" \">" . elgg_echo("resume:profile:gotoprint") . "</a></p>";
  $body .=  "<p class=\"profile_info_edit_buttons\"><a href=\"" . $CONFIG->wwwroot . "pg/profile/" . $page_owner->username . "?view=xml-europass\" target=\"_blank\" \">" . elgg_echo("resume:profile:xml-europass") . "</a></p>";
  $body .= "<div class=\"clearfloat\"></div>";
  $body .= "<br />";
}

if ((get_plugin_setting('education', 'resume') == 'yes') && ($education = list_user_objects($pageowner_guid, 'education', 0, false, false, true))) {
  $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <'.$t_level.'>' . elgg_echo('resume:educations') . ' (' . $page_owner->countObjects("education") . ')<span style="font-size:15px;">&nbsp;<a onclick="$(\'#education_resume_collapsible_box\').toggle();'.$crosstoggle.'">+</a></span></'.$t_level.'>
      <div style="display:none;" id="education_resume_collapsible_box">' . $education . '</div>
    </div>';
}

if ((get_plugin_setting('workexperience', 'resume') == 'yes') && ($workexperience = list_user_objects($pageowner_guid, 'workexperience', 0, false, false, true))) {
  $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <'.$t_level.'>' . elgg_echo('resume:workexperiences') . ' (' . $page_owner->countObjects("workexperience") . ')<span style="font-size:15px;">&nbsp;<a onclick="$(\'#workexperience_resume_collapsible_box\').toggle();'.$crosstoggle.'">+</a></span></'.$t_level.'>
      <div style="display:none;" id="workexperience_resume_collapsible_box">' . $workexperience . '</div>
    </div>';
}

if ((get_plugin_setting('experience', 'resume') == 'yes') && ($experience = list_user_objects($pageowner_guid, 'experience', 0, false, false, true))) {
  $body .= '<div class="contentWrapper resume_contentWrapper" width="716">
      <'.$t_level.'>' . elgg_echo('resume:experiences') . ' (' . $page_owner->countObjects("experience") . ')<span style="font-size:15px;">&nbsp;<a onclick="$(\'#experience_resume_collapsible_box\').toggle();'.$crosstoggle.'">+</a></span></'.$t_level.'>
      <div style="display:none;" id="experience_resume_collapsible_box">' . $experience . '</div>
    </div>';
}

if ((get_plugin_setting('skill', 'resume') == 'yes') && ($skill = list_user_objects($pageowner_guid, 'skill', 0, false, false, true))) {
  $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <'.$t_level.'>' . elgg_echo('resume:skills') . ' (' . $page_owner->countObjects("skill") . ')<span style="font-size:15px;">&nbsp;<a onclick="$(\'#skill_resume_collapsible_box\').toggle();">+</a></span></'.$t_level.'>
      <div style="display:none;" id="skill_resume_collapsible_box">' . $skill . '</div>
    </div>';
}

if ((get_plugin_setting('skill_ciiee', 'resume') == 'yes') && ($skill_ciiee = list_user_objects($pageowner_guid, 'skill_ciiee', 0, false, false, true))) {
  $body .= '<div class="contentWrapper resume_contentWrapper" width=716>
      <'.$t_level.'>' . elgg_echo('resume:skill_ciiees') . ' (' . $page_owner->countObjects("skill_ciiee") . ')<span style="font-size:15px;">&nbsp;<a onclick="$(\'#skill_ciiee_resume_collapsible_box\').toggle();'.$crosstoggle.'">+</a></span></'.$t_level.'>
      <div style="display:none;" id="skill_ciiee_resume_collapsible_box">' . $skill_ciiee . '</div>
    </div>';
}

if ((get_plugin_setting('language', 'resume') == 'yes') && ($language = list_user_objects($page_owner->getGUID(), 'language', 0, false, false, true))) {
  $body .= '<div class="contentWrapper resume_contentWrapper">
      <'.$t_level.'>' . elgg_echo('resume:languages') . ' (' . $page_owner->countObjects("language") . ')<span style="font-size:15px;">&nbsp;<a onclick="$(\'#language_resume_collapsible_box\').toggle();'.$crosstoggle.'">+</a></span></'.$t_level.'>
      <div style="display:none;" id="language_resume_collapsible_box">';
  // Ultra compact view
  if ($context != "index") {
    $body .= '<table class="tabla_idiomas">
      <tr class="t_h">
        <td rowspan="2">' . elgg_echo('resume:languages:language') . '</td>
        <td colspan="2">' . elgg_echo('resume:languages:understanding') . '</td>
        <td colspan="2">' . elgg_echo('resume:languages:speaking') . '</td>
        <td rowspan="2">' . elgg_echo('resume:languages:writing') . '</td>
      </tr>
      <tr class="t_h">
        <td>' . elgg_echo('resume:languages:listening') . '</td>
        <td>' . elgg_echo('resume:languages:reading') . '</td>
        <td>' . elgg_echo('resume:languages:spokeninteraction') . '</td>
        <td>' . elgg_echo('resume:languages:spokenproduction') . '</td>
      </tr>';
  }
  $body .= $language;
  // Ultra compact view
  if ($context != "index") { $body .= '</table>'; }
  $body .= '</div></div>';
}

// Show a message if there aren't any user objects.
if (!$experience && !$language && !$workexperience && !$education && !$skill && !$skill_ciiee ) {
  ?><h3><?php
  if ($pageowner_guid == get_loggedin_user()->guid) {
    echo '<a href="' . $CONFIG->wwwroot . "pg/resumes/" . $page_owner->username . '">' . elgg_echo('resume:noentries:create') . '</a>';
  } else {
    echo elgg_echo('resume:noentries');
  }
  ?></h3><?php
}

if (($context != 'profile') && ($context != "index")) {
  $body .= '</div>';
}

echo $body;
