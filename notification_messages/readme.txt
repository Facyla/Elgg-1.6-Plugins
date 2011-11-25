lang:fr
Installation :
Copier le dossier du plugin dans le dossier /mod puis l'éctiver via le panneau d'administration. Placer le plugin à la fin de la liste, ou du moins après les plugins dont il modifie le comportement : groups, messages, bookmarks, pages, blog, etc.

Comment vérifier que le plugin fonctionne ?
Vérifier le titre (et le corps des messages) des notifications envoyées : si elles diffèrent de celles par défaut, c'est bon !

0.4 TODO :
  - Ne peut-on même supprimer la mention "(vous pouvez avoir besoin de vous identifier sur le site pour accéder au contenu en ligne)" dans le cas où l'article est public ?
  - les guillemets simples autours du nom du groupe et du titre de l'objet (article, document, etc.) n'apportent pas grand chose et n'améliorent pas beaucoup la lisibilité => je mettrai le nom du groupe en gras et je mettrai pour le titre de l'objet :
    - soit de l'italique (mais pas de souligné, à réserver plutôt pour le liens),
    - soit même carrément le lien vers l'article ; du coup on pourrait même virer "Pour y accéder ......................." ; cette solution à ma préférence
  - Ou peut-être serait même plus utile de préciser qu'on peut commenter ça : "Pour commenter ou voir les éventuels commentaires de cet article, retrouvez-le en ligne."
  => mais garder les liens URL visibles (lecture texte et mobile)

0.3 Différenciation des messages selon les types d'édition, HTML

0.2 Correction des variables (bon éditeur et owner)

0.1 Interception des notifications


Events levés selon les actions effectuées :
- Forum : create/update annotation 'group_topic_post' (PAS create object qui ne crée que le titre vide)
- Page : create/update object, puis create/update annotation 'page' (au choix - le contenu est dans les 2)
- Tout autre type d'object : create/update object

Trigger elgg event :
create object
update object
commentaire => create annotation
édition commentaire => update annotation



##########################################
lang:en
Installation :
Put into mod and enable in the admin panel. Place as the bottom of the list, as it overrides several plugins behaviours.

How to confirm the plugin is working ?
Check the header of an email that was sent after the plugin was enabled. Title and message content should change from the default.

