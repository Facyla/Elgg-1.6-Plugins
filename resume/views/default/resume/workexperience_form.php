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
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/workexperience_add"; }

/*
@todo : nouvelle vue pour définir l'importance (barre slider - cf. JS)
@todo : affiner le form et les champs (select pour typology)
*/


$sectors = array(
    'A' => elgg_echo('resume:sector:A'), 
    'B' => elgg_echo('resume:sector:B'), 
    'C' => elgg_echo('resume:sector:C'), 
    'D' => elgg_echo('resume:sector:D'), 
    'E' => elgg_echo('resume:sector:E'), 
    'F' => elgg_echo('resume:sector:F'), 
    'G' => elgg_echo('resume:sector:G'), 
    'H' => elgg_echo('resume:sector:H'), 
    'I' => elgg_echo('resume:sector:I'), 
    'J' => elgg_echo('resume:sector:J'), 
    'K' => elgg_echo('resume:sector:K'), 
    'L' => elgg_echo('resume:sector:L'), 
    'M' => elgg_echo('resume:sector:M'), 
    'N' => elgg_echo('resume:sector:N'), 
    'O' => elgg_echo('resume:sector:O'), 
    'P' => elgg_echo('resume:sector:P'), 
    'Q' => elgg_echo('resume:sector:Q'), 
    'R' => elgg_echo('resume:sector:R'), 
    'S' => elgg_echo('resume:sector:S'), 
    'T' => elgg_echo('resume:sector:T'), 
    'U' => elgg_echo('resume:sector:U'), 
  );
$sector = $vars['entity']->sector;
if (empty($sector)) $sector_options = '<option disabled="disabled" selected="selected">-------</option>';
else $sector_options = '<option value="' . $sector . '" selected="selected">&raquo;&nbsp;' . elgg_echo('resume:sector:' . $sector) . '</option>';
foreach ($sectors as $s => $l) { $sector_options .= '<option value="' . $s . '">' . $l . '</option>'; }

// Heading - intitulé des postes : cf. liste dans https://europass.cedefop.europa.eu/cvonline/js/occupationalField.jsp

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
    
    <div style="float:left; width:auto;">
      <?php echo elgg_echo('resume:importance'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => $vars['entity']->importance));
      else echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => 50));
      ?>
    </div>
    <div class="clearfloat"></div><br />
    
    <p>
      <?php echo elgg_echo('resume:workexperience:heading'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <div style="float:left; width:45%;">
      <?php echo elgg_echo('resume:workexperience:structure'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'structure', 'value' => $vars['entity']->structure)); ?>
    </div>
    
    <div style="float:left; width:50%; margin-left:2%;">
      <?php echo elgg_echo('resume:workexperience:sector'); ?><br />
      <select name="sector" class="input-pulldown" style="width:100%;"><?php echo $sector_options; ?></select>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <p>
      <?php echo elgg_echo('resume:workexperience:contact'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:workexperience:description'); ?><br />
      <?php echo elgg_view('input/longtext', array('internalname' => 'description', 'value' => $vars['entity']->description)); ?>
    </p>
    
    <div class="clearfloat"></div>
    
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
