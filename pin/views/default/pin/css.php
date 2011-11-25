<?php
$iconurl = $vars['url'] . 'mod/pin/graphics/';
?>

.pin_container { padding:3px 6px; background:transparent; font-size:11px; }
.pin_container * a:hover { text-decoration:none; }


.icon-footprint { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 0; width:22px; height:16px; margin-bottom:4px; float:left; }
.icon-footprint:hover { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -16px; }

.icon-highlight { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -32px; width:22px; height:16px; margin-bottom:4px; float:left; }
.icon-highlighted { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -48px; width:22px; height:16px; margin-bottom:4px; float:left; }
.icon-highlight:hover { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -64px; }
.icon-unhighlight:hover { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -80px; width:22px; height:16px; margin-bottom:4px; float:left; }

.icon-memorize { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -96px; width:22px; height:16px; margin-bottom:4px; float:left; }
.icon-memorized { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -112px; width:22px; height:16px; margin-bottom:4px; float:left; }
.icon-memorize:hover { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -128px; }
.icon-unmemorize:hover { background:url(<?php echo $iconurl; ?>pin_icons.png) no-repeat top left; background-position:0 -144px; width:22px; height:16px; margin-bottom:4px; float:left; }

