<?php
/**
 * @package Elgg
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Tingxi Tan, Grid Research Centre [txtan@cpsc.ucalgary.ca]
 * @link http://grc.ucalgary.ca/
 */

gatekeeper();
action_gatekeeper();

$fileguid = get_input('fileguid');
$file = get_entity($fileguid);
if($file->canEdit()) {
  $folderguid = get_input('folderguid');	
  //remove file from previous folder
  $file->folder = $folderguid;
  remove_entity_relationships($fileguid, 'folder_of', true);

  // Facyla : force 302 error response as 200 - not very clean yet +> todo : system messages
  // process the request by fetching the info
//    $headers = http_get_request_headers();
//    $result = http_get_request_body();
  // Do stuff with the $headers and $result variables, then send your response
  
  // Ne fonctionne que si le module PECL est activé..
  if (class_exists('HttpResponse')) {
    HttpResponse::status(200);
    HttpResponse::setContentType('text/html');

    if($folderguid != 'none') {
      if (add_entity_relationship($folderguid, 'folder_of', $fileguid) ) {
        HttpResponse::setData('true'); // Success : added to new folder
        HttpResponse::send();
      } else {
        HttpResponse::setData('false'); // Error : no move
        system_message(elgg_echo("folder:move:noperm"));
      }
    } else {
      HttpResponse::setData('true'); // Success : added to (default) folder
      HttpResponse::send();
    }
    
  // Workaround
  } else {
    if($folderguid != 'none') {
      if (add_entity_relationship($folderguid, 'folder_of', $fileguid) ) {
        header('HTTP/1.0 200 OK', true, 200);
      } else {
        header('HTTP/1.0 200 OK', false, 200);
        system_message(elgg_echo("folder:move:noperm"));
      }
    }
  }
  
} else { // Facyla : error message if not allowed
  system_message(elgg_echo("folder:move:noperm"));
  forward($_SERVER['HTTP_REFERER']);
}

