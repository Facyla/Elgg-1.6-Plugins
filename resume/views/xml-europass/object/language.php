
    <language xsi:type="europass:<?php echo $vars['entity']->langtype; ?>">
      <code><?php echo $vars['entity']->language; ?></code>
      <label><?php echo elgg_echo($vars['entity']->language); ?></label>
      <?php if ($vars['entity']->langtype == "mother") { ?>
      <?php } else { ?>
      <level>
        <listening><?php echo $vars['entity']->listening; ?></listening>
        <reading><?php echo $vars['entity']->reading; ?></reading>
        <spokeninteraction><?php echo $vars['entity']->spokeninteraction; ?></spokeninteraction>
        <spokenproduction><?php echo $vars['entity']->spokenproduction; ?></spokenproduction>
        <writing><?php echo $vars['entity']->writing; ?></writing>
      </level>
      <?php } ?>
    </language>
