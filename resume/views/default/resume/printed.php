<?php
$page_owner = $vars['owner'];
$iconsize = "medium";

// wrap all profile info - name, picture and links ?>
<style>
.resume_body_printer { padding:3ex; }
.tabla_idiomas th, .tabla_idiomas td { border:1px solid darkgrey; }
</style>

<div id="profile_info_printed">
  <?php
  echo "<h1>" . $page_owner->name . "</h1><br/>";
  echo "<strong>" . elgg_echo("resume:profileurl") . "&nbsp;: </strong><a href=\"" . $page_owner->getUrl() . "\">" . $page_owner->getUrl() . "</a>";
  echo '<div style="float:right;">' . elgg_view( "profile/icon", array('entity' => $page_owner, 'size' => $iconsize, 'override' => true) ) . '</div>';
  //'align' => "left",
  ?>
  <br/>
  
  <div class="print-block">
    <?php
    // Simple XFN
    $rel_type = "";
    if (get_loggedin_userid() == $page_owner->guid) { $rel_type = 'me'; } 
    elseif (check_entity_relationship(get_loggedin_userid(), 'friend', $page_owner->guid)) { $rel_type = 'friend'; }
    if ($rel_type) { $rel = "rel=\"$rel_type\""; }

    //insert a view that can be extended
    echo elgg_view("profile/status", array("entity" => $vars['owner']));
    
    $even_odd = null;
    if (is_array($CONFIG->profile) && sizeof($CONFIG->profile) > 0) {
      foreach ($CONFIG->profile as $shortname => $valtype) {
        if ($shortname != "description") {
          $value = $page_owner->$shortname;
          if (!empty($value)) {
            //This function controls the alternating class
            $even_odd = ( 'odd' != $even_odd ) ? 'odd' : 'even'; ?>
            <p class="<?php echo $even_odd; ?>">
              <b><?php echo elgg_echo("profile:{$shortname}"); ?>&nbsp;: </b>
              <?php $options = array( 'value' => $page_owner->$shortname );
              if ($valtype == 'tags') { $options['tag_names'] = $shortname; }
              echo elgg_view("output/{$valtype}", $options); ?>
            </p>
            <?php
          }
        }
      }
    }
    ?>
  </div><!-- /#print-block -->
  
  <?php if (!get_plugin_setting('user_defined_fields', 'profile')) { ?>
    <div class="print-block">
      <p class="profile_aboutme_title"><b><?php echo elgg_echo("profile:aboutme"); ?></b></p>
      <?php if ($page_owner->isBanned()) {
        echo '<div>' . elgg_echo('profile:banned') . '</div><!-- /#profile_info_column_right -->';
      } else {
        echo elgg_view('output/longtext', array('value' => $page_owner->description));
        //echo autop(filter_tags($vars['entity']->description));
      } ?>
    </div><!-- /#print-block -->
  <?php } ?>
  
</div><!-- /#profile_info_printed -->


<div>
  <?php echo $title;
  if ((get_plugin_setting('experience') == 'yes') && (list_user_objects($page_owner->getGUID(), 'experience', 0, false, false, false))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:experiences'); ?></h3>
      <?php echo list_user_objects($page_owner->getGUID(), 'experience', 0, false, false, false); ?>
    </div> <?php
  }
  
  if ((get_plugin_setting('education') == 'yes') && (list_user_objects($page_owner->getGUID(), 'education', 0, false, false, false))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:educations'); ?></h3>
      <?php echo list_user_objects($page_owner->getGUID(), 'education', 0, false, false, false); ?>
    </div> <?php
  }
  
  if ((get_plugin_setting('workexperience') == 'yes') && (list_user_objects($page_owner->getGUID(), 'workexperience', 0, false, false, false))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:workexperiences'); ?></h3>
      <?php echo list_user_objects($page_owner->getGUID(), 'workexperience', 0, false, false, false); ?>
    </div> <?php
  }
  
  if ((get_plugin_setting('skill') == 'yes') && (list_user_objects($page_owner->getGUID(), 'skill', 0, false, false, false))) { ?>
    <div class="print-block"><h3><?php echo elgg_echo('resume:skills'); ?></h3>
      <?php echo list_user_objects($page_owner->getGUID(), 'skill', 0, false, false, false); ?>
    </div> <?php
  }
  
  if ((get_plugin_setting('skill_ciiee') == 'yes') && (list_user_objects($page_owner->getGUID(), 'skill_ciiee', 0, false, false, false))) { ?>
    <div class="print-block"><h3> <?php echo elgg_echo('resume:skill_ciiees'); ?> </h3>
      <?php echo list_user_objects($page_owner->getGUID(), 'skill_ciiee', 0, false, false, false); ?>
    </div> <?php
  }
  
  if ((get_plugin_setting('language') == 'yes') && (list_user_objects($page_owner->getGUID(), 'language', 0, true, true, true))) { ?>
      <div class="print-block"><h3><?php echo elgg_echo('resume:languages'); ?></h3>
        <table class="tabla_idiomas">
          <tr class="t_h">
            <td rowspan="2"><?php echo elgg_echo('resume:languages:language'); ?></td>
            <td colspan="2"><?php echo elgg_echo('resume:languages:understanding'); ?></td>
            <td colspan="2"><?php echo elgg_echo('resume:languages:speaking'); ?></td>
            <td rowspan="2"><?php echo elgg_echo('resume:languages:writing'); ?></td>
          </tr>
          <tr class="t_h">
            <td><?php echo elgg_echo('resume:languages:listening'); ?></td>
            <td><?php echo elgg_echo('resume:languages:reading'); ?></td>
            <td><?php echo elgg_echo('resume:languages:spokeninteraction'); ?></td>
            <td><?php echo elgg_echo('resume:languages:spokenproduction'); ?></td>
          </tr>
          <?php echo list_user_objects($page_owner->getGUID(), 'language', 0, true, true, true); ?>
        </table>
      </div> <?php
  }
  

  // Show a message if there aren't any user objects.
  if (!list_user_objects($page_owner->getGUID(), 'experience', 0, true, true, true)
      && !list_user_objects($page_owner->getGUID(), 'language', 0, true, true, true)
      && !list_user_objects($page_owner->getGUID(), 'workexperience', 0, true, true, true)
      && !list_user_objects($page_owner->getGUID(), 'education', 0, true, true, true)
      && !list_user_objects($page_owner->getGUID(), 'skill', 0, true, true, true)
      && !list_user_objects($page_owner->getGUID(), 'skill_ciiee', 0, true, true, true)
  ) { echo '<div class="print-block"><h3>' . elgg_echo('resume:noentries') . '</h3></div>'; }
  ?>
</div>

