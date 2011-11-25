<?php

	/**
	 * Elgg custom index
	 * 
	 * @package ElggCustomIndex
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Curverider Ltd <info@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	// Get the Elgg engine
  require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
	
//forward(); // Pour les tests seulement (commenter pour utiliser)

	admin_gatekeeper();
		
//	set_context('search');//display results in search mode, which is list view
  $subtypes = array( 'object' => array('blog','file','bookmarks', 'page', 'page_top') );
//  $area7 = list_entities('object',$subtypes,0,15,false, false, false);
  
  $body = "<h3>Tests accès (Vous = " . $_SESSION['user']->guid . ")</h3>";
global $is_admin;
$is_admin = true;
  $object_guid = 14056; // Réservé à Nouveau groupe
  $object = get_entity($object_guid);
  $access_id = $object->access_id; // 49=collection Nouveau groupe
  $container_guid = $object->container_guid;
  $container_name = get_entity($container_guid)->name;
  $owner = $object->getOwner();

  $object_guid2 = 14240; // Réservé à groupe dont user2 ne fait pas partie (Comité Pilotage), mais dans Nouveau groupe
  $object2 = get_entity($object_guid2);
  $access_id2 = $object2->access_id; // 49=collection Nouveau groupe
  $container_guid2 = $object2->container_guid;
  $container_name2 = get_entity($container_guid2)->name;
  if($object2 instanceof ElggObject) $owner2 = $object2->owner_guid; else $owner2 = "not an object ?";  // PQ un objet n'en est plus un selon qui affiche le test ?
  $user = 4; // 4=Facyla   14084=Test
  $user2 = 14084;
$is_admin = false;
  
  $body .= ""
    . "<br />object = <strong>$object_guid</strong>" . " // container = <strong>$container_guid</strong> $container_name" . " // owner = <strong>$owner</strong>" . " // access_id = <strong>$access_id</strong>"
    . "<br />object2 = <strong>$object_guid2</strong>" . " // container2 = <strong>$container_guid2</strong> $container_name2" . " // owner2 = <strong>$owner2</strong>" . " // access_id2 = <strong>$access_id2</strong>"
    . "<br />user = <strong>$user</strong>" . " // user access list = <strong>" . get_access_list($user, -1, true) . "</strong>"
    . "<br />user2 = <strong>$user2</strong>" . " // user2 access list = <strong>" . get_access_list($user2, -1, true) . "</strong>"
    // PQ cette liste ne change pas selon l'user mais l'user en session ???
    . "<br />"
    . "<hr />";
    $body .=  "<h4>Réservé à Nouveau groupe</h4>";
    $body .=  (has_access_to_entity_by_guid($object_guid, $user)) ? "<br />$user a accès à $object_guid <strong>OK</strong>" : "<br /><span style='text-decoration: line-through;'>$user n'a pas accès à $object_guid</span> <strong style=\"color:red;\">NON !</strong>";
    $body .=  (has_access_to_entity_by_guid($object_guid, $user2)) ? "<br />$user2 a accès à $object_guid <strong>OK</strong>" : "<br /><span style='text-decoration: line-through;'>$user2 n'a pas accès à $object_guid</span> <strong style=\"color:red;\">NON !</strong>";

    $body .= "<br /><br /><h4>Réservé à groupe dont user2 ne fait pas partie (Comité Pilotage), mais dans Nouveau groupe</h4>";
    $body .=  (has_access_to_entity_by_guid($object_guid2, $user)) ? "<br />$user a accès à $object_guid2 <strong>OK</strong>" : "<br /><span style='text-decoration: line-through;'>$user n'a pas accès à $object_guid2</span> <strong style=\"color:red;\">NON !</strong>";
    $body .=  (has_access_to_entity_by_guid($object_guid2, $user2)) ? "<br />$user2 a accès à $object_guid2 <strong style=\"color:red;\">NON !</strong>" : "<br /><span style='text-decoration: line-through;'>$user2 n'a pas accès à $object_guid2</span> <strong>OK</strong>";

    $body .= "<br /><br /><h4>Réservé à Equipe animation (publié hors groupe)</h4>";
    $body .=  (has_access_to_entity_by_guid(11455, $user)) ? "<br />$user a accès à 11455 <strong>OK</strong>" : "<br /><span style='text-decoration: line-through;'>$user n'a pas accès à 11455</span> <strong style=\"color:red;\">NON !</strong>";
    $body .=  (has_access_to_entity_by_guid(11455, $user2)) ? "<br />$user2 a accès à 11455 <strong style=\"color:red;\">NON !</strong>" : "<br /><span style='text-decoration: line-through;'>$user2 n'a pas accès à 11455</span> <strong>OK</strong>";

    $body .= "<br /><br /><h4>Privé réservé 4 (hors groupe)</h4>";
    $body .=  (has_access_to_entity_by_guid(11454, $user)) ? "<br />$user a accès à 11454 <strong>OK</strong>" : "<br /><span style='text-decoration: line-through;'>$user n'a pas accès à 11454</span> <strong style=\"color:red;\">NON !</strong>";
    $body .=  (has_access_to_entity_by_guid(11454, $user2)) ? "<br />$user2 a accès à 11454 <strong style=\"color:red;\">NON !</strong>" : "<br /><span style='text-decoration: line-through;'>$user2 n'a pas accès à 11454</span> <strong>OK</strong>";
    $body .= "<br />";
  
    $body .= "<br /><br /><h4>Objet privé (contacts) d'un autre user non admin (dans le groupe)</h4>";
    $body .=  (has_access_to_entity_by_guid(13965, $user)) ? "<br />$user a accès à 13965 <strong>OK</strong>" : "<br /><span style='text-decoration: line-through;'>$user n'a pas accès à 13965</span> <strong style=\"color:red;\">NON !</strong>";
    $body .=  (has_access_to_entity_by_guid(13965, $user2)) ? "<br />$user2 a accès à 13965 <strong style=\"color:red;\">NON !</strong>" : "<br /><span style='text-decoration: line-through;'>$user2 n'a pas accès à 13965</span> <strong>OK</strong>";
    $body .= "<br />";
  
  //display the contents in our new canvas layout
	$body = elgg_view_layout('one_column', '<div style="padding:10px;">' . $body . '</div>');
   
    page_draw($title, $body);
		
?>