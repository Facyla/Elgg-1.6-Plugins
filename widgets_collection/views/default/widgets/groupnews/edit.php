<?php
/*
<p>
	<?php echo elgg_echo("widgets_collection:mynews"); ?><br />
	<?php //	echo '<input type="text" name="params[title]" value="' . htmlentities($vars['entity']->title) . '" />'; ?>
	<textarea name="params[description]" style="width:100%; height:12ex !important;"><?php echo $vars['entity']->description; ?></textarea>
	<?php //echo elgg_view('input/longtext', array('internalname'=>'params[description]', 'value'=>$vars['entity']->description)); ?>
</p>
*/

$userguid = page_owner();

$select = '';
// Restrict to a specific site or group (select)

$sites = get_entities("site","",0,"time_created asc",$count,0,false,-1,null);
if ($sites)
  $select .= '<option value="" disabled="disabled" > --  SITES  -- </option>';
  foreach ($sites as $site) {
    // On ne liste que les sites dans lesquels le membre est inscrit
    if (check_entity_relationship($userguid,'member_of_site', $site->guid)) {
      if ($site->guid == $vars['entity']->newsentity) $select .= '<option value="'.$site->guid.'" selected="selected" class="tooltips-e" title="'. $site->briefdescription .'">' . $site->name . '</option>';
      else $select .= '<option value="'.$site->guid.'"class="tooltips-e" title="'. $site->briefdescription .'">' . $site->name . '</option>';
    }
  }


// Génère la liste des groupes de l'utilisateur pour menu déroulant
// @todo : voir si besoin de différencier quand on n'est pas membre de ce groupe ?  (pas sûr - trop de groupes)
$groups = get_entities_from_relationship('member', $userguid, false, "group", "", 0, "time_created asc", 999, 0, false, -1);
if($groups) 
  $select .= '<option value="" disabled="disabled" > -- GROUPES -- </option>';
  foreach($groups as $group){
    if ($group->guid == $vars['entity']->newsentity) $select .= '<option value="'.$group->guid.'" selected="selected" class="tooltips-e" title="'. $group->briefdescription .'">' . $group->name . ' ('.get_entity($group->site_guid)->name.')</option>';
    else $select .= '<option value="'.$group->guid.'" class="tooltips-e" title="'. $group->briefdescription .'">' . $group->name . ' ('.get_entity($group->site_guid)->name.')</option>';
  }

?>
=> Choisir le groupe ou site : sélecteur

<select name="params[newsentity]" style="max-width:160px;">
  <option value="" <?php if (empty($vars['entity']->newsentity)) echo 'selected="selected"'; ?>>Tous (tous vos groupes dans tous les sites)</option>
  <?php echo $select; ?>
</select>
