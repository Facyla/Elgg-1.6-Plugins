<?php
/**
 * CSS spécifique pour le fil d'Ariane (breadcrumb trail)
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @link http://id.facyla.net/
 * 
 */
global $CONFIG;

/* @Settings : Breadcrumb Colors and styles */
// main style (for text)
$mainstyle = get_plugin_setting('background', 'breadcrumbtrail');
if (empty($mainstyle)) $mainstyle = '';
// background : transparent, or set to main background color
$background = get_plugin_setting('background', 'breadcrumbtrail');
if (empty($background)) $background = 'white';
// arrow background color
$arrow = get_plugin_setting('arrow', 'breadcrumbtrail');
if (empty($arrow)) $arrow = '#F5F5F5';
// arrowhover background color
$arrowhover = get_plugin_setting('arrowhover', 'breadcrumbtrail');
if (empty($arrowhover)) $arrowhover = '#BBDAF7';
// separator background color
$separator = get_plugin_setting('separator', 'breadcrumbtrail');
if (empty($separator)) $separator = '#FFF';

?>

#breadcrumbtrail { clear:both; font: normal 11px Georgia,'DejaVu Serif',Norasi,serif; color:#666; width:auto; <?php echo $mainstyle; ?> }


/* Pure CSS arrows */
span.breadcrumbtrail:before { content:""; display:block; float:left; border:10px solid <?php echo $arrow; ?>; border-left: 6px solid <?php echo $separator; ?>; }
span.breadcrumbtrail { display:block; float:left; margin:1px 0; background:<?php echo $arrow; ?>; height:20px; line-height:20px; vertical-align:bottom; }
span.breadcrumbtrail:after { display:block; float:right; content:""; margin-left:6px; border: 10px solid <?php echo $separator; ?>; border-right:0; border-left: 6px solid <?php echo $arrow; ?>; }
span.breadcrumbtrail:first-child:before { border-left: 10px solid <?php echo $background; ?>; }
span.breadcrumbtrail:last-child:after { content:""; border-left: 10px solid <?php echo $arrow; ?>; border-right:0; border-top: 10px solid <?php echo $background; ?>; border-bottom: 10px solid <?php echo $background; ?>; }

/* Hover effects (color..) */
span.breadcrumbtrail:hover:before { border:10px solid <?php echo $arrowhover; ?>; border-left: 6px solid <?php echo $separator; ?>; }
span.breadcrumbtrail:hover { background:<?php echo $arrowhover; ?>; }
span.breadcrumbtrail:hover a { color:black; }
span.breadcrumbtrail:hover:after { border: 10px solid <?php echo $separator; ?>; border-right:0; border-left: 6px solid <?php echo $arrowhover; ?>; }
span.breadcrumbtrail:hover:first-child:before { border-left: 10px solid <?php echo $background; ?>; }
span.breadcrumbtrail:hover:last-child:after { border-left: 10px solid <?php echo $arrowhover; ?>; }


/* Pure CSS reverse arrows */
span.breadcrumbback:before { content:""; display:block; float:left; border:10px solid <?php echo $separator; ?>; border-left:0; border-right: 6px solid <?php echo $arrow; ?>; }
span.breadcrumbback { display:block; float:left; margin:1px 0; background:<?php echo $arrow; ?>; height:20px; line-height:20px; vertical-align:bottom; }
span.breadcrumbback:after { display:block; float:right; content:""; margin-left:6px; border: 10px solid <?php echo $arrow; ?>; border-left:0; border-right: 6px solid <?php echo $separator; ?>; }
span.breadcrumbback:first-child:before { border-right: 10px solid <?php echo $arrow; ?>; }
span.breadcrumbback:last-child:after { border: 10px solid <?php echo $arrow; ?>; border-left:0; border-right: 10px solid <?php echo $background; ?>; }

/* Hover effects (color..) */
span.breadcrumbback:hover:before { border-right: 6px solid <?php echo $arrowhover; ?>; }
span.breadcrumbback:hover { background:<?php echo $arrowhover; ?>; }
span.breadcrumbback:hover a { color:black; }
span.breadcrumbback:hover:after {border: 10px solid <?php echo $arrowhover; ?>; border-left:0; border-right: 6px solid <?php echo $separator; ?>; }
span.breadcrumbback:hover:first-child:before { border-right: 10px solid <?php echo $arrowhover; ?>; }
span.breadcrumbback:hover:last-child:after { border: 10px solid <?php echo $arrowhover; ?>; border-left:0; border-right:10px solid <?php echo $background; ?>; }

