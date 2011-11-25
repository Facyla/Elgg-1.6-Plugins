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
// Make sure we're logged in (send us to the front page if not)
gatekeeper();

// Get input data
$guid = (int) get_input('id');

// Make sure we actually have permission to edit
$object_to_delete = get_entity($guid);
if (!is_null($object_to_delete)
        && can_edit_entity($guid)
        && ($object_to_delete->getSubtype() == "experience"
        || $object_to_delete->getSubtype() == "workexperience"
        || $object_to_delete->getSubtype() == "education"
        || $object_to_delete->getSubtype() == "skill"
        || $object_to_delete->getSubtype() == "language")
) {

    // Delete it!
    $rowsaffected = $object_to_delete->delete();
    if ($rowsaffected > 0) {
        // Success message
        system_message(elgg_echo('resume:OK'));
    } else {
        register_error(elgg_echo('resume:notOK'));
    }
    // Forward to the main page
    forward($CONFIG->wwwroot . "pg/resumes/" . get_loggedin_user()->username);
}