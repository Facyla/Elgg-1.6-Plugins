<?php
global $CONFIG;
$acturl = $CONFIG->url . 'mod/pin/actions/';
$ts = time();
$token = generate_action_token(time());
$tokens = '&__elgg_ts='.$ts.'&__elgg_token='.$token;
?>

<script type="text/javascript">
function pin_entity(tool, guid){
  if ($("#" + tool + "_" + guid).hasClass('icon-un' + tool)) { action = "un" + tool; } else { action = tool; }
  
  jQuery.ajax({
    url: "<?php echo $acturl; ?>" + tool + ".php",
    data: "action=" + action + "&guid=" + guid + "<?php echo $tokens; ?>&userguid=<?php echo $_SESSION['user']->guid; ?>&callback=true",
    error: function() {
      alert("Une erreur s'est produite lors du changement de l'option");
    },
    success: function(data, action){
      $("#" + tool + "_" + guid).toggleClass("icon-" + tool);
      $("#" + tool + "_" + guid).toggleClass("icon-un" + tool);
      if (tool == "memorize") {
        $("#" + "memorize_" + guid).toggleClass("icon-memorized");
      }
      if (tool == "highlight") {
        $("#" + "highlight_" + guid).toggleClass("icon-highlighted");
      }
      //alert(data);
    }
  });
  
  // Change appropriate attribute (for tooltip)
  if (tool == "memorize") {
    if (action == 'unmemorize') {
      $("#memorize_" + guid).attr('title', "<?php echo elgg_echo('pin:memorize:true'); ?>" );
    } else {
      $("#memorize_" + guid).attr('title', "<?php echo elgg_echo('pin:memorize:false'); ?>" );
    }
  }
  if (tool == "highlight") {
    if (action == 'unhighlight') {
      $("#highlight_" + guid).attr('title', "<?php echo elgg_echo('pin:highlight:true'); ?>" );
    } else {
      $("#highlight_" + guid).attr('title', "<?php echo elgg_echo('pin:highlight:false'); ?>" );
    }
  }
}
</script>
