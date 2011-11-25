<?php
/**
 * Elgg content mapper tool
 * 
 * @package Elggcontent_mapper
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2011
 * @link http://id.facyla.net/
 */

action_gatekeeper(); // Make sure action is secure
admin_gatekeeper(); // This is a very sensible tool : not for local admins at all


// Seul le subtype est nécessaire
$selector['subtype'] = get_input('subtype', null);
// @todo récupérer les subtypes existant (soit table subtype, soit registered subtypes ou similaire)
$valid_sybtypes = array('blog', 'ad', 'page', 'page_top', 'bookmark', );
if (!in_array($selector['subtype'], $valid_sybtypes)) {
  register_error('SUBTYPE non admis.');
  forward();
}
// Les autres sont des filtres
$selector['owner'] = get_input('owner', null);
$selector['container'] = get_input('container', null);
$selectors = array('subtype', 'owner', 'container');

// Champs principaux / génériques
$subtype = get_input('subtype', null);
$owner = get_input('owner', null);
$container = get_input('container', null);
$access_id = get_input('access_id', null);
$mapping = get_input('mapping', null); // Tableau [prop_from][prop_target,default_value,action_if_conflict]

// Liste les noms de propriétés initiales
// @todo : Définir les valeurs par défaut pour chaque ancien champ - est-ce utile ?
foreach ($mapping as $property => $values) {
  $properties[] = $property;
/*
  if (!empty($mapping["$property"]['default_value'];)) {
    ${"new_$property"} = $mapping["$property"]['default_value'];
  } else {
    ${"new_$property"} = null;
  }
*/
}


// Si les critères sont OK pour transformer les contenus
if ($selectors && $mapping && $properties) {
  $old_entities = get_entities();
  
  // Facyla : bypasses any access rights problem while saving new object
//  global $isadmin;
//  $isadmin = true;
  foreach($old_entities as $old) {
    
    // Créer le nouvel objet
    $new_object = new ElggObject();
    $new_object->subtype = "object"; // le type plutôt ?
    $new_object->subtype = "object";
    $new_object->owner_guid = $object->owner_guid;
    $new_object->access_id = ACCESS_PUBLIC; // On pourrait mettre privé ou public aussi...
    $new_object->container_guid = $object->owner_guid;
    $new_object->title = $object->title;
    $new_object->description = $object->description;
    $new_object->container_guid = $object->owner_guid;
    // Le sauver avec les infos de base avant de le modifier
    
    foreach ($properties as $property) {
      // si B existe déjà
      if (!empty($new_object->$property)) {
      /*
        si type de conflit défini
          si reconnu
            si Array => merge
            sinon
              A => B (append / append début / autre ?)
          sinon erreur et on conserve les paramètres
        sinon
          A => B (append)
      */
      } else {
        // A => B
        $new_object->$property = '';
      }
    }
//  $isadmin = false;
  }
}


/* Plan de l'action de transtypage
Notes de conception :
- possibilité de lister plusieurs cibles (cible1,cible2)
- donner valeur par défaut si champ mappé vide (rien => n'ajoute rien et ne crée pas si n'existe pas encore)

si sélecteurs OK
  A = old_entity
  B = new_entity
  si B existe déjà
    si type de conflit défini
      si reconnu
        si Array => merge
        sinon
          A => B (append / append début / autre ?)
      sinon erreur et on conserve les paramètres
    sinon
      A => B (append)
  sinon
    A => B
  si tout est ok = chaque champ correctement mappé (on autorise les champs vides)
    on récupère toutes les infos (timestamps entre autres)
    si save le new object
      delete l'ancien
  rapport d'action
*/


/*  Bout de code utile pour dupliquer un objet
$result = $object->save();
if ($result) {

  // Si tout est OK, on fait d'abord une copie avant de supprimer l'ancien objet
  if ($do_duplicate) {
    // Facyla : bypasses any access rights problem while saving new object (ex. make it private while action is performed by user which is not owner - always the case)
    global $isadmin;
    $isadmin = true;
    $new_object = new ElggObject();
    $new_object->subtype = "object";
    $new_object->owner_guid = $object->owner_guid;
    $new_object->access_id = ACCESS_PUBLIC; // On pourrait mettre privé ou public aussi...
    $new_object->container_guid = $object->owner_guid;
    $new_object->title = $object->title;
    $new_object->description = $object->description;
    $new_object->container_guid = $object->owner_guid;

    // Besoin de sauver avant de charger certaines data.. (tags..)
    if ($new_object->save()) {
      // Config du stage stockée en dur au lieu d'être héritée depuis le groupe, vu qu'on change le Container
      $new_object->object_settings = serialize($object_config);
      $new_object->tags = $object->tags;
      $new_object->lasttutor = $object->lasttutor;
      $new_object->lastcontainer = $object->container_guid; // Le groupe du stage
      // timestamp de la clôture du stage - ça pourra servir
      $new_object->closed_ts = time();
      $new_object->tutor = $object->tutor;
      $new_object->nb_stages = $object->nb_stages;
      $new_object->stages = $object->stages;
      $new_object->studentcomment = $object->studentcomment;
      $new_object->tutorcomment = $object->tutorcomment;
      $new_object->note = $object->note;
      $new_object->validation = $object->validation;
      $new_object->workflow = 'closed';
      $new_object->tags = $object->tags;
      $new_object->access_id = ACCESS_DEFAULT; // On pourrait mettre privé ou public aussi...
      if ($new_object->save()) {
        system_message(elgg_echo("content_mapper:save:duplicate:ok"));
      } else {
        elgg_echo("content_mapper:save:fail:duplicatedata");
      }
      $isadmin = false;
    } else {
        register_error(elgg_echo("content_mapper:save:fail:duplicate"));
    }

    $do_notify["0"] = "$new_workflow";
    $notification = sprintf(elgg_echo('content_mapper:notif:closed'), $new_workflow, $object->workflow) . "\n\n" . $notification;
  }
}

*/


/*
// Get input data
$contents = get_input('object_content', '', false);
$object_title = get_input('object_title');
$pagetype = friendly_title(get_input('pagetype')); // Needs to be URL-friendly

// Empty or very short pagetypes are not allowed
if (empty($pagetype) || strlen($pagetype) < 3 ) {
  register_error(elgg_echo('content_mapper:unsettooshort'));
  forward("mod/content_mapper/index.php");
}

$tags = get_input('object_tags');
//$object_guid = (int)get_input('object_guid'); // not really used (pagetype are unique, as URL rely on them rather than GUID)
$access = get_input('access_id', ACCESS_DEFAULT);
// These are for future developments
$container_guid = get_input('container_guid');
$parent_guid = get_input('parent_guid');
$sibling_guid = get_input('sibling_guid');

// Cache to the session
$_SESSION['object_title'] = $object_title;
$_SESSION['object_content'] = $contents;
$_SESSION['pagetype'] = $pagetype;
$_SESSION['object_tags'] = $tags;

// Facyla 20110214 : following bypass is necessary when using Private access level, which causes objects not to be saved correctly (+doubles)
global $isadmin;
$isadmin = true;

// Get existing object, or create it
$object = NULL;
if (strlen($pagetype)>0) {
  $content_mapper = get_entities_from_metadata('pagetype', $pagetype, "object", "object", 0, 1, 0, "", 0, false);
  $object = $content_mapper[0];
}
if ($object instanceof ElggObject) { $object_guid = $object->getGUID(); } else { $object = new ElggObject(); }


// Edition de l'objet existant ou nouvellement créé
//$object->owner_guid = $_SESSION['user']->getGUID(); // Set owner to the current user
$object->id = $object_guid;
$object->subtype = 'object';
$object->owner_guid = $CONFIG->site->guid; // Set owner to the current site (nothing personal, hey !)
$object->access_id = $access;
$object->pagetitle = $object_title;
$object->pagetype = $pagetype;
$object->description = $contents;
$object->container_guid = $CONFIG->site->guid;  // Set container to the current site (nothing personal, hey !)
$object->parent_guid = $parent_guid;
$object->sibling_guid = $sibling_guid;

// Save new/updated content
if (!$object->save()) {
  register_error(elgg_echo("content_mapper:error") . $_SESSION['guid'] . '=> ' . get_plugin_setting('editors', 'content_mapper'));
  $isadmin = false;
  forward("mod/content_mapper/index.php?pagetype=$pagetype");
}

// Now let's add tags. We can pass an array directly to the object property! Easy.
$tagarray = string_to_tag_array($tags); // Convert string of tags into a preformatted array
if (is_array($tagarray)) { $object->tags = $tagarray; }


// Success message
system_message(elgg_echo("content_mapper:posted"));
//add_to_river('river/content_mapper/create','create',$_SESSION['user']->guid, $content_mapper->guid); // add to river

// Remove the cache
unset($_SESSION['object_content']); unset($_SESSION['object_title']); unset($_SESSION['pagetype']); unset($_SESSION['object_tags']);
      
$isadmin = false;

// Forward back to the page
forward("pg/content_mapper/index.php?pagetype=$pagetype");
  
*/

