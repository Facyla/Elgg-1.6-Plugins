<?php
$simpletypes = $vars['simpletypes'];
$simpletypes = array_reverse($simpletypes);
if (isset($simpletypes) && is_array($simpletypes)) {
  foreach($simpletypes as $simpletype) {
    $usedtypes[] = $simpletype->tag;
    $selected = ($vars['simpletype'] == $simpletype->tag) ? 'selected = "selected"' : '';
    $tag = $simpletype->tag;
    if ($tag != "all") { $label = elgg_echo("file:type:" . $tag); }
    $simpletype_options .= '<option ' . $selected . ' value="' . $tag . '">&nbsp; &nbsp; &nbsp; &nbsp;' . $label . "</option>\n";
  }
}
?>
<select name="simpletype" id="embed_simpletype_select">
  <?php
  // Add generic types first : array('object', 'group', 'user', 'site')
  $allowed_types = get_plugin_setting('allowed_types', 'embed');
  $a_types = (strlen($allowed_types) > 0) ? string_to_tag_array($allowed_types) : 'object';  // Default is objects only
  // Subtypes : array('object', 'group', 'user', 'site')
  $allowed_subtypes = get_plugin_setting('allowed_subtypes', 'embed');
  $a_subtypes = (strlen($allowed_subtypes) > 0) ? string_to_tag_array($allowed_subtypes) : 'file';  // Default is files only
  
  // "All" option first
  $selected = (empty($vars['simpletype']) || $vars['simpletype'] === 'all') ? 'selected = "selected"' : '';
  echo '<option ' . $selected . ' value="">' . elgg_echo('embed:all') . '</option>';
  
  // Build the pulldown menu (First types, then subtypes, and file simpletype right after file type)
  // TYPES
  foreach($a_types as $type) {
    $selected = ($vars['simpletype'] == $type) ? 'selected = "selected"' : '';
    $label = elgg_echo('item:' . $type);
    echo '<option ' . $selected . ' value="' . $type . '">' . strtoupper($label) . '</option>';
    if ($type === 'object') {
      // SUBTYPES
      foreach($a_subtypes as $subtype) {
        // Display only subtypes that are not handled as file simpletypes
        if (!in_array($subtype, $usedtypes)) {
          $selected = ($subtype == $vars['simpletype']) ? 'selected = "selected"' : '';
          $label = elgg_echo('item:' . $type . ':' . $subtype);
          echo '<option ' . $selected . ' value="' . $subtype . '">&nbsp; &nbsp;' . $label . '</option>';
        }
        // Add simpletype options (only if files allowed)
        if ($subtype === 'file') { echo $simpletype_options; }
      }
    }
  }
  ?>
</select>
<script type="text/javascript">
$('#embed_simpletype_select').change(function(){
  var simpletype = $('#embed_simpletype_select').val();
  var url = '<?php echo $vars['url']; ?>pg/embed/media?simpletype=' + simpletype + '&amp;internalname=<?php echo $vars['internalname']; ?>';
  $('.popup .content').load(url);
});
</script>
