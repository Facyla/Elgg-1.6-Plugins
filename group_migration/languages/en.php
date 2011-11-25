<?php

	$english = array(
    'group_migration:menu' => "Groups members and objects migration",
    'group_migration:title' => "Migration tool for members, objects and groups",
    'group_migration:menu:transfer' => "Groups transfer between sites",
    'group_migration:menu:transfer:title' => "Transfer tool for groups between sites (multisite)",
    
    'group_migration:grouplist:title' => "%1\$s's %s groups",
    'group_migration:objects' => "Objects",
    'group_migration:members' => "Members",
    'group_migration:ingroup' => "in group",
    'group_migration:submit' => "Go !",
    'group_migration:grouplist:item' => '<b>%s objects</b> and <b>%s members</b> in',
    
    'group_migration:migration:title' => 'Moving from <i>%s</i> to <i>%s</i>&nbsp;:',
    'group_migration:migration:objects:success' => 'All done, %s objects have been transfered',
    'group_migration:migration:objects:fail' => 'Gasp, %s fails and %s objects transfered',
    'group_migration:migration:objects:none' => 'Don\'t worry, but no transfer : %s fails and %s objects transfered',
    
    'group_migration:migration:members:success' => 'All done, the %s members of %s were transfered into the group %s',
    'group_migration:migration:members:fail' => 'Gasp, %s fails and %s new members in group %s',
    'group_migration:migration:members:none' => 'Don\'t worry, but no new group members : %s fails and %s member in new group',
    
	);
					
	add_translation("en",$english);
