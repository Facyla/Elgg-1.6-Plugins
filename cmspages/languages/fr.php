<?php
$french = array(
  'cmspages' => "Pages statiques (CMS)",
  'item:object:cmspage' => 'Pages statiques',
  
  'cmspages:pagetype' => "Nom de la page (pour l'URL)",
  'cmspages:cmspage_url' => "URL de la page publiée :",
  'cmspages:pageselect' => "Choix de la page à éditer",
  
  'cmspages:new' => "OK",
  'cmspages:newpage' => "Créer la page \"%s\"",
  'cmspages:createmenu' => "Création d'une nouvelle page",
  'cmspages:newtitle' => "Cliquer pour choisir le titre de la nouvelle page",
  'cmspages:settitle' => "Cliquer pour modifier le titre",
  'cmspages:create' => "Créer la page !",
  'cmspages:save' => "Mettre à jour la page",
  'cmspages:preview' => "Aperçu",
  'cmspages:delete' => "Détruire la page",
  'cmspages:deletewarning' => "Attention : la destruction d\'une page est irréversible. Vous pouvez également annuler et la rendre privée pour supprimer l\'accès à cette page en perdre le contenu.", // Penser aux antislashs ici !
  'cmspages:showinstructions' => "Afficher les explications détaillées",
  'cmspages:instructions' => "Utilisation des pages statiques :<ul>
      <li>ces pages sont accessibles via une URL spécifique (par ex. mainpage)</li>
      <li>elles sont éditables par tout administrateur du site (global et local)</li>
      <li>elles peuvent être intégrées à l'interface du site (lien depuis le menu, le pied de page, etc.)</li>
      <li>leur création/mise à jour ne génère pas l'envoi de notification</li>
      <li>la modification d'une page prend effet immédiatemment, et il n'y a pas d'historique des modifications : attention à ne pas \"vider\" les pages (les pages sans titre ni contenus sont autorisées)</li>
      <li>elles intègrent divers niveaux d'accès selon l'utilisation à en faire : public, connecté, et privé (brouillon)</li>
      <li>pour créer une nouvelle page :
        <ol>
          <li>cliquer sur \"+\"</li>
          <li>saisir le nom qui va apparaître dans l'URL (ce nom ne pourra pas être changé par la suite)</li>
          <li>appuyer sur la touche Entrée (si Javascript est désactivé, cliquer sur le bouton) pour accéder au formulaire d'édition de la nouvelle page</li>
          <li>compléter le formulaire, puis cliquer sur \"Créer la page !\"</li>
        </ol>
        <strong>Attention :</strong> utilisez exclusivement des <strong>caractères alphanumériques en minuscule</strong> dans ce titre de page, <strong>sans espace ni accent ni signe de ponctuation</strong> (restent seuls autorisés : \"-\", \"_\" et \".\")</strong>
      </li>
    </ul>",
  
  /* Status messages */
  'cmspages:posted' => "La page statique a bien été mise à jour.",
  'cmspages:deleted' => "La page statique a bien été supprimée.",
  
  /* Error messages */
  'cmspages:nopreview' => "Aucun aperçu disponible pour le moment",
  'cmspages:notset' => "Cette page n'existe pas, ou vous devez vous connecter pour pouvoir y accéder.",
  'cmspages:delete:fail' => "Un problème est survenu lors de la suppression de la page",
  'cmspages:error' => "Une erreur est survenue, merci de réessayer, ou de contacter l'administrateur si le problème persiste",
  'cmspages:unsettooshort' => "Nom (pour l'URL) de la page non défini ou trop court (minimum : 2 caractères)",
  
  'cmspages:pagescreated' => "%s pages créées",
  
  /* Settings */
  'cmspages:settings:layout' => "Choix de la mise en page par défaut",
  'cmspages:settings:layout:help' => "Ce paramètre permet d'utiliser la configuraiton d'externalblog, si le plugin est activé. Si vous ne savez pas quoi choisir, laissez le choix par défaut.",
  'cmspages:settings:layout:default' => "Par défaut",
  'cmspages:settings:layout:externalblog' => "Utiliser la config d'externalblog",
  'cmspages:settings:editors' => "Editeurs ayant accès à cet outil",
  'cmspages:settings:editors:help' => "Liste des GUID des utilisateurs ayant accès au CMS, séparés par des virgules. Notez que ces éditeurs s'ajoutent aux administrateurs.",
  
);
    
add_translation("fr",$french);

