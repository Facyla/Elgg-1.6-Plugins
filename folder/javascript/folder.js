/**
 * * license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * * author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * * link http://grc.ucalgary.ca/
 * */

function update_files_list(guid, page_owner){
	$.ajax({
		url: wwwroot + 'mod/folder/read.php',
		cache: false,
		data: 'folderguid='+guid+'&page_owner='+page_owner,
		success: function(data){
			$('#files_list').html(data);
		},
	});
}

function all_files_list(page_owner){
  $.ajax({
    url: wwwroot + 'mod/folder/read.php',
    data: 'page_owner='+page_owner,
    cache: false,
    success: function(data){
      $('#files_list').html(data);
    },
  });
}

function movefile(token, ts, folderguid, fileguid, cfolder, page_owner){
	$.ajax({
		url: wwwroot + 'action/folder/movefile',
		data: '__elgg_token='+token+'&__elgg_ts='+ts+'&folderguid='+folderguid+'&fileguid='+fileguid,
		cache: false,
		success: function(){
			update_files_list(cfolder, page_owner);
		},
	});
}
