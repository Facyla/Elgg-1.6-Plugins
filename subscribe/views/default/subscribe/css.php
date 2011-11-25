<?php
/**
* Subscriber
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Fabrice Collette
* this plugin has been founded by Fondation Maison des Sciences de l'Homme - Paris	 
* @copyright Fabrice Collette 2010
* @link http://www.meleze-conseil.com
* Facyla : File is included rather in owner_block rather than loaded through cache - 'cause some multisite cached CSS retrieving issue
*/
global $CONFIG;
?>

.jqpopup p, .jqpopup #notificationstable { width:480px; }

#owner_block_subscribe { padding:5px 0 5px 0; }

#owner_block_subscribe a {
  font-size: 90%; padding:0 0 4px 20px; 
  background: url(<?php echo $CONFIG->url; ?>mod/subscribe/graphics/icon_notify.png) no-repeat left top; 
}

#owner_block #owner_block_subscribe a { color:#c90; }
#owner_block_subscribe a:hover { }

.jqpopup {
    border:5px solid #85208E; border:1px 2px 2px 1px; -webkit-border-radius: 8px; -moz-border-radius: 8px; 
  width:500px; position:absolute; background:#FFFFFF; z-index:9000; display:none;
}

.jqpopup_header {
  margin:0; padding:0; top:0; left:0; padding-left:10px; padding-right:5px; padding-bottom:2px; font-size:15px; font-weight:bold; 
  cursor:move; 
}

.jqpopup_footer { padding-left:10px; padding-right:10px; padding-bottom:5px; text-align:right; font-size:10px; }

.jqpopup_content { padding-left:10px; padding-right:10px; }

.jqpopup_message { padding-top:10px; padding-left:10px; padding-right:10px; padding-bottom:5px; color:red; font-size:12px; font-weight:bold; }

.jqpopup_resize {
<?php /*  // Totalement inutile pour cet usage - autant ne pas le mettre en avant
 background: url(<?php echo $CONFIG->url; ?>mod/subscribe/graphics/resize.gif) no-repeat; 
 cursor: se-resize; 
*/ ?>
 position: absolute; bottom: 0; right: 0; height:14px; width: 16px; padding-bottom:2px; padding-right:2px; 
}

.jqpopup_cross {
 background: url(<?php echo $CONFIG->url; ?>mod/subscribe/graphics/close.png) no-repeat; 
 position: absolute; top: 5px; right: 3px; height:14px; width: 16px; 
 cursor: pointer; 
}

.jqpopup_center {
 height:14px; width: 16px; position: absolute; top: 0; right: 18px; 
 cursor: pointer; 
}

.stdbtn { width:280px; }

