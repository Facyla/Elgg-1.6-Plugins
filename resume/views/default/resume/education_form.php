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
// Decide wich action to use based on if its an edit or add use case.
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/education_add"; }

/*
@todo : affiner le form et les champs (select pour typology)
*/

$levels = array(
    'ISCED0' => elgg_echo('resume:education:level:ISCED0'), 
    'ISCED1' => elgg_echo('resume:education:level:ISCED1'), 
    'ISCED2' => elgg_echo('resume:education:level:ISCED2'), 
    'ISCED3' => elgg_echo('resume:education:level:ISCED3'), 
    'ISCED4' => elgg_echo('resume:education:level:ISCED4'), 
    'ISCED5' => elgg_echo('resume:education:level:ISCED5'), 
    'ISCED6' => elgg_echo('resume:education:level:ISCED6'), 
  );
$level = $vars['entity']->level;
if (empty($level)) $level_options = '<option disabled="disabled" selected="selected">-------</option>';
else $level_options = '<option value="' . $level . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:education:level:' . $level) . '</option>';
foreach ($levels as $l => $c) { $level_options .= '<option value="' .$l. '">' . $c . '</option>'; }

$fields = array(
    '0' => elgg_echo('resume:education:field:0'), 
    '01' => elgg_echo('resume:education:field:01'), 
    '09' => elgg_echo('resume:education:field:09'), 
    '1' => elgg_echo('resume:education:field:1'), 
    '14' => elgg_echo('resume:education:field:14'), 
    '2' => elgg_echo('resume:education:field:2'), 
    '21' => elgg_echo('resume:education:field:21'), 
    '22' => elgg_echo('resume:education:field:22'), 
    '3' => elgg_echo('resume:education:field:3'), 
    '31' => elgg_echo('resume:education:field:31'), 
    '32' => elgg_echo('resume:education:field:32'), 
    '34' => elgg_echo('resume:education:field:34'), 
    '38' => elgg_echo('resume:education:field:38'), 
    '4' => elgg_echo('resume:education:field:4'), 
    '42' => elgg_echo('resume:education:field:42'), 
    '44' => elgg_echo('resume:education:field:44'), 
    '46' => elgg_echo('resume:education:field:46'), 
    '48' => elgg_echo('resume:education:field:48'), 
    '5' => elgg_echo('resume:education:field:5'), 
    '52' => elgg_echo('resume:education:field:52'), 
    '54' => elgg_echo('resume:education:field:54'), 
    '58' => elgg_echo('resume:education:field:58'), 
    '6' => elgg_echo('resume:education:field:6'), 
    '62' => elgg_echo('resume:education:field:62'), 
    '64' => elgg_echo('resume:education:field:64'), 
    '7' => elgg_echo('resume:education:field:7'), 
    '72' => elgg_echo('resume:education:field:72'), 
    '76' => elgg_echo('resume:education:field:76'), 
    '8' => elgg_echo('resume:education:field:8'), 
    '81' => elgg_echo('resume:education:field:81'), 
    '84' => elgg_echo('resume:education:field:84'), 
    '85' => elgg_echo('resume:education:field:85'), 
    '86' => elgg_echo('resume:education:field:86'), 
  );
$field = $vars['entity']->field;
if (empty($field)) $field_options = '<option disabled="disabled" selected="selected">-------</option>';
else $field_options = '<option value="' . $field . '" selected="selected">' . elgg_echo('resume:education:field:' . $field) . '</option>';
foreach ($fields as $f => $v) { $field_options .= '<option value="' .$f. '">' . $v . '</option>'; }

$importance_options = array( 0 => "0", 5 => "5", 10 => "10", 15 => "15", 20 => "20", 25 => "25", 30 => "30", 35 => "35", 40 => "40", 45 => "45", 50 => "50", 55 => "55", 60 => "60", 65 => "65", 70 => "70", 75 => "75", 80 => "80", 85 => "85", 90 => "90", 95 => "95", 100  => "100");

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;
?>

<div class="contentWrapper">
  
  <form action="<?php echo $vars['url']; ?>action/<?php echo $action ?>" method="post">
    
    <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:startdate'); ?><br />
      <?php echo elgg_view('input/calendar', array('internalname' => 'startdate', 'value' => $vars['entity']->startdate)); ?>
    </div>
    
    <div style="float:left; width:35%;">
      <?php echo elgg_echo('resume:enddate'); ?>
       &nbsp; <?php echo elgg_echo('resume:enddateorcheck'); ?>
      <input name="ongoing[]" value="ongoing" class="input-checkboxes" type="checkbox" <?php if($vars['entity']->ongoing == 'ongoing') echo 'checked="checked"'; ?>> <?php echo elgg_echo('resume:date:ongoing'); ?><br />
      <?php echo elgg_view('input/calendar', array('internalname' => 'enddate', 'value' => $vars['entity']->enddate)); ?>
    </div>
    
    <div style="float:left; width:25%;">
      <?php echo elgg_echo('resume:importance'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => $vars['entity']->importance));
      else echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => 50));
      ?>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <p>
      <?php echo elgg_echo('resume:education:heading'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:level'); ?><br />
      <select name="level" class="input-pulldown"><?php echo $level_options; ?></select>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:field'); ?><br />
      <select name="field" class="input-pulldown"><?php echo $field_options; ?></select>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:structure'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'structure', 'value' => $vars['entity']->structure)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:contact'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:education:skills'); ?><br />
      <?php echo elgg_view('input/longtext', array('internalname' => 'skills', 'value' => $vars['entity']->skills)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('access'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $vars['entity']->access_id));
      else echo elgg_view('input/access', array('internalname' => 'access_id', 'value' => $access_id));
      ?>
    </p>
    
    <?php echo elgg_view('input/securitytoken'); ?>
    
    <p><?php echo elgg_view('input/submit', array('value' => elgg_echo('resume:save'))); ?></p>
    
    <?php if (isset($vars['entity'])) {
      echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID()));
    } ?>
  </form>
  
</div>
