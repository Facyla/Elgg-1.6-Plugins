<style type="text/css">
#widgets_collection_widget .pagination { display:none; }
</style>
<?php
/**
* Widgets_collection widget edit
*
* @package Elggwidgets_collection
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Facyla <admin@facyla.fr>
* @copyright Facyla 2010
* @link http://id.facyla.net/
*/
$name = page_owner_entity()->name;

$doyoubuzz = $vars['entity']->widgets_collection_doyoubuzz;
$delicious = $vars['entity']->widgets_collection_delicious;
$facebook = $vars['entity']->widgets_collection_facebook;
$linkedin = $vars['entity']->widgets_collection_linkedin;
$skype = $vars['entity']->widgets_collection_skype;
$twitter = $vars['entity']->widgets_collection_twitter;
$viadeo = $vars['entity']->widgets_collection_viadeo;
$netvibes = $vars['entity']->netvibes;
$pearltrees = $vars['entity']->pearltrees;
$flickr = $vars['entity']->flickr;

$rss = $vars['entity']->widgets_collection_rss;
$rss2 = $vars['entity']->widgets_collection_rss2;
$rss3 = $vars['entity']->widgets_collection_rss3;

$site = $vars['entity']->widgets_collection_site;
$site2 = $vars['entity']->widgets_collection_site2;
$site3 = $vars['entity']->widgets_collection_site3;

$mail = $vars['entity']->widgets_collection_mail;
$mail2 = $vars['entity']->widgets_collection_mail2;
$mail3 = $vars['entity']->widgets_collection_mail3;

$widgets_collection = '<div id="widgets_collection_widget">'; // Wrapper start

// Delicious
if ($delicious) { $widgets_collection .= '<a href="http://www.delicious.com/' . $delicious . '/" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/delicious-32.png" title="' . $name . ' sur Delicious" alt="Delicious" /></a> '; }

// DoYouBuzz
if ($doyoubuzz) { $widgets_collection .= '<a href="http://www.doyoubuzz.com/' . $doyoubuzz . '/" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/doyoubuzz-32.png" title="' . $name . ' sur Do You Buzz" alt="DoYouBuzz" /></a> '; }

// Facebook : 2 formats : /identifiant ou /profile.php?id=numéro
if ($facebook) {
  // Si on trouve autre chose que des chiffres seuls, on considère que c'est un username (donc pas de modif)
  if(preg_match('#[^0-9]#',$facebook)) {} else { $facebook = "profile.php?id=$facebook"; }
  $widgets_collection .= '<a href="http://www.facebook.com/' . $facebook . '" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/facebook-32.png" title="' . $name . ' sur Facebook" alt="Facebook" /></a> ';
}

// Linkedin : http://fr.linkedin.com/in/identifiant ou http://www.linkedin.com/pub/identifiant/en/pls/parties
if ($linkedin) {
  // si on trouve un / dans l'identifiant, on switche..
  if (strrpos ($linkedin , "/")) $linkedin = "pub/$linkedin"; else $linkedin = "in/$linkedin";
  $widgets_collection .= '<a href="http://fr.linkedin.com/' . $linkedin . '" title="' . $linkedin . ' sur Linkedin"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/linkedin-32.png" title ="' . $name . ' sur Linkedin" alt="Linkedin" /></a> ';
}

// Skype
if ($skype) { $widgets_collection .= '<a href="callto://' . $skype . '" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/skype-32.png" title="' . $skype . ' sur Skype" alt="Skype" /></a> '; }

// Twitter
if ($twitter) { $widgets_collection .= '<a href="http://twitter.com/' . $twitter . '" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/twitter-32.png" title="' . $twitter . ' sur Twitter" alt="Twitter" /></a> '; }

// Viadeo : http://www.viadeo.com/fr/profile/identifiant ou http://www.viadeo.com/profile/code_utilisateur
if ($viadeo) {
  if ((strlen($viadeo) == 15) && (substr($viadeo,0,3) == '002')) $viadeo = "profile/$viadeo"; else $viadeo = "fr/profile/$viadeo"; 
  $widgets_collection .= '<a href="http://www.viadeo.com/' . $viadeo . '" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/viadeo-32.png" title="' . $name . ' sur Viadeo" alt="Viadeo" /></a> ';
}

// Netvibes
if ($netvibes) { $widgets_collection .= '<a href="http://www.netvibes.com/' . $netvibes . '" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/netvibes-32.png" title="' . $name . ' sur Netvibes" alt="Netvibes" /></a> '; }

// Pearltrees
if ($pearltrees) { $widgets_collection .= '<a href="http://www.pearltrees.com/' . $pearltrees . '" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/pearltrees-32.png" title="' . $name . ' sur Pearltrees" alt="Pearltrees" /></a> '; }

// FlickR
if ($flickr) { $widgets_collection .= '<a href="http://www.flickr.com/photos/' . $flickr . '" title=""><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/flickr-32.png" title="' . $name . ' sur FlickR" alt="FlickR" /></a> '; }



/* Syndication - Fils RSS */
if ($rss) { $widgets_collection .= '<a href="' . $rss . '" title="Fil RSS : ' . $rss . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/rss-32.png" alt="' . $rss . '" /></a> '; }
if ($rss2) { $widgets_collection .= '<a href="' . $rss2 . '"  title="Fil RSS : ' . $rss2 . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/rss-32.png" alt="' . $rss2 . '" /></a> '; }
if ($rss3) { $widgets_collection .= '<a href="' . $rss3 . '"  title="Fil RSS : ' . $rss3 . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/rss-32.png" alt="' . $rss3 . '" /></a> '; }

/* Websites */
if ($site) { $widgets_collection .= '<a href="' . $site . '" title="Site : ' . $site . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/site-32.png" alt="' . $site . '" /></a> '; }
if ($site2) { $widgets_collection .= '<a href="' . $site2 . '" title="Site : ' . $site2 . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/site-32.png" alt="' . $site2 . '" /></a> '; }
if ($site3) { $widgets_collection .= '<a href="' . $site3 . '" title="Site : ' . $site3 . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/site-32.png" alt="' . $site3 . '" /></a> '; }

/* Mail */
if ($mail) { $widgets_collection .= '<a href="mailto:' . $mail . '" title="Ecrire à ' . $mail . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/mail-32.png" alt="' . $mail . '" /></a> '; }
if ($mail2) { $widgets_collection .= '<a href="mailto:' . $mail2 . '" title="Ecrire à ' . $mail2 . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/mail-32.png" alt="' . $mail2 . '" /></a> '; }
if ($mail3) { $widgets_collection .= '<a href="mailto:' . $mail3 . '" title="Ecrire à ' . $mail3 . '"><img src="' . $vars['url'] . 'mod/widgets_collection/graphics/mail-32.png" alt="' . $mail3 . '" /></a> '; }


$widgets_collection .= '</div>';  // Wrapper end


echo '<div class="clearfloat"></div><div style="padding:6px;">' . $widgets_collection . '</div><div class="clearfloat"></div>'; // Displays the widget

