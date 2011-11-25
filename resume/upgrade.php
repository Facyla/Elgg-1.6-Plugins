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
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

admin_gatekeeper();

$academic_objects = get_entities("object", "rAcademic");
$count = 0;
foreach ($academic_objects as $object) {
    $object->title = $object->achieved_title . " (" . $object->level . ")";
    $object->description = $object->institution;
    $object->save();
    $count++;
}
echo "Succesfully changed $count Academic Objects!<br/>";

$work_objects = get_entities("object", "rWork");
$count = 0;

foreach ($work_objects as $object) {
    $object->title = $object->jobtitle . " @ " . $object->organisation;
    $object->save();
    $count++;
}
echo "Succesfully changed $count Work experience Objects!<br/>";

echo "DONE UPGRADING!";
?>
