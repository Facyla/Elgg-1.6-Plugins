<?php
$english = array(

  'cmspages' => "Static pages (CMS)",
  'item:object:cmspages' => 'Static pages',
  
  'cmspages:pagetype' => "Page URL name",
  'cmspages:cmspage_url' => "Published page URL :",
  'cmspages:pageselect' => "Choose which page to edit",
  
  'cmspages:new' => "OK",
  'cmspages:newpage' => "Create page \"%s\"",
  'cmspages:createmenu' => "Create a new page",
  'cmspages:newtitle' => "Click to choose page title",
  'cmspages:settitle' => "Click to edit title",
  'cmspages:create' => "Create page !",
  'cmspages:save' => "Update page",
  'cmspages:preview' => "Preview",
  'cmspages:delete' => "Delete page",
  'cmspages:deletewarning' => "Warning : you can\'t restore a deleted page. You may prefer to cancel and make this page private instead if you don\t want to lose content.", // Adds backslashes if you use "'" !  (ex.: can\'t)
  'cmspages:showinstructions' => "Display detailed instructions",
  'cmspages:instructions' => "How to use static pages :<ul>
      <li>have a specific URL (ex. mainpage)</li>
      <li>are editable by any admin user (localadmin also in multisite context)</li>
      <li>can then be linked from site menu..</li>
      <li>don't trigger any notification</li>
      <li>changes take effect immediately, but there's no history : care not to empty field before saving (empty fields are allowed)</li>
      <li>access level can be set for each page</li>
      <li>How to create a new page :
        <ol>
          <li>click \"+\"</li>
          <li>type page URL name (can't be changed)</li>
          <li>press Enter (non-Javascript : click button)</li>
          <li>edit form, then click the Create page button</li>
        </ol>
        <strong>Warning :</strong> URL page name only accepts <strong>alphanum chars, and no space nor other signs except : \"-\", \"_\" et \".\"</strong>
      </li>
    </ul>",
  
  /* Status messages */
  'cmspages:posted' => "Page was successfully updated.",
  'cmspages:deleted' => "The static page was successfully deleted.",
  
  /* Error messages */
  'cmspages:nopreview' => "No preview yet",
  'cmspages:notset' => "This page doesn't exist, or you need to log in to view it.",
  'cmspages:delete:fail' => "There was a problem deleting the page",
  'cmspages:error' => "There has been an error, please try again and if the problem persists, contact the administrator",
  'cmspages:unsettooshort' => "Page URL name undefined or too short (minimum 2 )",
  
  'cmspages:pagescreated' => "%s pages created",
  
  /* Settings */
  'cmspages:settings:layout' => "Layout",
  'cmspages:settings:layout:help' => "Use default layout, or externalblog layout parameters ? I you have no idea or do not use externalblog plugin, let default choice.",
  'cmspages:settings:layout:default' => "Default",
  'cmspages:settings:layout:externalblog' => "Use externablog layout config",
  'cmspages:settings:editors' => "Additional editors",
  'cmspages:settings:editors:help' => "List of GUID, separated by commas. These editors are allowed to edit even if they're not admin, in addition to the admins (who have edit access on cmspages anyway).",
  
);
    
add_translation("en",$english);

