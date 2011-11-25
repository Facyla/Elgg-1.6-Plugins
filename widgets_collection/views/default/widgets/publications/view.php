<style type="text/css">
#widgets_collection_widget .pagination {
    display:none;
}
</style>
<?php
/**
* Elgg widgets_collection widget edit
*
* @package Elggwidgets_collection
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla <admin@facyla.fr>
* @copyright Facyla 2010
* @link http://id.facyla.net/
*/

$num_display = $vars['entity']->widgets_collection_num;
$owners = $vars['entity']->widgets_collection_owners;
$subtypes = $vars['entity']->widgets_collection_subtypes;
$sortorder = $vars['entity']->widgets_collection_sort;
$fullview = false;
$toggletype = false;
$pagination = true;

$objecttypes = array( 'object' => array('blog','file','bookmarks', 'page', 'page_top') );

if (empty($num_display)) { $num_display = 1; }
if (empty($owners)) { $subject_guid = page_owner(); } else { $subject_guid = $owners; }  // pas opérationnel..
$subject_guid = page_owner();

if (!$fullview) set_context('search');

$widgets_collection = list_entities("object", $objecttypes, $subject_guid, $num_display, $fullview, $toggletype, $pagination); // passer en get pour pouvoir récupérer les URL et normaliser l'affichage

$widgets_collectionurl = $vars['url'] . "pg/riverdashboard/";
//	 $widgets_collectionurl = $vars['url'] . "pg/widgets_collection/owned/" . page_owner_entity()->username;  // à modifier pour différencier les liens selon les objets

$widgets_collection .= "<div class=\"widgets_collection_widget_singleitem_more\"><a href=\"{$widgets_collectionurl}\">" . elgg_echo('widgets_collection:more') . "</a></div>";

echo "<div id=\"widgets_collection_widget\">" . $widgets_collection . "</div>";

