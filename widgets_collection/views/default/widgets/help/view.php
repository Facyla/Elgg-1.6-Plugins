<?php
/**
 * help plugin.
 */

global $CONFIG;
$url = $CONFIG->mainsiteurl;

$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
  set_page_owner($page_owner->getGUID());
}

$body = '';

$body .= '<div class="anytext_container contentWrapper">';
  $body .= '<div class="anytext_body">';
    
    $body .= '<p>Cette plateforme \'sociale\' vous permet d\'échanger dans des groupes publics ou privés, autour de centres d\'intérêt partagés avec d\'autres acteurs des TIC, de la formation, de l\'orientation et de l\'emploi tout au long de la vie, et tous ceux que ces sujets intéressent !</p>';
    $body .= '<em>Cliquez pour ouvrir les rubriques d\'aide</em>';
    
    
    // Par où commencer ?
    $body .= '<h4><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#helpwidget_mainhelp\').toggle();">Par où commencer ?</a></h4>';
    $body .= '<div id="helpwidget_mainhelp" style="display:none;">';
      $body .= '<p>Si vous ne savez pas par où commencer, consultez la <a href="' . $url . 'pg/expages/read/FormaVia/">Présentation de FormaVia</a> et le <a href="' . $url . 'pg/pages/view/249/">Guide de démarrage</a> (pensez à naviguer dans les différentes pages de l\'aide via le menu sur la gauche). Si vous ne trouvez pas de réponse satisfaisante, vous pouvez vous adresser au <a href="' . $url . 'pg/groups/109/">Forum du Réseau</a> : posez votre question dans le Forum : vous serez prévenu par mail des réponses apportées.</p>';
      $body .= '<p>Pour signaler un "bug" ou un contenu litigieux ou inapproprié, utilisez le bouton <strong>"Feedback"</strong> ci-contre à gauche (ou par mail <a href="mailto:elgg@formavia.fr?subject=[Feedback FormaVia] Demande concernant ...">elgg@formavia.fr</a>).</p>';
      $body .= '<p>Pour toute autre demande d\'aide directe, de conseils précis sur l\'utilisation de la plateforme, ou si votre question est confidentielle, vous pouvez également utiliser le "Feedback", ou contacter directement l\'<a href="' . $url . 'pg/profile/Facyla">administrateur du site</a> via <a href="mailto:elgg@formavia.fr?subject=[Feedback FormaVia] Demande concernant ...">elgg@formavia.fr</a>.</p>';
    $body .= '<hr class="separator" /></div>';
    
    
    // Premiers pas et visite guidée
    $body .= '<h4><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#helpwidget_guidedtour\').toggle();">Premiers pas et Visite guidée du site</a></h4>';
    $body .= '<div id="helpwidget_guidedtour" style="display:none;">';
      $body .= '<p>Ce lien vous permet d\'accéder à un rapide parcours sur le site. Vous pourrez à tout moment quitter ce guide, le recommencer depuis le début, ou aller directement à la partie qui vous intéresse&nbsp;:
        <ul>
          <li>éditer votre page de profil</li>
          <li>choisir une image pour votre profil</li>
          <li>régler les paramètres de votre compte</li>
          <li>découvrir les principales zones du site et leur utilisation : annuaire, exploration des communautés, espace personnel</li>
        </ul>
        <a href="' . $url . 'pg/first_time_events/startup">&rarr;&nbsp;Commencer la visite : Premiers pas</a> et Visite guidée du site</a><br />
        <a href="' . $url . 'pg/first_time_events/tourintro">&rarr;&nbsp;Aller directement à la Visite guidée du site</a>
        </p>';
    $body .= '<hr class="separator" /></div>';
    
    
    // La Conciergerie : RV du jeudi 12h-13h
    $body .= '<h4><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#helpwidget_conciergerie\').toggle();">La Conciergerie du jeudi</a></h4>';
    $body .= '<div id="helpwidget_conciergerie" style="display:none;">' . elgg_view('cmspages/view', array('pagetype' => "accueil_conciergerie")) . '<hr class="separator" /></div>';
        
    // Mode d'emploi : s'inscrire, participer, partager, C2i, communautés...
    $body .= '<h4><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#helpwidget_modedemploi\').toggle();">Mode d\'emploi</a></h4>';
    $body .= '<div id="helpwidget_modedemploi" style="display:none;">' . elgg_view('cmspages/view', array('pagetype' => "accueil_modedemploi")) . '<hr class="separator" /></div>';
    
    // Tutoriel vidéo
    $body .= '<h4><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#helpwidget_tutoriel\').toggle();">Tutoriel FormaVia</a></h4>';
    $body .= '<div id="helpwidget_tutoriel" style="display:none;"><iframe frameborder="0" width="260" height="190" src="http://www.dailymotion.com/embed/video/xbwh5f?width=260&theme=none&amp;foreground=%2358234E&amp;highlight=%2385208E&amp;background=%23FFFFFF&amp;wmode=transparent"></iframe><br /><a href="http://www.dailymotion.com/video/xbwh5f_s-inscrire-sur-formavia-elgg_school" target="_blank">&rarr;&nbsp;Tous les tutoriels vidéo</a></i><hr class="separator" /></div>';
    
    // FAQ : questions-réponses et poser une question dans le forum
    $body .= '<h4><a href="javascript:void(0);" class="inline_toggler" onclick="$(\'#helpwidget_faq\').toggle();">FAQ</a></h4>';
    $body .= '<div id="helpwidget_faq" style="display:none;">' . elgg_view('cmspages/view', array('pagetype' => "accueil_faq")) . '<hr class="separator" /></div>';
    
    // Contacts
    $body .= '<h4><a href="' . $url . 'pg/expages/read/About/#contacts" title="Contacts du réseau FormaVia">Contacts FormaVia</a></h4>';
    
  $body .= '</div>';
$body .= '</div>';

echo $body;
