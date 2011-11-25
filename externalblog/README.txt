Ajout de nouveaux layouts :

1. créer les nouveaux fichiers sur le modèle de "one_colum" ou "right_column" dans  mod/externalblog/views/default/canvas/layouts/

2. ajouter une nouvelle entrée du nouveau layout (sans le ".php"), dans le tableau $layout_options du fichier mod/externalblog/views/default/settings/externalblog/edit.php (sur le modèle des autres entrées)

3. ajouter un nouveau cas pour le "switch" dans mod/externalblog/index.php (fin de fichier)

4. faire un "upgrade.php" pour prendre en compte les nouvelles vues ainsi créées


IMPORTANT : NE PAS toucher aux layouts existants qui ont été modifiés pour avoir un affichage propre en mode déconnecté sans détruire l'interface en mode connecté : two_column_left_sidebar.php, two_column_right_sidebar.php, sidebar_boxes.php. Ne pas oublier qu'une vue remplace les autres dès que le plugin est activé !

NOTE : pour des raisons historiques et par soucis de cohérence avec les layouts existants, l' $areaN correspondant au contenu est $area2, et le menu/sidebar $area1 ; les autres sont numérotés en suivant.


Logique de nommage des ID des DIV correspondant aux blocs des layouts :
- externalblog_main : contient le blog dont les articles sont sépérés par le "séparateur", et est précédé du "wrapper" haut et bas
- externalblog_two : sidebar, ou bloc configurable
- externalblog_three : bloc configurable
- externalblog_four : bloc configurable
- externalblog_five : bloc configurable
=> style à régler via les CSS (pour les diverses paginations sauf right_column - forcé à 30% largeur)


