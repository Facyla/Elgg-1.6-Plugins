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
// Decide wich action to use based on if its and edit or add use case.
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/language_add"; }


// Language ISO code as used in Europass XML CV
$langs = array('aa', 'ab', 'af', 'am', 'ar', 'as', 'ay', 'az', 'ba', 'be', 'bg', 'bh', 'bi', 'bn', 'bo', 'br', 'ca', 'co', 'cs', 'cy', 'da', 'de', 'dz', 'el', 'en', 'eo', 'es', 'et', 'eu', 'fa', 'fi', 'fj', 'fo', 'fr', 'fy', 'ga', 'gd', 'gl', 'gn', 'gu', 'he', 'ha', 'hi', 'hr', 'hu', 'hy', 'ia', 'id', 'ie', 'ik', 'is', 'it', 'iu', 'ja', 'jw', 'ka', 'kk', 'kl', 'km', 'kn', 'ko', 'ks', 'ku', 'ky', 'la', 'ln', 'lo', 'lt', 'lv', 'mg', 'mi', 'mk', 'ml', 'mn', 'mo', 'mr', 'ms', 'mt', 'my', 'na', 'ne', 'nl', 'no', 'oc', 'om', 'or', 'pa', 'pl', 'ps', 'pt', 'qu', 'rm', 'rn', 'ro', 'ru', 'rw', 'sa', 'sd', 'sg', 'sh', 'si', 'sk', 'sl', 'sm', 'sn', 'so', 'sq', 'sr', 'ss', 'st', 'su', 'sv', 'sw', 'ta', 'te', 'tg', 'th', 'ti', 'tk', 'tl', 'tn', 'to', 'tr', 'ts', 'tt', 'tw', 'ug', 'uk', 'ur', 'uz', 'vi', 'vo', 'wo', 'xh', 'yi', 'yo', 'za', 'zh', 'zu');
$language = $vars['entity']->language;
if (empty($language)) $language_options = '<option disabled="disabled" selected="selected">-------</option>';
else $language_options = '<option value="' . $language . '" selected="selected" disabled="disabled">&raquo;&nbsp;' . elgg_echo($language) . ' (' . $language . ')</option>';
foreach ($langs as $lang) { $language_options .= '<option value="' .$lang. '">' .elgg_echo($lang). ' (' .$lang. ')</option>'; }

$langtype = $vars['entity']->langtype;
if (empty($langtype)) $langtype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $langtype_options = '<option value="' . $langtype . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:languages:type:' . $langtype) . '</option>';
$langtype_options .= '<option value="mother">' . elgg_echo('resume:languages:type:mother') . '</option><option value="foreign">' . elgg_echo('resume:languages:type:foreign') . '</option>';

$level_options = array(
    // Basic User
    '' => '-------',
    'a1' => elgg_echo('resume:languages:level:a1'),
    'a2' => elgg_echo('resume:languages:level:a2'),
    // Independent user
    'b1' => elgg_echo('resume:languages:level:b1'),
    'b2' => elgg_echo('resume:languages:level:b2'),
    // Proficient user
    'c1' => elgg_echo('resume:languages:level:c1'),
    'c2' => elgg_echo('resume:languages:level:c2'),
  );

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;
?>

<div class="contentWrapper">
  <form action="<?php echo $vars['url']; ?>action/<?php echo $action ?>" method="post">
    
    <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:languages:language'); ?> : <select name="langcode" class="input-pulldown"><?php echo $language_options; ?></select>
    </div>
    
    <div style="float:left; width:auto;">
      <p><?php echo elgg_echo('resume:languages:langtype'); ?> : <select name="langtype" class="input-pulldown"><?php echo $langtype_options; ?></select>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:understanding'); ?></h4>
      <?php echo elgg_echo('resume:languages:listening'); ?> 
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_listening').toggle();">(afficher l'aide)</a>
      <div id="resume_lang_listening" style="display:none;"><?php echo elgg_echo('resume:languages:listening:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'listening', 'options_values' => $level_options, 'value' => $vars['entity']->listening)); ?>
      <br />
      <br />
      <?php echo elgg_echo('resume:languages:reading'); ?> 
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_reading').toggle();">(afficher l'aide)</a>
      <div id="resume_lang_reading" style="display:none;"><?php echo elgg_echo('resume:languages:reading:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'reading', 'options_values' => $level_options, 'value' => $vars['entity']->reading)); ?>
    </div>
    
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:speaking'); ?></h4>
      <?php echo elgg_echo('resume:languages:spokeninteraction'); ?> 
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_spokeninteraction').toggle();">(afficher l'aide)</a>
      <div id="resume_lang_spokeninteraction" style="display:none;"><?php echo elgg_echo('resume:languages:spokeninteraction:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'spokeninteraction', 'options_values' => $level_options, 'value' => $vars['entity']->spokeninteraction)); ?>
      <br />
      <br />
      <?php echo elgg_echo('resume:languages:spokenproduction'); ?> 
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_spokenproduction').toggle();">(afficher l'aide)</a>
      <div id="resume_lang_spokenproduction" style="display:none;"><?php echo elgg_echo('resume:languages:spokenproduction:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'spokenproduction', 'options_values' => $level_options, 'value' => $vars['entity']->spokenproduction)); ?>
    </div>
    
    <div style="float:left; width:33%;">
      <h4><?php echo elgg_echo('resume:languages:writing'); ?></h4>
      <a href="javascript:void(0);" class="inline_toggler" onclick="$('#resume_lang_writing').toggle();">(afficher l'aide)</a>
      <div id="resume_lang_writing" style="display:none;"><?php echo elgg_echo('resume:languages:writing:help'); ?></div>
      <?php echo elgg_view('input/pulldown', array('internalname' => 'writing', 'options_values' => $level_options, 'value' => $vars['entity']->writing)); ?>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <p><?php echo elgg_echo('access'); ?><br />
    <?php
    if (isset($vars['entity'])) echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $vars['entity']->access_id));
    else echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
    ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:languages:save'))); ?></p>
    
    <?php // Pass the GUID if existing entity
    if (isset($vars['entity'])) { echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID())); }
    ?>
    
  </form>
</div>
