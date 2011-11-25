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
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/skill_add"; }

$skilltypes = array('social', 'organisational', 'technical', 'computer', 'artistic', 'other', 'driving');
$skilltype = $vars['entity']->skilltype;
if (empty($skilltype)) $skilltype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $skilltype_options = '<option value="' . $skilltype . '" selected="selected">' . elgg_echo('resume:skill:' . $skilltype) . '</option>';
foreach ($skilltypes as $type) { $skilltype_options .= '<option value="' .$type. '">' . elgg_echo('resume:skill:' . $type) . '</option>'; }

$importance_options = array( 0 => "0", 5 => "5", 10 => "10", 15 => "15", 20 => "20", 25 => "25", 30 => "30", 35 => "35", 40 => "40", 45 => "45", 50 => "50", 55 => "55", 60 => "60", 65 => "65", 70 => "70", 75 => "75", 80 => "80", 85 => "85", 90 => "90", 95 => "95", 100  => "100");

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;
?>

<div class="contentWrapper">
  
  <form action="<?php echo $vars['url']; ?>action/<?php echo $action ?>" method="post">

    <div style="float:left; width:40%; margin-right:10%;">
      <?php echo elgg_echo('resume:skill:typology'); ?><br />
      <select name="skilltype" class="input-pulldown"><?php echo $skilltype_options; ?></select>
    </div>
    
    <div style="float:left; width:40%; margin-right:10%;">
      <?php echo elgg_echo('resume:experience:importance'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => $vars['entity']->importance));
      else echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => 50));
      ?>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <p>
      <?php echo elgg_echo('resume:skill:content'); ?><br />
      <?php echo elgg_view('input/longtext', array('internalname' => 'skill', 'value' => $vars['entity']->skill)); ?>
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
    
    <?php if (isset($vars['entity'])) { echo elgg_view('input/hidden', array('internalname' => 'id', 'value' => $vars['entity']->getGUID())); } ?>
  </form>
  
</div>
