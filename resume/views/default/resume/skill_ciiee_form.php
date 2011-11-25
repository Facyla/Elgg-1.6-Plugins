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
if (isset($vars['entity'])) { $action = "resume/edit"; } else { $action = "resume/skill_ciiee_add"; }

$skilltypes = array(
    'A1' => elgg_echo('resume:referential:c2i2e:A1'), 
    'A1.1' => elgg_echo('resume:referential:c2i2e:A1.1'), 
    'A1.2' => elgg_echo('resume:referential:c2i2e:A1.2'), 
    'A1.3' => elgg_echo('resume:referential:c2i2e:A1.3'), 
    'A1.4' => elgg_echo('resume:referential:c2i2e:A1.4'), 
    'A1.5' => elgg_echo('resume:referential:c2i2e:A1.5'), 
    'A2' => elgg_echo('resume:referential:c2i2e:A2'), 
    'A2.1' => elgg_echo('resume:referential:c2i2e:A2.1'), 
    'A2.2' => elgg_echo('resume:referential:c2i2e:A2.2'), 
    'A2.3' => elgg_echo('resume:referential:c2i2e:A2.3'), 
    'A3' => elgg_echo('resume:referential:c2i2e:A3'), 
    'A3.1' => elgg_echo('resume:referential:c2i2e:A3.1'), 
    'A3.2' => elgg_echo('resume:referential:c2i2e:A3.2'), 
    'A3.3' => elgg_echo('resume:referential:c2i2e:A3.3'), 
    'A3.4' => elgg_echo('resume:referential:c2i2e:A3.4'), 
    'B1' => elgg_echo('resume:referential:c2i2e:B1'), 
    'B1.1' => elgg_echo('resume:referential:c2i2e:B1.1'), 
    'B1.2' => elgg_echo('resume:referential:c2i2e:B1.2'), 
    'B1.3' => elgg_echo('resume:referential:c2i2e:B1.3'), 
    'B2' => elgg_echo('resume:referential:c2i2e:B2'), 
    'B2.1' => elgg_echo('resume:referential:c2i2e:B2.1'), 
    'B2.2' => elgg_echo('resume:referential:c2i2e:B2.2'), 
    'B2.3' => elgg_echo('resume:referential:c2i2e:B2.3'), 
    'B2.4' => elgg_echo('resume:referential:c2i2e:B2.4'), 
    'B2.5' => elgg_echo('resume:referential:c2i2e:B2.5'), 
    'B3' => elgg_echo('resume:referential:c2i2e:B3'), 
    'B3.1' => elgg_echo('resume:referential:c2i2e:B3.1'), 
    'B3.2' => elgg_echo('resume:referential:c2i2e:B3.2'), 
    'B3.3' => elgg_echo('resume:referential:c2i2e:B3.3'), 
    'B3.4' => elgg_echo('resume:referential:c2i2e:B3.4'), 
    'B3.5' => elgg_echo('resume:referential:c2i2e:B3.5'), 
    'B4' => elgg_echo('resume:referential:c2i2e:B4'), 
    'B4.1' => elgg_echo('resume:referential:c2i2e:B4.1'), 
    'B4.2' => elgg_echo('resume:referential:c2i2e:B4.2'), 
    'B4.3' => elgg_echo('resume:referential:c2i2e:B4.3'), 
  );
$skilltype = $vars['entity']->skilltype;
if (empty($skilltype)) $skilltype_options = '<option disabled="disabled" selected="selected">-------</option>';
else $skilltype_options = '<option value="' . $skilltype . '" selected="selected">' . elgg_echo('resume:skill_ciiee:' . $skilltype) . '</option>';
foreach ($skilltypes as $item => $skill) {
  // Si plus de 2 caractères pour le code, c'est une compétence, sinon un titre
  if (strlen($item) > 2) $skilltype_options .= '<option value="' .$item. '">' . $skill . '</option>';
  else $skilltype_options .= '<option value="' .$item. '" disabled="disabled">' . $skill . '</option>';
}

$importance_options = array( 0 => "0", 5 => "5", 10 => "10", 15 => "15", 20 => "20", 25 => "25", 30 => "30", 35 => "35", 40 => "40", 45 => "45", 50 => "50", 55 => "55", 60 => "60", 65 => "65", 70 => "70", 75 => "75", 80 => "80", 85 => "85", 90 => "90", 95 => "95", 100  => "100");

if (defined('ACCESS_DEFAULT')) $access_id = ACCESS_DEFAULT; else $access_id = 0;
?>

<div class="contentWrapper">
  
  <form action="<?php echo $vars['url']; ?>action/<?php echo $action ?>" method="post">

    <div style="float:left; width:40%; margin-right:10%;">
      <?php echo elgg_echo('resume:skill_ciiee:typology'); ?><br />
      <select name="skilltype" class="input-pulldown" style="width:40ex;"><?php echo $skilltype_options; ?></select>
    </div>
    
    <div style="float:left; width:40%; margin-right:10%;">
      <?php echo elgg_echo('resume:skill_ciiee:importance'); ?><br />
      <?php
      if (isset($vars['entity'])) echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => $vars['entity']->importance));
      else echo elgg_view('input/pulldown', array('internalname' => 'importance', 'options_values' => $importance_options, 'value' => 50));
      ?>
    </div>
    
    <div class="clearfloat"></div><br />
    
    <p>
      <?php echo elgg_echo('resume:skill_ciiee:content'); ?><br />
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
