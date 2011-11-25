<?php

  // Load Elgg engine
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

  ob_start();
  
?>

<style type="text/css">
#permissions {
  margin:20px 0 0 0;
  font:14px/1.4em "Lucida Grande", Verdana, Arial, Helvetica, Clean, Sans, sans-serif;
  letter-spacing:0px;
  color:#333;
}
</style>

<div class="contentWrapper" style="margin:0; min-height:340px;">

<div id="elggreturn">
  <a href="javascript:history.go(-1)"><?php echo elgg_echo('simplepie:backtoadmin'); ?></a>
</div>
<div id="permissions">

<?php
  
  if (is_writable('cache'))
    echo '<p>' . elgg_echo('simplepie:cachewritable') . '</p>';
  else
    echo '<p>' . elgg_echo('simplepie:cachenotwritable') . '</p>';
    
  echo '<p>' . elgg_echo('simplepie:dirpermissions') . ' ' . substr(decoct(fileperms('cache')),2) . '.</p>';
  
?>
</div>
</div>

<?php  
  $content = ob_get_clean();
  $body = elgg_view_layout('one_column', $content);
  echo page_draw(null, $body);
?>
