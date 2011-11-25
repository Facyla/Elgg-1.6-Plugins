      <?php echo 'C2i2e ' . $vars['entity']->skilltype . ' - ' 
        . elgg_echo('resume:referential:c2i2e:' . $vars['entity']->skilltype) . ' : ' 
        . $vars['entity']->skill; ?>

<?php
/**
$vars['entity']->skilltype
  elgg_echo('resume:referential:c2i2e:' . $vars['entity']->skilltype)
$vars['entity']->title
$vars['entity']->skill

// pour texte html dans code XML : <![CDATA[    ]]>
