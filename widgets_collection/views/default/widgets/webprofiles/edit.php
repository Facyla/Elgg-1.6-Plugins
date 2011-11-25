<?php
    /**
	 * Elgg widgets_collection widget edit
	 *
	 * @package Elggwidgets_collection
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Facyla
	 * @copyright Facyla 2010
	 * @link http://id.facyla.net/
	 */
	 
	 /* TODO
	 * paramétrages pour rendre le widget le plus générique possible :
   *  choix du owner ou des owners (array),
   *  multiselect des types de contenus à lister,
   *  ordre de tri
   *  tuples : Sujet, prédicat, valeur (=> nom affiché, nom du service, URL)
	 */

?>
  <p>
    <?php echo elgg_echo('widgets_collection:webprofiles:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:delicious'); ?>
		<input type="text" name="params[widgets_collection_delicious]" value="<?php echo htmlentities($vars['entity']->widgets_collection_delicious); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:delicious:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:doyoubuzz'); ?>
		<input type="text" name="params[widgets_collection_doyoubuzz]" value="<?php echo htmlentities($vars['entity']->widgets_collection_doyoubuzz); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:doyoubuzz:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:facebook'); ?>
		<input type="text" name="params[widgets_collection_facebook]" value="<?php echo htmlentities($vars['entity']->widgets_collection_facebook); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:facebook:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:linkedin'); ?>
		<input type="text" name="params[widgets_collection_linkedin]" value="<?php echo htmlentities($vars['entity']->widgets_collection_linkedin); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:linkedin:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:skype'); ?>
		<input type="text" name="params[widgets_collection_skype]" value="<?php echo htmlentities($vars['entity']->widgets_collection_skype); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:skype:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:twitter'); ?>
		<input type="text" name="params[widgets_collection_twitter]" value="<?php echo htmlentities($vars['entity']->widgets_collection_twitter); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:twitter:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:viadeo'); ?>
		<input type="text" name="params[widgets_collection_viadeo]" value="<?php echo htmlentities($vars['entity']->widgets_collection_viadeo); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:viadeo:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:netvibes'); ?>
		<input type="text" name="params[netvibes]" value="<?php echo htmlentities($vars['entity']->netvibes); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:netvibes:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:pearltrees'); ?>
		<input type="text" name="params[pearltrees]" value="<?php echo htmlentities($vars['entity']->pearltrees); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:pearltrees:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:flickr'); ?>
		<input type="text" name="params[flickr]" value="<?php echo htmlentities($vars['entity']->flickr); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:flickr:help'); ?></em>
  </p>
  
  <br />
  
	<h4><?php echo elgg_echo('widgets_collection:syndication'); ?></h4>
  <em><?php echo elgg_echo('widgets_collection:syndication:help'); ?></em>
  
	<p>
		<?php echo elgg_echo('widgets_collection:rss'); ?>
		<input type="text" name="params[widgets_collection_rss]" value="<?php echo htmlentities($vars['entity']->widgets_collection_rss); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:rss:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:rss'); ?>
		<input type="text" name="params[widgets_collection_rss2]" value="<?php echo htmlentities($vars['entity']->widgets_collection_rss2); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:rss:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:rss'); ?>
		<input type="text" name="params[widgets_collection_rss3]" value="<?php echo htmlentities($vars['entity']->widgets_collection_rss3); ?>" /><br />	
		<em><?php echo elgg_echo('widgets_collection:rss:help'); ?></em>
  </p>
  
  <br />
  
	<h4><?php echo elgg_echo('widgets_collection:sites'); ?></h4>
  <em><?php echo elgg_echo('widgets_collection:sites:help'); ?></em>
  
	<p>
		<?php echo elgg_echo('widgets_collection:site'); ?>
		<input type="text" name="params[widgets_collection_site]" value="<?php echo htmlentities($vars['entity']->widgets_collection_site); ?>" /><br />	
    <em><?php echo elgg_echo('widgets_collection:site:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:site'); ?>
		<input type="text" name="params[widgets_collection_site2]" value="<?php echo htmlentities($vars['entity']->widgets_collection_site2); ?>" /><br />	
    <em><?php echo elgg_echo('widgets_collection:site:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:site'); ?>
		<input type="text" name="params[widgets_collection_site3]" value="<?php echo htmlentities($vars['entity']->widgets_collection_site3); ?>" /><br />	
    <em><?php echo elgg_echo('widgets_collection:site:help'); ?></em>
  </p>
  
  <br />
  
	<h4><?php echo elgg_echo('widgets_collection:mails'); ?></h4>
  <em><?php echo elgg_echo('widgets_collection:mails:help'); ?></em>
  
	<p>
		<?php echo elgg_echo('widgets_collection:mail'); ?>
		<input type="text" name="params[widgets_collection_mail]" value="<?php echo htmlentities($vars['entity']->widgets_collection_mail); ?>" /><br />	
    <em><?php echo elgg_echo('widgets_collection:mail:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:mail'); ?>
		<input type="text" name="params[widgets_collection_mail2]" value="<?php echo htmlentities($vars['entity']->widgets_collection_mail2); ?>" /><br />	
    <em><?php echo elgg_echo('widgets_collection:mail:help'); ?></em>
  </p>
	<p>
		<?php echo elgg_echo('widgets_collection:mail'); ?>
		<input type="text" name="params[widgets_collection_mail3]" value="<?php echo htmlentities($vars['entity']->widgets_collection_mail3); ?>" /><br />	
    <em><?php echo elgg_echo('widgets_collection:mail:help'); ?></em>
  </p>
