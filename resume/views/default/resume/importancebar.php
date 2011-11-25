<?php
// Only required parameter
$imp = (int) $vars['importance'];
$cr = (int) ($imp); $cg = 0; $cb = 100-$cr;

// These are for customization
$position = (isset($vars['position'])) ? $vars['position'] : "float:right;";
$width = (isset($vars['width'])) ? $vars['width'] : "23ex";
$wrapperstyle = (isset($vars['wrapperstyle'])) ? $vars['wrapperstyle'] : "height:16px; border:1px solid black; background:darkgrey;";
$barstyle = (isset($vars['barstyle'])) ? $vars['barstyle'] : "width:$imp%; background-color:rgb($cr%, $cg%, $cb%);";; // bar style
$contentstyle = (isset($vars['contentstyle'])) ? $vars['contentstyle'] : "width:$width; font-size:11px; font-weight:bold; color:white;"; // bar content style
$text = (isset($vars['text'])) ? $vars['text'] : "Importance : $imp/100";
?>
<div style="<?php echo $position; ?>">
  <div style="<?php echo $wrapperstyle; ?> width:<?php echo $width; ?>;">
    <div style="position:relative; left: 0; top:0; height:100%; <?php echo $barstyle; ?>">
      <div style="position:relative; left:0.5ex; top:0; <?php echo $contentstyle; ?>"><?php echo $text; ?></div>
    </div>
  </div>
</div>
