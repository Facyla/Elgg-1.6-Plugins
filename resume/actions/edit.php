<?php
/**
 * Resume
 *
 * @package Resume
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
// only logged in users can add and edit object
gatekeeper();

// get the form input
$guid = (int) get_input('id');

if (can_edit_entity($guid)) {
  
  //get the object to replace the metadata
  $rObject = get_entity($guid);
  
  // Only edit the right subtype..
  if (in_array($rObject->getSubtype(), array("education", "workexperience", "experience", "skill", "skill_ciiee", "language"))) {
    
    $object_metadata_array = get_metadata_for_entity($guid);
    foreach ($object_metadata_array as $meta_object) {
      $name = $meta_object->name;
      $rObject->$name = get_input($name);
    }
    
    // set acces
//      $rObject->access_id = ACCESS_PUBLIC;
    $rObject->access_id = get_input('access_id', $rObject->access_id);
    
    // Force dates, as they sometimes break..
    if ($rObject->getSubtype() != "language") {
      $rObject->startdate = get_input('startdate', $rObject->startdate);
      $rObject->enddate = get_input('enddate', $rObject->enddate);
    }
    
    // set title and process specific data subtypes
    switch($rObject->getSubtype()) {
      
      case "experience" :
        $rObject->title = $rObject->heading . ' @ ' . $rObject->structure;
        break;
      
      case "language" :
        $rObject->language = get_input('langcode', $rObject->language);
        $rObject->title = $rObject->language;
        break;
      
      case "skill_ciiee" :
        $rObject->title = $rObject->skilltype;
        break;
      
      case "workexperience" :
        $rObject->title = $rObject->heading . ' @ ' . $rObject->structure;
        $rObject->description = get_input('description');
        break;
      
      case "skill" :
        switch($rObject->skilltype) {
          case "driving":
            $rObject->title = elgg_echo('resumes:skill:driving:' . get_input('driving'));
            break;
          default:
            $rObject->title = $rObject->skill;
        }
        break;
      
      case "education" :
        $rObject->title = $rObject->heading . ' @ ' . $rObject->structure;
        break;
      
      default:
    }
    
    // save to database
    $rObject->save();
    system_message(elgg_echo('resume:OK'));

    // add to river
//    add_to_river('river/object/resume/update', 'update', get_loggedin_userid(), $rObject->guid);
    
  }
  
} else {
  register_error(elgg_echo('resume:notOK'));
}

// forward user to the main page
forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
