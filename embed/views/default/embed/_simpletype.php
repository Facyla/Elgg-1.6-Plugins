<select name="simpletype" id="embed_simpletype_select">
  <?php $all = new stdClass;
  $all->tag = "all";
  $vars['simpletypes'][] = $all;
  $vars['simpletypes'] = array_reverse($vars['simpletypes']);
  if (isset($vars['simpletypes']) && is_array($vars['simpletypes'])) {
    foreach($vars['simpletypes'] as $type) {
      $selected = ($vars['simpletype'] == $type->tag || (empty($vars['simpletype']) && $type->tag == 'all')) ? 'selected = "selected"' : '';
      $tag = $type->tag;
      if ($tag != "all") { $label = elgg_echo("file:type:" . $tag); } else { $tag = ''; $label = elgg_echo('all'); }
      echo '<option ' . $selected . ' value="' . $tag . '">' . $label . '</option>';
    }
  } ?>
</select>
<script type="text/javascript">
$('#embed_simpletype_select').change(function(){
  var simpletype = $('#embed_simpletype_select').val();
  var url = '<?php echo $vars['url']; ?>pg/embed/media?simpletype=' + simpletype + '&amp;internalname=<?php echo $vars['internalname']; ?>';
  $('.popup .content').load(url);
});
</script>
