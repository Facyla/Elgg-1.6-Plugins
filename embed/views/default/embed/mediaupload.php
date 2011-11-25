<h1 class="mediaModalTitle"><?php elgg_echo('embed:embedupload'); ?></h1>

<div>
  <?php
  echo '<h3>' . elgg_echo('embed:media') . ' &nbsp; ';
	echo elgg_view('embed/simpletype',array(
      'internalname' => $vars['internalname'],
      'simpletypes' => $vars['simpletypes'],
      'simpletype' => $vars['simpletype'],
    ));
  echo '</h3>';
	echo elgg_view('embed/pagination',array(
      'offset' => $vars['offset'],
      'baseurl' => $vars['url'] . 'pg/embed/media?internalname=' . $vars['internalname'] . "&amp;simpletype=" . $vars['simpletype'],
      'limit' => $vars['limit'],
      'count' => $vars['count']
    ));
	
	$context = get_context();
	$entities = $vars['entities'];
	if (is_array($entities) && !empty($entities)) {
		echo "<p class=\"embedInstructions\">" . elgg_echo('embed:instructions') . "</p>";
		
		foreach($entities as $entity) {
			if ($entity instanceof ElggEntity) {
				$mime = $entity->mimetype; 
				$enttype = $entity->getType();
				$entsubtype = $entity->getSubtype();
				
				if (elgg_view_exists($enttype . '/' . $entsubtype . '/embed')) {
					$content = elgg_view($enttype . '/' . $entsubtype . '/embed', array('entity' => $entity, 'full' => true));
				} else {
					$content = elgg_view($enttype . '/default/embed', array('entity' => $entity, 'full' => true));
				}
				
				$content = str_replace("\n","", $content);
				$content = str_replace("\r","", $content);
				$content = str_replace("'","&#39;", $content);
				//$content = htmlentities($content,null,'utf-8');
				$content = htmlentities($content, ENT_QUOTES, "UTF-8");
				
				$link = "javascript:elggUpdateContent('{$content}','{$vars['internalname']}');";
				if ($entity instanceof ElggObject) { $title = $entity->title; $mime = $entity->mimetype; } else { $title = $entity->name; $mime = ''; }
				
				set_context('search');
				
				if (elgg_view_exists("{$enttype}/{$entsubtype}/embedlist")) {
					$entview = elgg_view("{$enttype}/{$entsubtype}/embedlist",array('entity' => $entity));
				} else {
//					$entview = elgg_view_entity($entity);
					$entview = elgg_view("embed/embedlist",array('entity' => $entity));
				}
				$entview = str_replace($entity->getURL(),$link,$entview);
				echo $entview;
				
				set_context($context);				
			}
		}
	} else if (empty($entities)) {
    echo "<p class=\"embedInstructions\">" . elgg_echo('embed:empty') . "</p>";
	}
  ?>
  <br />
  <br />
  <p><a href="javascript:void(0);" class="inline_toggler" onclick="$('#embed_upload_toggle').toggle();"><?php echo '<h3>' . elgg_echo('upload:media') . '</h3>'; ?></a></p>
  <div id="embed_upload_toggle" style="display:none;">
    <?php
    if (!elgg_view_exists('file/upload')) {
      echo "<p>" . elgg_echo('embed:file:required') . "</p>";
    } else {
      $action = 'file/upload';
      ?>
      <form action="<?php echo $vars['url']; ?>action/file/upload" method="post" enctype="multipart/form-data">
        <p>
          <?php echo elgg_echo("embed:uploadfile") . ' ' . elgg_view("input/file",array('internalname' => 'upload', 'js' => 'id="upload"')); ?>
        </p>
        <p>
          <?php echo elgg_echo("title") . ' ' . elgg_view("input/text", array("internalname" => "title", "value" => $title, 'js' => "style=\"width:70%;\"" )); ?>
        </p>
        <p><?php echo elgg_echo("description"); ?><br />
          <textarea class="input-textarea" name="description" id="filedescription" style="height:6ex;"></textarea>
<!--
          <?php //echo elgg_view('input/longtext', array('internalname' => 'description', 'internalid' => 'filedescription')); ?>
//-->
        </p>
        <p>
          <?php echo "Tags" . ' ' . elgg_view("input/tags", array("internalname" => "tags", "value" => $tags, 'js' => "style=\"width:80%;\"",)); ?>
        </p>
        <p>
          <?php echo elgg_echo('access') . ' ' . elgg_view('input/access', array('internalname' => 'access_id','value' => $access_id)); ?>
        </p>

        <p><?php
          if (isset($vars['container_guid'])) echo "<input type=\"hidden\" name=\"container_guid\" value=\"{$vars['container_guid']}\" />";
          if (isset($vars['entity'])) echo "<input type=\"hidden\" name=\"file_guid\" value=\"{$vars['entity']->getGUID()}\" />";
          ?>
          <input type="submit" value="<?php echo elgg_echo("save"); ?>" />
        </p>
      </form>
      
      <script type="text/javascript"> 
      // wait for the DOM to be loaded 
      //$(document).ready(function() { 
        // bind 'myForm' and provide a simple callback function 
        $('#mediaUpload').submit(function() {
          var options = {  
            success:    function() {
              $('.popup .content').load('<?php echo $vars['url'] . 'pg/embed/media'; ?>?internalname=<?php echo $vars['internalname']; ?>'); 
            }
          }; 
          $(this).ajaxSubmit(options);
          return false; 
        }); 
      //}); 
      </script>
      
    <?php } ?>
    
  </div>
  
</div>