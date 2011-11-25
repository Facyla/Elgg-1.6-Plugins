    
    <education>
      <period>
        <from>
          <year><?php echo date('Y', $vars['entity']->startdate); ?></year>
          <month>--<?php echo date('m', $vars['entity']->startdate); ?></month>
          <day>----<?php echo date('d', $vars['entity']->startdate); ?></day>
        </from>
        <to>
          <year><?php echo date('Y', $vars['entity']->enddate); ?></year>
          <month>--<?php echo date('m', $vars['entity']->enddate); ?></month>
          <day>----<?php echo date('d', $vars['entity']->enddate); ?></day>
        </to>
      </period>
      <title><![CDATA[ <?php echo $vars['entity']->heading; ?> ]]></title>
      <skills><![CDATA[ <?php echo strip_tags($vars['entity']->skills); ?> ]]></skills>
      <organisation>
        <name><![CDATA[ <?php echo$vars['entity']->structure; ?> ]]></name>
        <address>
          <addressLine><![CDATA[ <?php echo $vars['entity']->contact; ?> ]]></addressLine>
          <municipality><?php /* @todo car adresse non structurée (contact à la place) */ ?></municipality>
          <postalCode><?php /* @todo car adresse non structurée (contact à la place) */ ?></postalCode>
          <country>
            <code><?php /* @todo car adresse non structurée (contact à la place) code = FR, US, etc. */ ?></code>
            <label><?php /* @todo car adresse non structurée (contact à la place)  nom en clair du pays */ ?></label>
          </country>
        </address>
        <type><?php /* @todo car on n'a pas ce champ ?  ex. Université */ ?></type>
      </organisation>
      <level>
        <label><![CDATA[ <?php echo $vars['entity']->level; /* Ne correspond pas avec les données à saisir ??? ex.: CITE 5A */ ?> ]]></label>
      </level>
      <educationalfield>
        <?php /* manque 1 truc ? le code.. */ ?>
        <label><![CDATA[ <?php echo elgg_echo('resume:education:field:' . $vars['entity']->field); /* ex.: Géographie, Economie, Internet*/ ?> ]]></label>
      </educationalfield>
    </education>
    