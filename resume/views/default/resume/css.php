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

global $CONFIG;
$urlicon = $CONFIG->url . 'mod/resume/graphics/';
?>

.tabla_idiomas td { padding:5px; }

.t_h td { font-weight:bold; }

.strong { font-weight:bold; }

.formatted_text { text-align:justify; }

.organisation_title { font-weight:bold; font-style: italic; }

.resume h3 { margin:0; }

.resume_collapsible_box { background:none; -webkit-border-radius: 0px; -moz-border-radius: 0px; padding:2px; margin:0px; display:block; }

.resume_collapsibleboxlink { float:right; position:relative; bottom:8px; font-size:18px; }

.resume_collapsible_box_hidden { background:none; -webkit-border-radius: 0px; -moz-border-radius: 0px; padding:2px; margin:0px; display:hidden; }

.resume_contentWrapper { margin:0 10px 4px; padding:0px 10px; }


.resume_icon_wrapper_print { float:right; }

.print-block { border-bottom:2px solid; border-color:#cccccc; padding-top:10px; padding-bottom:40px; }


.resume_body_printer { padding:0; background-color:#ffffff; text-align:left; font: 15px  "Lucida Grande", Verdana, sans-serif; color: #000000; }
.resume_body_printer a { color: #4690d6; text-decoration: none; -moz-outline-style: none; outline: none; }
.resume_body_printer a:visited { }
.resume_body_printer a:hover { color: #0054a7; text-decoration: underline; }
.resume_body_printer p { }

.resume .profile_info_edit_buttons a:link, .resume .profile_info_edit_buttons a:visited { color: white !important; margin-left: 8px; margin-left: 2px; height:auto; }

.resume h2 { margin-top:15px; }


/* River icons */
<?php
/* Use this instead if differenciated icons for each type of resume element */
/*
.river_object_resume_create, .river_object_resume_update, .river_object_resume_comment { background: url(<?php echo $urlicon; ?>river_icon_feedback.gif) no-repeat left -1px; }
.river_object_education_create, .river_object_education_update, .river_object_education_comment { background: url(<?php echo $urlicon; ?>river_icon_education.gif) no-repeat left -1px; }
.river_object_workexperience_create, .river_object_workexperience_update, .river_object_workexperience_comment { background: url(<?php echo $urlicon; ?>river_icon_workexperience.gif) no-repeat left -1px; }
.river_object_experience_create, .river_object_experience_update, .river_object_experience_comment { background: url(<?php echo $urlicon; ?>river_icon_experience.gif) no-repeat left -1px; }
.river_object_language_create, .river_object_language_update, .river_object_language_comment { background: url(<?php echo $urlicon; ?>river_icon_language.gif) no-repeat left -1px; }
.river_object_skill_create, .river_object_skill_update, .river_object_skill_comment { background: url(<?php echo $urlicon; ?>river_icon_skill.gif) no-repeat left -1px; }
*/
?>

.river_object_resume_create, .river_object_resume_update, .river_object_resume_comment, 
.river_object_education_create, .river_object_education_update, .river_object_education_comment, 
.river_object_workexperience_create, .river_object_workexperience_update, .river_object_workexperience_comment, 
.river_object_experience_create, .river_object_experience_update, .river_object_experience_comment, 
.river_object_language_create, .river_object_language_update, .river_object_language_comment, 
.river_object_skill_create, .river_object_skill_update, .river_object_skill_comment {
  background: url(<?php echo $urlicon; ?>resume_tiny.png) no-repeat left -1px;
}


