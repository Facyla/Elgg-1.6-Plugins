    
    <workexperience>
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
			<position>
        <label><![CDATA[ <?php echo $vars['entity']->heading; ?> ]]></label>
      </position>
      <activities><![CDATA[ <?php echo strip_tags(utf8_encode(unhtmlentities($vars['entity']->typology . ' : ' . $vars['entity']->description))); ?> ]]></activities>
      <employer>
        <name><![CDATA[ <?php echo $vars['entity']->structure; ?> ]]></name>
        <address>
          <addressLine><![CDATA[ <?php echo $vars['entity']->contact; /* @todo car adresse non structurée (contact à la place) */ ?> ]]></addressLine>
          <municipality><?php /* @todo car adresse non structurée (contact à la place) */ ?></municipality>
          <postalCode><?php /* @todo car adresse non structurée (contact à la place) */ ?></postalCode>
          <country>
            <code><?php /* @todo car adresse non structurée (contact à la place) code = FR, US, etc. */ ?></code>
            <label><?php /* @todo car adresse non structurée (contact à la place)  nom en clair du pays */ ?></label>
          </country>
        </address>
        <sector>
          <code></code>
          <label></label>
        </sector>
      </employer>
    </workexperience>
    