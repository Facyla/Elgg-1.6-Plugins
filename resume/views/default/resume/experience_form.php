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
if (isset($vars['entity'])) {
  $action = "resume/edit";
} else {
  $action = "resume/experience_add";
}

/*
@todo : nouvelle vue pour définir l'importance (barre slider - cf. JS)
@todo : affiner le form et les champs (select pour typology)
*/

$typology_options = array( 
    'work' => elgg_echo('resume:experience:work'), 
    'academic' => elgg_echo('resume:experience:academic'),
    'other' => elgg_echo('resume:experience:other'),
  );

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
      <?php echo elgg_echo('resume:experience:heading'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'heading', 'value' => $vars['entity']->heading)); ?>
    </p>
    
    <div style="float:left; width:45%;">
      <?php echo elgg_echo('resume:experience:structure'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'structure', 'value' => $vars['entity']->structure)); ?>
    </div>
    
    <div style="float:left; width:50%; margin-left:2%;">
      <?php echo elgg_echo('resume:experience:typology'); ?><br />
      <?php
      //echo elgg_view('input/pulldown', array('internalname' => 'typology', 'options_values' => $typology_options, 'value' => $vars['entity']->typology));
      echo elgg_view('input/text', array('internalname' => 'typology', 'value' => $vars['entity']->typology));
      ?>
    </div>
    
    <div class="clearfloat"></div><br />

    <p>
      <?php echo elgg_echo('resume:experience:contact'); ?><br />
      <?php echo elgg_view('input/text', array('internalname' => 'contact', 'value' => $vars['entity']->contact)); ?>
    </p>
    
    <p>
      <?php echo elgg_echo('resume:experience:description'); ?><br />
      <?php echo elgg_view('input/longtext', array('internalname' => 'description', 'value' => $vars['entity']->description)); ?>
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
