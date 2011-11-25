<?php
$german = array(
 
  'cmspages' => "Statische Seiten (CMS)",
  'item:object:cmspages' => 'Statische Seiten',
 
  'cmspages:pagetype' => "Name der Seiten-URL",
  'cmspages:cmspage_url' => "&Ouml;ffentliche Seiten-URL :",
  'cmspages:pageselect' => "Zu &auml;ndernde Seite w&auml;hlen",
 
  'cmspages:new' => "OK",
  'cmspages:newpage' => "Neue Seite erstellen: \"%s\"",
  'cmspages:createmenu' => "Neue Seite erstellen",
  'cmspages:newtitle' => "Klicken, um den Seitentitel auszuw&auml;hlen",
  'cmspages:settitle' => "Klicken, um den Seitentitel zu &auml;ndern",
  'cmspages:create' => "Seite erstellen !",
  'cmspages:save' => "Seite updaten",
  'cmspages:preview' => "Vorschau",
  'cmspages:delete' => "Seite löschen",
  'cmspages:deletewarning' => "Achtung : Sie k&ouml;nnen eine gel&ouml;schte Seite nicht wiederherstellen. Eine bessere M&ouml;glichkeit w&auml;re, daß Sie den L&ouml;schvorgang abbrechen und den Zugriff anschlie&szlig;end auf \"Privat\" stellen, um den Inhalt nicht zu verlieren!", // Adds backslashes if you use "'" !  (ex.: can\'t)
  'cmspages:showinstructions' => "Detaillierte Beschreibung anzeigen",
  'cmspages:instructions' => "<br>Wie erstellt man statische Seiten?<br><br>Folgende Optionen stehen zur Verf&uuml;gung:<br><br><ul>
      <li>eine aussagekr&auml;ftige Seiten-Url (Z.B. Startseite)</li>
      <li>sind von jedem Admin zu &auml;ndern (auch der lokale Admin im Multi-Site-Kontext)</li>
      <li>kann vom der Hauptnavigation verkn&uuml;pft werden</li>
      <li>produzieren keine Meldungen</li>
      <li>&Auml;nderungen werden sofort wirksam, folgedessen gibt es aber keinen Verlauf! Pr&uuml;fen Sie auch vor dem Speichern auf leere Felder (leere Felder sind grunds&auml;tzlich erlaubt)</li>
      <li>Zugriffs-Level k&ouml;nnen f&uuml;r jede Seite gesetzt werden</li>
      <li>Wie erstelle ich eine Seite:
        <ol>
          <li>auf \"+\" klicken</li>
          <li>Seiten-URL eingeben (kann nicht ge&auml;ndert werden)</li>
          <li>Enter-Taste dr&uuml;cken (wenn Sie Javascript deaktiviert haben: Button dr&uuml;cken)</li>
          <li>Formular ausf&uuml;llen und den \"Seite erstellen\"-Button dr&uuml;cken</li>
        </ol>
        <strong>Achtung :</strong> Der URL-Seitenname akzeptiert nur <strong>alphanumerische Zeichen, keine Leerzeichen und auch keine Zeichen wie: \"-\", \"_\" und \".\"</strong>
      </li>
    </ul>",
 
  /* Status messages */
  'cmspages:posted' => "Die Seite wurde erfolgreich upgedatet.",
  'cmspages:deleted' => "Die statische Seite wurde erfolgreich gel&ouml;scht.",
 
  /* Error messages */
  'cmspages:nopreview' => "Keine Vorschau vorhanden",
  'cmspages:notset' => "Diese Seite existiert noch nicht oder Sie m&uuml;ssen sich erst einloggen, um sie sehen zu k&ouml;nnen!",
  'cmspages:delete:fail' => "Es gab ein Problem beim L&ouml;schen der Seite",
  'cmspages:error' => "Es ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut! Wenn das Problem weiterhin besteht, kontaktieren Sie bitte den Administrator!",
  'cmspages:unsettooshort' => "Name der Seiten-URL undefiniert oder zu kurz (mindestens 2 Zeichen)",
  
  'cmspages:pagescreated' => "gesamt: %s Seite",
  
  /* Settings */
  'cmspages:settings:layout' => "Layout",
  'cmspages:settings:layout:help' => "Use default layout, or externalblog layout parameters ? I you have no idea or do not use externalblog plugin, let default choice.",
  'cmspages:settings:layout:default' => "Default",
  'cmspages:settings:layout:externalblog' => "Use externablog layout config",
  'cmspages:settings:editors' => "Additional editors",
  'cmspages:settings:editors:help' => "List of GUID, separated by commas. These editors are allowed to edit even if they're not admin, in addition to the admins (who have edit access on cmspages anyway).",
 
);
 
add_translation("de",$german);
