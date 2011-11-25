What are Static pages ?
- have a specific URL (ex. mainpage)
- are editable by any admin user (localadmin also in multisite context)
- can then be linked from site menu..
- don't trigger any notification
- changes take effect immediately, but there's no history : care not to empty field before saving (empty fields are allowed)
- access level can be set for each page


Instructions

How to create a new page :
- click on page title ("new page") or click "+" if you're already on a existing page
- type page URL name (can't be changed)
- press Enter (non-Javascript : click button)
- edit form, then click the Create page button
Important notice : URL page name only accepts <strong>alphanum chars, and no space nor other signs except : "-", "_" and ".". Other characters will not be taken into account

How to edit an existing page :
- select a page through the dropdown
- edit it, then save

CMS Pages use 2 views, so that their content can be embedded into a theme and make it customizable
  - cmspages/read is used for fullview cmpages rendering, and may render more content (title, etc.)
  - cmspages/view view should return only cmspage description (other elements should be hidden), and is designed for inclusion into other views

How to insert a CMS Page into interface ?
- add following code where you want to insert the page content : elgg_view('cmspages/view', array('pagetype' => $pagetype));
- replace $pagetype by the the unique string that is at the end of a CMS Page view URL : pg/cmspages/read/[PAGETYPE]

