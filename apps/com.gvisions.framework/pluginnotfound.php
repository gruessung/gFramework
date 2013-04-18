<?php
 /*
 gFramework Frontend
 */

 /*
 So, dann starten wir mal die TPL Engine..*brum* xP
 */
 $template = new TPL();
 $template->menuid = 1;
 $template->sitename = "Nicht gefunden";
 $template->text = "Es ist ein Fehler aufgetreten:<br><li>die geforderte Anwendung ist deaktiviert, oder</li><li>die Anwendung konnte nicht gefunden werden, oder</li><li>die ID ist mehrmals vergeben und konnte nicht zugeordnet werden.</li>";
 $template->show();
