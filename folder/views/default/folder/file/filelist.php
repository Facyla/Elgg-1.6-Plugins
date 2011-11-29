<?php
	/**
   * @package Elgg
   * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
   * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
   * @link http://grc.ucalgary.ca/
   */

	$viewtype = $vars['viewtype'];
	$files = $vars['files'];
	if($files) {
    $html = "";
    foreach($files as $file) {
      $guid = $file->getGUID();
      $fileview = elgg_view_entity($file);
      $html .= <<< EOT
        <div id="$guid">
        $fileview
        </div>
        <script type='text/javascript'>
        $("#$guid").draggable({
          helper:'clone',
          opacity:0.6,
          cursor: 'move',
        });
        </script>
EOT;
    }
	}
echo $html;
