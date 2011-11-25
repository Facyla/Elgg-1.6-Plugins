<?php
/**
 * Subscriber
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Fabrice Collette
 * this plugin has been founded by Fondation Maison des Sciences de l'Homme - Paris	 
 * @copyright Fabrice Collette 2010
 * @link http://www.meleze-conseil.com
 * @update Facyla 2010
 */


$french = array(
  // Owner block action links
  'subscribe:owner_block_menu' => "Notifications",
  'subscribe:owner_block_menu:subscribe' => "Suivre",
  'subscribe:owner_block_menu:unsubscribe' => "Ne plus suivre",
  'subscribe:owner_block_menu:user' => "Suivre ce membre",
  'subscribe:owner_block_menu:unsubscribe:user' => "Ne plus suivre ce membre",
  'subscribe:owner_block_menu:group' => "Suivre ce groupe",
  'subscribe:owner_block_menu:unsubscribe:group' => "Ne plus suivre ce groupe",
  'subscribe:owner_block_menu:site' => "Suivre ce site",
  'subscribe:owner_block_menu:unsubscribe:site' => "Ne plus suivre ce site",
  
  // Settings
  'subscribe:yes' => "Oui",
  'subscribe:no' => "Non",
  'subscribe:settings:activatewidgets' => "Activer les widgets \"Abonnements\" et  \"Abonnés\" ?",
  'subscribe:settings:defaultnotifyemail' => "Activer automatiquement les notifications par mail lorsqu'un utilisateur rejoint un groupe ?",
  'subscribe:settings:defaultsitenotifyemail' => "Activer automatiquement les notifications par mail lorsqu'un utilisateur rejoint un site ?",
  'subscribe:settings:popupongroupjoin' => "Ouvrir une popup de gestion des notifications suite à l'inscription dans un groupe ?",
  'subscribe:settings:popuponsitejoin' => "Ouvrir une popup de gestion des notifications suite à l'inscription dans un site ?",
  
  // System messages
  'subscribe:notifications:single:subscriptions:description' => "En vous abonnant aux publications de '%s', vous serez informé chaque fois qu'il/elle postera un nouveau contenu sur le site.  Choisissez comment vous souhaitez être informé(e) :",
  'subscribe:notifications:single:subscriptions:description:group' => "En vous abonnant aux publications du groupe '%s', vous serez informé chaque fois qu'un nouveau contenu sera publié dans ce groupe. Choisissez comment vous souhaitez être informé(e) :",
  'subscribe:notifications:single:subscriptions:description:site' => "En vous abonnant aux publications du site '%s', vous serez informé chaque fois qu'un nouveau contenu sera publié dans ce site. Choisissez comment vous souhaitez être informé(e) :",
  
  // Widgets strings
  'subscribe:subscribers:widget:title' => "Abonnés",
  'subscribe:subscribers:widget:description' => "Affiche les membres abonnés à vos contenus",
  'subscribe:icon_size' => "Taille des icônes",
  'subscribe:subscribed:widget:title' => "Abonnements",
  'subscribe:subscribed:widget:description' => "Affiche les membres dont vous suivez les contenus",
  'subscribe:num_display' => "Nombre à afficher",
  
  // Notification message
  'subscribe:notify:subject' => "%s s'est abonné(e) à vos publications",
  'subscribe:notify:message' => "%s s'est abonné à vos publications. Il(elle) sera maintenant informé(e) à chaque fois que vous publierez un nouveau contenu. Cependant, il/elle n'aura accès aux contenus qu'en fonction de votre choix de niveau d'accès quand vous postez un nouveau contenu.

Vous pouvez consulter son profil ici :

%s",


);
        
add_translation("fr",$french);

